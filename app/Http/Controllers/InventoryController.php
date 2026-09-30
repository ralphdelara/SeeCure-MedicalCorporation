<?php

namespace App\Http\Controllers;

use App\Enums\StockMovementTypeEnum;
use App\Models\Inventory;
use App\Models\InventoryCategory;
use App\Models\InventoryUnit;
use App\Models\StockMovementType;
use App\Services\InventoryService;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class InventoryController extends Controller
{
    public function index(Request $request): Response
    {
        $inventoryCategoryOptions = InventoryCategory::all();
        $inventoryUnitOptions = InventoryUnit::all();
        $inventoryList = app(InventoryService::class)->getInventoryList(
            $request->keyword,
            $request->selectId,
            $request->path(),
        );

        return Inertia::render('inventory/index', compact(
            'inventoryCategoryOptions',
            'inventoryUnitOptions',
            'inventoryList',
        ));
    }

    public function addOrUpdateInventory(Request $request): void
    {
        $nameValidate = 'unique:inventory,name';

        if (! empty($request->id)) {
            $nameValidate .= ','.$request->id;
        }

        $request->validate([
            'name'                        => 'required|'.$nameValidate,
            'inventory_category_id'       => 'required',
            'inventory_unit_id'           => 'required',
            'cost_price'                  => 'required',
            'markup_amount'               => 'required',
            'markup_percent'              => 'required',
            'vat_percent'                 => 'required',
            'vat_amount'                  => 'required',
            'selling_price_vat_exclusive' => 'required',
            'selling_price_vat_inclusive' => 'required',
        ], [
            'inventory_category_id.required' => 'Please select a category.',
            'inventory_unit_id.required'     => 'Please select a unit.',
        ]);

        app(InventoryService::class)->addOrUpdateInventory($request->all());
    }

    public function deleteInventory(string $id): void
    {
        Inventory::destroy($id);
    }

    public function getSmallInventoryList(Request $request): array
    {
        return app(InventoryService::class)->getSmallInventoryList($request->only('keyword', 'category_id'));
    }

    public function getInventoryDetails(string $id): Response
    {
        $inventoryDetails = app(InventoryService::class)->getInventoryDetails($id);
        $inventoryCategoryOptions = InventoryCategory::all();
        $inventoryUnitOptions = InventoryUnit::all();
        $stockMovementTypeOptions = StockMovementType::where('id', '!=', StockMovementTypeEnum::STOCK_OUT_PRESCRIPTION)->get();

        return Inertia::render('inventory/details/index', compact(
            'inventoryDetails',
            'inventoryCategoryOptions',
            'inventoryUnitOptions',
            'stockMovementTypeOptions',
        ));
    }

    public function deleteStockMovement(string $inventoryId, string $stockMovementId): void
    {
        app(InventoryService::class)->deleteStockMovement($inventoryId, $stockMovementId);
    }

    public function addOrUpdateStockMovement(Request $request, string $inventoryId): void
    {
        $stockMovementDetails = $request->only(
            'inventory_id',
            'stock_movement_id',
            'stock_movement_type_id',
            'cost_price',
            'quantity',
            'lot_no',
            'manufacture_date',
            'expiry_date',
            'supplier',
            'reference_no',
        );

        app(InventoryService::class)->addOrUpdateStockMovement($inventoryId, $stockMovementDetails);
    }

    public function getAuditLog(string $id): array
    {
        return app(InventoryService::class)->getAuditLog($id);
    }
}
