<?php

namespace App\Services;

use App\Enums\StockMovementTypeEnum;
use App\Events\InventoryViewed;
use App\Models\Inventory;
use App\Models\InventoryAudit;
use App\Models\InventoryStockMovement;
use Arr;
use Illuminate\Support\Facades\Auth;

class InventoryService
{
    public function getInventoryList(
        ?string $keyword,
        ?string $selectId,
        string $path,
    ): array {
        $inventoryList = Inventory::with([
            'createdBy' => function ($query) {
                $query->select('id', 'first_name', 'middle_name', 'last_name');
            },
            'createdBy.professions',
            'createdBy.specialties',
            'lastModifiedBy' => function ($query) {
                $query->select('id', 'first_name', 'middle_name', 'last_name');
            },
            'lastModifiedBy.professions',
            'lastModifiedBy.specialties',
            'lastModifiedBy',
            'unit' => function ($query) {
                $query->select('id', 'name');
            },
            'category' => function ($query) {
                $query->select('id', 'name');
            },
        ]);

        if (! empty($keyword)) {
            $inventoryList = $inventoryList->whereLike('name', '%'.$keyword.'%');
        }

        if (! empty($selectId)) {
            $inventoryList = $inventoryList->where('inventory_category_id', $selectId);
        }

        $inventoryList = $inventoryList->orderBy('name')->paginate(50)
            ->withPath('/'.$path)->withQueryString();
        $tableData = $inventoryList->collect()->toArray();
        $pageData = Arr::except($inventoryList->toArray(), ['data']);
        $links = app(PageService::class)->limitLinks($inventoryList, 5);
        $pageData['links'] = $links;

        return compact(
            'tableData',
            'pageData',
        );
    }

    public function addOrUpdateInventory(array $inventoryDetails): void
    {
        if (! empty($inventoryDetails['id'])) {
            $inventoryDetails['last_modified_by'] = Auth::id();
        } else {
            $inventoryDetails['stock'] = 0;
            $inventoryDetails['created_by'] = Auth::id();
        }
        Inventory::updateOrCreate(
            ['id' => $inventoryDetails['id']],
            $inventoryDetails,
        );
    }

    public function getSmallInventoryList(array $requestDetails): array
    {
        $inventory = Inventory::with([
            'category',
            'unit',
        ])
            ->select('id', 'name', 'stock', 'inventory_unit_id', 'inventory_category_id');

        if (! empty($requestDetails['keyword'])) {
            $inventory = $inventory->whereLike('name', '%'.$requestDetails['keyword'].'%');
        }

        if (! empty($requestDetails['category_id'])) {
            $inventory = $inventory->where('inventory_category_id', '=', $requestDetails['category_id']);
        }

        $inventory = $inventory->where('stock', '>', 0)->orderBy('name')->limit(50)
            ->get();

        return $inventory->toArray();
    }

    public function getInventoryDetails(string $id): array
    {
        abortIfInvalidUuid($id);

        $inventory = Inventory::with([
            'category',
            'unit',
            'audits',
            'stockMovement',
            'stockMovement.stockMovementType',
            'stockMovement.createdBy' => function ($query) {
                $query->select('id', 'first_name', 'middle_name', 'last_name');
            },
            'stockMovement.createdBy.professions',
            'stockMovement.createdBy.specialties',
            'stockMovement.lastModifiedBy' => function ($query) {
                $query->select('id', 'first_name', 'middle_name', 'last_name');
            },
            'stockMovement.lastModifiedBy.professions',
            'stockMovement.lastModifiedBy.specialties',
        ])->find($id);

        if (empty($inventory)) {
            abort(404);
        }

        InventoryViewed::dispatch($inventory);

        return $inventory->toArray();
    }

    public function addOrUpdateStockMovement(
        string $inventoryId,
        array $stockMovementDetails,
    ): void {
        $isUpdate = ! empty($stockMovementDetails['stock_movement_id']);
        $inventory = Inventory::find($inventoryId);

        if ($isUpdate) {
            $stockMovement = InventoryStockMovement::find($stockMovementDetails['stock_movement_id']);
            $currentStock = $stockMovement->current_stock;
        } else {
            $currentStock = $inventory->stock;
            $stockMovementDetails['created_by'] = Auth::id();
        }

        $newCostPrice = $stockMovementDetails['cost_price'];
        $newQuantity = $stockMovementDetails['quantity'];
        $newTotalPrice = $newCostPrice * $newQuantity;
        $stockMovementDetails['last_modified_by'] = Auth::id();
        $newStock = $this->computeNewStock($currentStock, $newQuantity, $stockMovementDetails['stock_movement_type_id']);
        $stockMovementDetails['new_stock'] = $newStock;
        $stockMovementDetails['total_price'] = $newTotalPrice;
        $stockMovementDetails['inventory_id'] = $inventoryId;
        $stockMovementDetails['current_stock'] = $currentStock;

        if ($isUpdate) {
            $stockMovement->update($stockMovementDetails);
        } else {
            InventoryStockMovement::create($stockMovementDetails);
        }

        $inventory->update([
            'stock'            => $newStock,
            'last_modified_by' => Auth::id(),
        ]);
    }

    public function computeNewStock(float $currentStock, int|float $quantity, int $stockMovementTypeId): float
    {
        return match (StockMovementTypeEnum::tryFrom($stockMovementTypeId)) {
            StockMovementTypeEnum::STOCK_IN => $currentStock + $quantity,
            default                         => $currentStock - $quantity
        };
    }

    public function deleteStockMovement(string $inventoryId, string $stockMovementId): void
    {
        $stockMovement = InventoryStockMovement::find($stockMovementId);

        if (empty($stockMovement)) {
            abort(404);
        }

        $inventory = Inventory::find($inventoryId);

        $quantity = $stockMovement->quantity;
        $currentStock = $inventory->stock;

        if (StockMovementTypeEnum::tryFrom($stockMovement->stock_movement_type_id) === StockMovementTypeEnum::STOCK_IN) {
            // subtract added stock
            $newStock = $currentStock - $quantity;
        } else {
            $newStock = $currentStock + $quantity;
        }

        $stockMovement->delete();

        $inventory->update([
            'stock' => $newStock,
        ]);
    }

    public function getAuditLog(string $id): array
    {
        return InventoryAudit::with([
            'createdBy' => function ($query) {
                $query->select('id', 'first_name', 'middle_name', 'last_name');
            },
            'createdBy.professions',
            'createdBy.specialties',
            'auditType',
        ])
            ->select('audit_type_id', 'data', 'created_by', 'created_at')
            ->where('inventory_id', $id)
            ->orderBy('created_at', 'desc')
            ->get()->toArray();
    }

    public function getPrices(array $inventoryIds): array
    {
        return array_column(Inventory::select(
            'id',
            'selling_price_vat_exclusive',
            'selling_price_vat_inclusive',
            'vat_amount',
            'vat_percent',
        )->whereIn('id', $inventoryIds)->get()->toArray(), null, 'id');
    }
}
