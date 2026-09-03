<?php

namespace App\Observers;

use App\Events\DiagnosisSaved;
use App\Models\ConsultationDiagnosis;

class ConsultationDiagnosisObserver
{
    /**
     * Handle the ConsultationDiagnosis "created" event.
     */
    public function created(ConsultationDiagnosis $consultationDiagnosis): void
    {
        DiagnosisSaved::dispatch(
            $consultationDiagnosis,
            'created',
        );
    }

    /**
     * Handle the ConsultationDiagnosis "updated" event.
     */
    public function updated(ConsultationDiagnosis $consultationDiagnosis): void
    {
        if (! $consultationDiagnosis->wasChanged()) {
            return;
        }

        // Placed here because getChanges doesnt work if passed as parameter
        $changedFields = $consultationDiagnosis->getChanges();
        $originalFields = $consultationDiagnosis->getOriginal();

        DiagnosisSaved::dispatch($consultationDiagnosis, 'updated', $changedFields, $originalFields);
    }
}
