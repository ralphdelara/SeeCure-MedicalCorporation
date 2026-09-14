<?php

namespace App\Observers;

use App\Events\PharmacySaved;
use App\Models\Pharmacy;

class PharmacyObserver
{
    /**
     * Handle the Pharmacy "created" event.
     */
    public function created(Pharmacy $pharmacy): void
    {
        PharmacySaved::dispatch($pharmacy, 'created');
    }

    /**
     * Handle the Pharmacy "updated" event.
     */
    public function updated(Pharmacy $pharmacy): void
    {
        if (! $pharmacy->wasChanged()) {
            return;
        }

        // Placed here because getChanges doesnt work if passed as parameter
        $changedFields = $pharmacy->getChanges();
        $originalFields = $pharmacy->getOriginal();

        PharmacySaved::dispatch($pharmacy, 'updated', $changedFields, $originalFields);
    }
}
