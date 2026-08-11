<?php

use App\Models\VitalSignField;
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
        VitalSignField::fillAndInsert([
            ['name' => 'Systolic', 'vital_sign_id' => 1, 'unit' => 'mmHg'],
            ['name' => 'Diastolic', 'vital_sign_id' => 1, 'unit' => 'mmHg'],
            ['name' => 'Rate', 'vital_sign_id' => 2, 'unit' => 'bpm'],
            ['name' => 'Rate', 'vital_sign_id' => 3, 'unit' => 'bpm'],
            ['name' => 'Percentage', 'vital_sign_id' => 4, 'unit' => '%'],
            ['name' => 'Weight', 'vital_sign_id' => 5, 'unit' => 'kg'],
            ['name' => 'Degrees', 'vital_sign_id' => 6, 'unit' => '°C'],
        ]);
    }
};
