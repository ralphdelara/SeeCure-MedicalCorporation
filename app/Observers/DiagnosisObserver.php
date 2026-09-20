<?php

namespace App\Observers;

use App\Events\DiagnosisSaved;
use App\Models\Diagnosis;

class DiagnosisObserver
{
    /**
     * Handle the Diagnosis "created" event.
     */
    public function created(Diagnosis $diagnosis): void
    {
        DiagnosisSaved::dispatch(
            $diagnosis,
            'created',
        );
    }

    /**
     * Handle the Diagnosis "updated" event.
     */
    public function updated(Diagnosis $diagnosis): void
    {
        if (! $diagnosis->wasChanged()) {
            return;
        }

        // Placed here because getChanges doesnt work if passed as parameter
        $changedFields = $diagnosis->getChanges();
        $originalFields = $diagnosis->getOriginal();

        DiagnosisSaved::dispatch($diagnosis, 'updated', $changedFields, $originalFields);
    }
}
