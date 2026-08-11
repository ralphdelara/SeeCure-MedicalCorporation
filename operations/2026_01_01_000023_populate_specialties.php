<?php

use App\Models\Specialty;
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
        Specialty::fillAndInsert([
            ['name' => 'Anesthesiology', 'suffix' => null],
            ['name' => 'Cardiology', 'suffix' => null],
            ['name' => 'Ear, Nose and Throat', 'suffix' => ', ENT'],
            ['name' => 'Endocrinology', 'suffix' => null],
            ['name' => 'Family Medicine', 'suffix' => ', FM'],
            ['name' => 'Gastroenterology', 'suffix' => null],
            ['name' => 'General Practice', 'suffix' => null],
            ['name' => 'General Surgery', 'suffix' => null],
            ['name' => 'Gynecology', 'suffix' => ', GYNE'],
            ['name' => 'Hematology', 'suffix' => null],
            ['name' => 'Internal Medicine', 'suffix' => ', IM'],
            ['name' => 'Nephrology', 'suffix' => null],
            ['name' => 'Obstetrics', 'suffix' => ', OB'],
            ['name' => 'Opthalmology', 'suffix' => null],
            ['name' => 'Othopedic Surgery', 'suffix' => null],
            ['name' => 'Pathology', 'suffix' => null],
            ['name' => 'Pediatrics', 'suffix' => null],
            ['name' => 'Plastic Surgery', 'suffix' => null],
            ['name' => 'Psychiatry', 'suffix' => null],
            ['name' => 'Pulmonology', 'suffix' => null],
            ['name' => 'Radiology', 'suffix' => null],
            ['name' => 'Rheumatology', 'suffix' => null],
            ['name' => 'Urology', 'suffix' => null],
        ]);
    }
};
