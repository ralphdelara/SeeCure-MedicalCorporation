<?php

namespace App\Observers;

use App\Events\PrescriptionSaved;
use App\Models\Prescription;

class PrescriptionObserver
{
    /**
     * Handle the Prescription "created" event.
     */
    public function created(Prescription $prescription): void
    {
        PrescriptionSaved::dispatch($prescription, 'created');
    }

    /**
     * Handle the Prescription "updated" event.
     */
    public function updated(Prescription $prescription): void
    {
        if (! $prescription->wasChanged()) {
            return;
        }

        // Placed here because getChanges doesnt work if passed as parameter
        $changedFields = $prescription->getChanges();
        $originalFields = $prescription->getOriginal();

        PrescriptionSaved::dispatch($prescription, 'updated', $changedFields, $originalFields);
    }

    /**
     * Handle the Prescription "deleting" event.
     */
    public function deleting(Prescription $prescription): void
    {
        PrescriptionSaved::dispatch($prescription, 'deleted');
    }
}
