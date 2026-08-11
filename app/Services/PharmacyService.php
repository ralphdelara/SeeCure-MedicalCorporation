<?php

namespace App\Services;

use App\Models\Product;
use Arr;
use Illuminate\Support\Facades\Auth;

class PharmacyService
{
    public function getProductList(
        ?string $keyword,
        ?string $selectId,
        string $path,
    ): array {
        $productList = Product::with([
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
            $productList = $productList->whereLike('name', '%'.$keyword.'%');
        }

        if (! empty($selectId)) {
            $productList = $productList->where('product_category_id', $selectId);
        }

        $productList = $productList->orderBy('name')->paginate(50)
            ->withPath('/'.$path)->withQueryString();
        $tableData = $productList->collect()->toArray();
        $pageData = Arr::except($productList->toArray(), ['data']);
        $links = app(PageService::class)->limitLinks($productList, 5);
        $pageData['links'] = $links;

        return compact(
            'tableData',
            'pageData',
        );
    }

    public function addOrUpdateProduct(array $productDetails): void
    {
        if (! empty($productDetails['id'])) {
            $productDetails['last_modified_by'] = Auth::id();
        } else {
            $productDetails['stock'] = 0;
            $productDetails['created_by'] = Auth::id();
        }
        Product::updateOrCreate(
            ['id' => $productDetails['id']],
            $productDetails,
        );
    }
}
