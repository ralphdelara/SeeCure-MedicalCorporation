<?php

namespace App\Observers;

use App\Events\BillingDetailSaved;
use App\Models\BillingDetail;

class BillingDetailObserver
{
    /**
     * Handle the BillingDetail "created" event.
     */
    public function created(BillingDetail $billingDetail): void
    {
        BillingDetailSaved::dispatch($billingDetail, 'created');
    }

    /**
     * Handle the BillingDetail "updated" event.
     */
    public function updated(BillingDetail $billingDetail): void
    {
        if (! $billingDetail->wasChanged()) {
            return;
        }

        // Placed here because getChanges doesnt work if passed as parameter
        $changedFields = $billingDetail->getChanges();
        $originalFields = $billingDetail->getOriginal();

        BillingDetailSaved::dispatch($billingDetail, 'updated', $changedFields, $originalFields);
    }
}
