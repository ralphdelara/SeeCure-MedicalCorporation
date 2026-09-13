<?php

namespace App\Listeners;

use App\Enums\AuditTypeEnum;
use App\Enums\StockMovementTypeEnum;
use App\Events\InventoryStockMovementSaved;
use App\Models\InventoryAudit;
use App\Models\InventoryStockMovement;
use Carbon\Carbon;
use Crypt;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Auth;

class LogInventoryStockMovementSave implements ShouldQueue
{
    /**
     * Handle the event.
     */
    public function handle(InventoryStockMovementSaved $event): void
    {
        $stockMovement = $event->stockMovement->loadMissing('inventory');
        $type = $event->type;
        $savedFields = $event->savedFields;
        $originalFields = $event->originalFields;

        $data = match ($type) {
            'created' => $this->created($stockMovement),
            'updated' => $this->updated($stockMovement, $savedFields, $originalFields),
            'deleted' => $this->deleted($stockMovement),
        };

        $auditType = match ($type) {
            'created' => AuditTypeEnum::ADD,
            'updated' => AuditTypeEnum::UPDATE,
            'deleted' => AuditTypeEnum::DELETE,
        };

        InventoryAudit::create([
            'inventory_id'  => $stockMovement->inventory->id,
            'audit_type_id' => $auditType,
            'data'          => json_encode($data),
            'created_by'    => Auth::id(),
        ]);
    }

    private function created(InventoryStockMovement $stockMovement): array
    {
        $fields = [];
        $stockMovementData = $stockMovement->toArray();
        $this->removeUnimportantFields($stockMovementData);

        foreach ($stockMovementData as $key => $data) {
            if ($key === 'stock_movement_type_id') {
                $key = 'stock_movement_type';
                $data = StockMovementTypeEnum::tryFrom($data)->description();
            }

            $fields[] = [
                'field' => $key,
                'from'  => null,
                'to'    => $data,
            ];
        }

        return [
            'title'  => 'Stock Movement has been added.',
            'fields' => $fields,
        ];
    }

    private function updated(
        InventoryStockMovement $stockMovement,
        array $savedFields,
        array $originalFields,
    ): array {
        $fields = [];
        $this->removeUnimportantFields($savedFields);

        foreach ($savedFields as $field => $newValue) {
            $oldValue = $originalFields[$field];

            if ($stockMovement->hasCast($field, 'encrypted')) {
                try {
                    $newValue = Crypt::decryptString($newValue);
                } catch (DecryptException $e) {
                }
            }

            $castType = $stockMovement->getCasts()[$field] ?? '';
            $isDate = str_starts_with($castType, 'date') || str_starts_with($castType, 'datetime');

            if ($isDate) {
                // Safely extract the format or fall back to your default string template
                $format = str_contains($castType, ':')
                    ? explode(':', $castType, 2)[1]
                    : 'M d Y, h:i:s a';

                // Safely parse and convert values with Carbon
                if ($oldValue) {
                    $oldValue = Carbon::parse($oldValue)->format($format);
                }
                if ($newValue) {
                    $newValue = Carbon::parse($newValue)->format($format);
                }
            }

            if ($field === 'stock_movement_type_id') {
                $field = 'stock_movement_type';
                $oldValue = StockMovementTypeEnum::tryFrom($oldValue)->description();
                $newValue = StockMovementTypeEnum::tryFrom($newValue)->description();
            }

            $fields[] = [
                'field' => $field,
                'from'  => $oldValue,
                'to'    => $newValue,
            ];
        }

        return [
            'title'  => 'Stock Movement has been updated.',
            'fields' => $fields,
        ];
    }

    private function deleted(InventoryStockMovement $stockMovement): array
    {
        $fields = [];
        $stockMovementData = $stockMovement->toArray();
        $this->removeUnimportantFields($stockMovementData);

        foreach ($stockMovementData as $key => $data) {
            if ($key === 'stock_movement_type_id') {
                $key = 'stock_movement_type';
                $data = StockMovementTypeEnum::tryFrom($data)->description();
            }

            $fields[] = [
                'field' => $key,
                'from'  => null,
                'to'    => $data,
            ];
        }

        return [
            'title'  => 'Stock Movement has been deleted.',
            'fields' => $fields,
        ];
    }

    private function removeUnimportantFields(array &$fields): void
    {
        $exclude = [
            'inventory_id', 'inventory',
            'created_by', 'created_at',
            'last_modified_by', 'updated_at',
        ];

        foreach ($exclude as $key) {
            unset($fields[$key]);
        }
    }
}
