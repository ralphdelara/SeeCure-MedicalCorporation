<?php

namespace App\Observers;

use App\Events\UserSaved;
use App\Models\User;

class UserObserver
{
    /**
     * Handle the User "created" event.
     */
    public function created(User $user): void
    {
        UserSaved::dispatch($user, 'created');
    }

    /**
     * Handle the User "updated" event.
     */
    public function updated(User $user): void
    {
        if (! $user->wasChanged()) {
            return;
        }

        // Placed here because getChanges doesnt work if passed as parameter
        $changedFields = $user->getChanges();
        $originalFields = $user->getOriginal();

        UserSaved::dispatch($user, 'updated', $changedFields, $originalFields);
    }
}
