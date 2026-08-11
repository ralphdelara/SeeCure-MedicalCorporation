<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\ProductUnit;
use App\Services\PharmacyService;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class PharmacyController extends Controller
{
    public function index(Request $request): Response
    {
        $productCategoryOptions = ProductCategory::all();
        $productUnitOptions = ProductUnit::all();
        $productList = app(PharmacyService::class)->getProductList(
            $request->keyword,
            $request->selectId,
            $request->path(),
        );

        return Inertia::render('pharmacy/index', compact(
            'productCategoryOptions',
            'productUnitOptions',
            'productList',
        ));
    }

    public function addOrUpdateProduct(Request $request): void
    {
        $nameValidate = 'unique:products,name';

        if (! empty($request->id)) {
            $nameValidate .= ','.$request->id;
        }

        $request->validate([
            'name'                        => 'required|'.$nameValidate,
            'product_category_id'         => 'required',
            'product_unit_id'             => 'required',
            'cost_price'                  => 'required',
            'markup_amount'               => 'required',
            'markup_percent'              => 'required',
            'vat_percent'                 => 'required',
            'vat_amount'                  => 'required',
            'selling_price_vat_exclusive' => 'required',
            'selling_price_vat_inclusive' => 'required',
        ], [
            'product_category_id.required' => 'Please select a category.',
            'product_unit_id.required'     => 'Please select a unit.',
        ]);

        app(PharmacyService::class)->addOrUpdateProduct($request->all());
    }

    public function deleteProduct(int $id):void
    {
        Product::destroy($id);
    }
}
