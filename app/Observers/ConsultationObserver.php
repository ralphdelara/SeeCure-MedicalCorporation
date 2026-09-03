<?php

namespace App\Observers;

use App\Events\ConsultationSaved;
use App\Models\Consultation;

class ConsultationObserver
{
    /**
     * Handle the Consultation "created" event.
     */
    public function created(Consultation $consultation): void
    {
        ConsultationSaved::dispatch($consultation, 'created');
    }

    /**
     * Handle the Consultation "updated" event.
     */
    public function updated(Consultation $consultation): void
    {
        if (! $consultation->wasChanged()) {
            return;
        }

        // Placed here because getChanges doesnt work if passed as parameter
        $changedFields = $consultation->getChanges();
        $originalFields = $consultation->getOriginal();

        ConsultationSaved::dispatch($consultation, 'updated', $changedFields, $originalFields);
    }
}
