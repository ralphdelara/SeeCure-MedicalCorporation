<?php

use App\Models\TransactionType;
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
        TransactionType::fillAndInsert([
            ['name' => 'Sales Receipt'],
            ['name' => 'Invoice'],
            ['name' => 'Consultation'],
            ['name' => 'Laboratory'],
            ['name' => 'Consultation with Laboratory'],
        ]);
    }
};
