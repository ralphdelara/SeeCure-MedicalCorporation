<?php

namespace App\Services;

use App\Enums\BillingTypeEnum;
use App\Models\BillingDetail;
use App\Models\BillingSupplies;
use Auth;

class BillingSuppliesService
{
    public function addOrUpdateBillingSupplies(array $billingSuppliesDetails): void
    {
        $id = $billingSuppliesDetails['id'];
        unset($billingSuppliesDetails['id']);

        if (empty($id)) {
            $billingSuppliesDetails['created_by'] = Auth::id();
        }

        $billingSuppliesDetails['last_modified_by'] = Auth::id();

        BillingSupplies::updateOrCreate(
            ['id' => $id],
            $billingSuppliesDetails,
        );
    }

    public function addBillingSuppliesItem(array $billingSuppliesItems): void
    {
        BillingDetail::create([
            'billing_id'       => $billingSuppliesItems['billing_id'],
            'billing_type_id'  => BillingTypeEnum::SUPPLIES,
            'name'             => $billingSuppliesItems['name'],
            'cost_price'       => $billingSuppliesItems['cost_price'],
            'quantity'         => $billingSuppliesItems['quantity'],
            'total_price'      => $billingSuppliesItems['total_price'],
            'nett_price'       => $billingSuppliesItems['total_price'],
            'created_by'       => Auth::id(),
            'last_modified_by' => Auth::id(),
        ]);

        app(BillingService::class)->recomputeBillingTotals($billingSuppliesItems['billing_id']);
    }
}
