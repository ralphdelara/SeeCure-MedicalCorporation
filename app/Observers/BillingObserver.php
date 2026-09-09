<?php

namespace App\Observers;

use App\Events\BillingSaved;
use App\Models\Billing;

class BillingObserver
{
    /**
     * Handle the Billing "created" event.
     */
    public function created(Billing $billing): void
    {
        BillingSaved::dispatch($billing, 'created');
    }

    /**
     * Handle the Billing "updated" event.
     */
    public function updated(Billing $billing): void
    {
        if (! $billing->wasChanged()) {
            return;
        }

        // Placed here because getChanges doesnt work if passed as parameter
        $changedFields = $billing->getChanges();
        $originalFields = $billing->getOriginal();

        BillingSaved::dispatch($billing, 'updated', $changedFields, $originalFields);
    }
}
