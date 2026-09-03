<?php

namespace App\Observers;

use App\Events\SoapSaved;
use App\Models\ConsultationSoap;

class ConsultationSoapObserver
{
    /**
     * Handle the ConsultationSoap "created" event.
     */
    public function created(ConsultationSoap $consultationSoap): void
    {
        SoapSaved::dispatch(
            $consultationSoap,
            'created',
        );
    }

    /**
     * Handle the ConsultationSoap "updated" event.
     */
    public function updated(ConsultationSoap $consultationSoap): void
    {
        if (! $consultationSoap->wasChanged()) {
            return;
        }

        // Placed here because getChanges doesnt work if passed as parameter
        $changedFields = $consultationSoap->getChanges();
        $originalFields = $consultationSoap->getOriginal();

        SoapSaved::dispatch($consultationSoap, 'updated', $changedFields, $originalFields);
    }
}
