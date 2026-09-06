<?php

namespace App\Services;

use App\Models\Inventory;
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
                $query->select('id', 'first_name', 'last_name');
            },
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
}
