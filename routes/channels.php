<?php

use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

Broadcast::channel('online-users', function (User $user) {
    if ($user && config('app.env') === 'production') {
        return [
            'id' => $user->id,
            'full_name' => $user->full_name,
            'is_physician' => $user->is_physician,
            'is_medtech' => $user->is_medtech,
            'gender' => $user->gender?->name ?? 'N/A',
            'position' => implode(',', $user->positions?->pluck('name')->toArray() ?? []),
        ];
    }

    return false;
});
