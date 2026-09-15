<?php

namespace App\Observers;

use App\Models\Visit;
use App\Services\VisitService;

class VisitObserver
{
    /**
     * Handle the Visit "created" event.
     */
    public function created(Visit $visit): void
    {
        //
    }

    /**
     * Handle the Visit "updated" event.
     */
    public function updated(Visit $visit): void
    {
        if (! $visit->wasChanged()) {
            return;
        }

        $changedFields = $visit->getChanges();
        $originalFields = $visit->getOriginal();

        if ($changedFields['visit_status_id']->value !== $originalFields['visit_status_id']) {
            app(VisitService::class)->notifyDepartments($visit);
        }
    }

    /**
     * Handle the Visit "deleted" event.
     */
    public function deleted(Visit $visit): void
    {
        //
    }

    /**
     * Handle the Visit "restored" event.
     */
    public function restored(Visit $visit): void
    {
        //
    }

    /**
     * Handle the Visit "force deleted" event.
     */
    public function forceDeleted(Visit $visit): void
    {
        //
    }
}
