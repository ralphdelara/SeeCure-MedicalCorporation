<?php

use App\Models\Position;
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
        Position::fillAndInsert([
            // Admin
            ['name' => 'Head of Admin'],
            ['name' => 'Admin Aide'],

            // Finance
            ['name' => 'Head of Finance'],
            ['name' => 'Accountant'],
            ['name' => 'Finance Officer'],

            // Pharmacy
            ['name' => 'General Practitioner'],
            ['name' => 'Pharmacist'],
            ['name' => 'Pharmacy Assistant'],

            // Laboratory
            ['name' => 'Head of Laboratory'],
            ['name' => 'Medical Technologist Supervisor'],
            ['name' => 'Medical Technologist'],
            ['name' => 'Laboratory Aide'],

            // IT
            ['name' => 'Full Stack Software Engineer'],
            ['name' => 'Bot'],
            ['name' => 'Encoder'],
        ]);
    }
};
