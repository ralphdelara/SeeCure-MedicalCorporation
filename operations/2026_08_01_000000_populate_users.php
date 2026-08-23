<?php

use App\Models\User;
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
            'first_name'       => 'SYSTEM',
            'last_name'        => 'USER',
            'username'         => 'system_user',
            'password'         => Hash::make('system_pass'),
            'gender_id'        => 4, // Unknown
            'status'           => true,
            'department_id'    => 4, // IT
            'position_id'      => 14, // Bot
            'first_name_index' => 'SYSTEM',
            'last_name_index'  => 'USER',
            'username_index'   => 'system_user',
            'created_by'       => null,

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

            'department_id' => 2, // Consultation
            'position_id'   => 6, // GP

            'first_name_index' => 'Lyka Loraine',
            'last_name_index'  => 'Zulueta',

            'username_index' => 'lykaz',
            'created_by'     => $user->id, // SYSTEM USER

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
