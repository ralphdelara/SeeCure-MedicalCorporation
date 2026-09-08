<?php

namespace App\Observers;

use App\Events\LaboratorySaved;
use App\Models\Laboratory;

class LaboratoryObserver
{
    /**
     * Handle the Laboratory "created" event.
     */
    public function created(Laboratory $laboratory): void
    {
        LaboratorySaved::dispatch($laboratory, 'created');
    }

    /**
     * Handle the Laboratory "updated" event.
     */
    public function updated(Laboratory $laboratory): void
    {
        if (! $laboratory->wasChanged()) {
            return;
        }

        // Placed here because getChanges doesnt work if passed as parameter
        $changedFields = $laboratory->getChanges();
        $originalFields = $laboratory->getOriginal();

        LaboratorySaved::dispatch($laboratory, 'updated', $changedFields, $originalFields);
    }
}
