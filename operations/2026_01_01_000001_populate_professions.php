<?php

use App\Models\Profession;
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
        Profession::fillAndInsert([
            ['name' => 'Doctor', 'prefix' => 'Dr. ', 'suffix' => 'MD'],
            ['name' => 'Medical Technologist', 'prefix' => null, 'suffix' => 'RMT'],
            ['name' => 'Nurse', 'prefix' => null, 'suffix' => 'RN'],
            ['name' => 'Staff', 'prefix' => null, 'suffix' => null],
            ['name' => 'IT', 'prefix' => null, 'suffix' => null],
            ['name' => 'Other', 'prefix' => null, 'suffix' => null],
            ['name' => 'Pharmacist', 'prefix' => null, 'suffix' => null],
        ]);
    }
};
