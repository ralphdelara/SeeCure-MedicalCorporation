<?php

namespace App\Observers;

use App\Events\PharmacyDetailSaved;
use App\Models\PharmacyDetail;

class PharmacyDetailObserver
{
    /**
     * Handle the PharmacyDetail "created" event.
     */
    public function created(PharmacyDetail $pharmacyDetail): void
    {
        PharmacyDetailSaved::dispatch($pharmacyDetail, 'created');
    }

    /**
     * Handle the PharmacyDetail "updated" event.
     */
    public function updated(PharmacyDetail $pharmacyDetail): void
    {
        if (! $pharmacyDetail->wasChanged()) {
            return;
        }

        // Placed here because getChanges doesnt work if passed as parameter
        $changedFields = $pharmacyDetail->getChanges();
        $originalFields = $pharmacyDetail->getOriginal();

        PharmacyDetailSaved::dispatch($pharmacyDetail, 'updated', $changedFields, $originalFields);
    }
}
