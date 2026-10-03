<?php

namespace App\Http\Controllers;

use App\Models\BillingSupplies;
use App\Services\BillingSuppliesService;
use Illuminate\Http\Request;

class BillingSuppliesController extends Controller
{
    public function addOrUpdateBillingSupplies(Request $request): void
    {
        $billingSuppliesDetails = $request->only('id', 'name', 'cost_price', 'stock');
        app(BillingSuppliesService::class)->addOrUpdateBillingSupplies($billingSuppliesDetails);
    }

    public function addBillingSuppliesItem(Request $request): void
    {
        $billingSuppliesItems = $request->only('id', 'billing_id', 'billing_supplies_id', 'name', 'cost_price', 'quantity', 'total_price');

        app(BillingSuppliesService::class)->addBillingSuppliesItem($billingSuppliesItems);
    }

    public function deleteBillingSupply(string $id): void
    {
        BillingSupplies::where('id', $id)->delete();
    }
}
