<?php

namespace App\Observers;

use App\Events\CashierDetailSaved;
use App\Models\CashierDetail;

class CashierDetailObserver
{
    /**
     * Handle the CashierDetail "created" event.
     */
    public function created(CashierDetail $cashierDetail): void
    {
        CashierDetailSaved::dispatch($cashierDetail, 'created');
    }

    /**
     * Handle the CashierDetail "updated" event.
     */
    public function updated(CashierDetail $cashierDetail): void
    {
        if (! $cashierDetail->wasChanged()) {
            return;
        }

        // Placed here because getChanges doesnt work if passed as parameter
        $changedFields = $cashierDetail->getChanges();
        $originalFields = $cashierDetail->getOriginal();

        CashierDetailSaved::dispatch($cashierDetail, 'updated', $changedFields, $originalFields);
    }
}
