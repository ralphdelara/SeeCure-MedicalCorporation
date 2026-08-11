<?php

use App\Models\Relationship;
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
        Relationship::fillAndInsert([
            ['name' => 'Parent'],
            ['name' => 'Spouse'],
            ['name' => 'Child'],
            ['name' => 'Sibling'],
            ['name' => 'Legal Guardian'],
            ['name' => 'Foster Parent'],
            ['name' => 'Grandparent'],
            ['name' => 'Grandchild'],
            ['name' => 'Aunt / Uncle'],
            ['name' => 'Cousin'],
            ['name' => 'Others'],
        ]);
    }
};
