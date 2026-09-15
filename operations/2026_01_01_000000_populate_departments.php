<?php

use App\Models\Department;
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
        Department::fillAndInsert([
            ['name' => 'Administrator'],
            ['name' => 'Billing'],
            ['name' => 'Cashier'],
            ['name' => 'Consultation'],
            ['name' => 'Front Desk'],
            ['name' => 'Laboratory'],
            ['name' => 'Radiology'],
            ['name' => 'Pharmacy'],
        ]);
    }
};
