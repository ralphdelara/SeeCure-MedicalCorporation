<?php

namespace App\Listeners;

use App\Enums\AuditTypeEnum;
use App\Events\InventorySaved;
use App\Models\Inventory;
use App\Models\InventoryAudit;
use Carbon\Carbon;
use Crypt;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Auth;

class LogInventorySave implements ShouldQueue
{
    /**
     * Handle the event.
     */
    public function handle(InventorySaved $event): void
    {
        $inventory = $event->inventory;
        $type = $event->type;
        $savedFields = $event->savedFields;
        $originalFields = $event->originalFields;

        if ($type === 'created') {
            $data = $this->created($inventory);
        } else {
            $data = $this->updated($inventory, $savedFields, $originalFields);
        }

        InventoryAudit::create([
            'inventory_id' => $inventory->id,
            'audit_type_id' => $type === 'created' ? AuditTypeEnum::ADD : AuditTypeEnum::UPDATE,
            'data'          => json_encode($data),
            'created_by'    => Auth::id(),
        ]);
    }

    private function created(Inventory $inventory): array
    {
        $inventory->getAttributes();

        return [
            'title'  => 'Inventory has been added.',
            'fields' => [],
        ];
    }

    private function updated(
        Inventory $inventory,
        array $savedFields,
        array $originalFields,
    ): array {
        $fields = [];

        foreach ($savedFields as $field => $newValue) {
            $oldValue = $originalFields[$field];

            if ($inventory->hasCast($field, 'encrypted')) {
                try {
                    $newValue = Crypt::decryptString($newValue);
                } catch (DecryptException $e) {
                }
            }

            $castType = $inventory->getCasts()[$field] ?? '';
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

            $fields[] = [
                'field' => $field,
                'from'  => $oldValue,
                'to'    => $newValue,
            ];
        }

        return [
            'title'  => 'Inventory has been updated.',
            'fields' => $fields,
        ];
    }
}
