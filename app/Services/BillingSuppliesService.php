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
            'billing_id'          => $billingSuppliesItems['billing_id'],
            'billing_supplies_id' => $billingSuppliesItems['billing_supplies_id'],
            'billing_type_id'     => BillingTypeEnum::SUPPLIES,
            'name'                => $billingSuppliesItems['name'],
            'cost_price'          => $billingSuppliesItems['cost_price'],
            'quantity'            => $billingSuppliesItems['quantity'],
            'total_price'         => $billingSuppliesItems['total_price'],
            'discount'            => $billingSuppliesItems['discount'],
            'discount_type_id'    => $billingSuppliesItems['discount_type_id'],
            'tax_percent'         => $billingSuppliesItems['tax_percent'],
            'tax_amount'          => $billingSuppliesItems['tax_amount'],
            'nett_price'          => $billingSuppliesItems['nett_price'],
            'created_by'          => Auth::id(),
            'last_modified_by'    => Auth::id(),
        ]);

        if (! empty($billingSuppliesItems['billing_supplies_id'])) {
            // Reduce stock based on quantity
            $billingSupplies = BillingSupplies::find($billingSuppliesItems['billing_supplies_id']);
            $billingSupplies->update([
                'stock' => $billingSupplies->stock - $billingSuppliesItems['quantity'],
            ]);
        }

        app(BillingService::class)->recomputeBillingTotals($billingSuppliesItems['billing_id']);
    }
}
