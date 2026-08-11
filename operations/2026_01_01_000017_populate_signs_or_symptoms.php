<?php

use App\Models\SignsOrSymptom;
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
        SignsOrSymptom::fillAndInsert([
            ['name' => 'Cough'],
            ['name' => 'Colds'],
            ['name' => 'Fever'],
            ['name' => 'Headache'],
            ['name' => 'Stomach Pain'],
            ['name' => 'Sorethroat'],
            ['name' => 'Difficulty of Breathing'],
            ['name' => 'Diarrhea'],
            ['name' => 'Loss of Smell'],
            ['name' => 'Loss of Taste'],
        ]);
    }
};
