<?php

namespace App\Observers;

use App\Events\PatientSaved;
use App\Models\Patient;

class PatientObserver
{
    /**
     * Handle the Patient "created" event.
     */
    public function created(Patient $patient): void
    {
        PatientSaved::dispatch($patient, 'created');
    }

    /**
     * Handle the Patient "updated" event.
     */
    public function updated(Patient $patient): void
    {
        if (! $patient->wasChanged()) {
            return;
        }

        // Placed here because getChanges doesnt work if passed as parameter
        $changedFields = $patient->getChanges();
        $originalFields = $patient->getOriginal();

        PatientSaved::dispatch($patient, 'updated', $changedFields, $originalFields);
    }
}
