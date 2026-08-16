<?php

use App\Models\User;
use App\Models\UserDepartment;
use App\Models\UserProfession;
use TimoKoerber\LaravelOneTimeOperations\OneTimeOperation;

return new class extends OneTimeOperation
{
    /**
     * Determine if the operation is being processed asynchronously.
     */
    protected bool $async = false;

    /**
     * The queue that the job will be dispatched to.
     */
    protected string $queue = 'default';

    /**
     * A tag name, that this operation can be filtered by.
     */
    protected ?string $tag = null;

    /**
     * Process the operation.
     */
    public function process(): void
    {
        $user = User::create([
            'first_name' => 'SYSTEM',
            'last_name'  => 'USER',
            'username'   => 'system_user',
            'password'   => Hash::make('system_pass'),
            'gender_id'  => 4, // Unknown

            'status' => true,

            'position_id' => 14, // Bot

            'created_by' => null,

        ]);

        UserDepartment::create([
            'user_id'       => $user->id, // SYSTEM USER
            'department_id' => 1, // Administrator
        ]);

        UserProfession::create([
            'user_id'       => $user->id, // SYSTEM USER
            'profession_id' => 6, // Other
        ]);

        $user2 = User::create([
            'first_name' => 'Lyka Loraine',
            'last_name'  => 'Zulueta',
            'username'   => 'lykaz',
            'password'   => Hash::make('chintot'),
            'gender_id'  => 1, // Female

            'status' => true,

            'position_id' => 6, // GP

            'created_by' => $user->id, // SYSTEM USER

        ]);

        UserDepartment::create([
            'user_id'       => $user2->id,
            'department_id' => 2, // Consultation
        ]);

        UserProfession::create([
            'user_id'       => $user2->id,
            'profession_id' => 1, // Doctor
        ]);
        UserProfession::create([
            'user_id'       => $user2->id,
            'profession_id' => 2, // Med tech
        ]);
    }
};
