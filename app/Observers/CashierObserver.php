<?php

namespace App\Observers;

use App\Events\CashierSaved;
use App\Models\Cashier;

class CashierObserver
{
    /**
     * Handle the Cashier "created" event.
     */
    public function created(Cashier $cashier): void
    {
        CashierSaved::dispatch($cashier, 'created');
    }

    /**
     * Handle the Cashier "updated" event.
     */
    public function updated(Cashier $cashier): void
    {
        if (! $cashier->wasChanged()) {
            return;
        }

        // Placed here because getChanges doesnt work if passed as parameter
        $changedFields = $cashier->getChanges();
        $originalFields = $cashier->getOriginal();

        CashierSaved::dispatch($cashier, 'updated', $changedFields, $originalFields);
    }
}
