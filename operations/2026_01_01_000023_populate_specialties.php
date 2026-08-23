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
            ['name' => 'Anesthesiologist', 'suffix' => null],
            ['name' => 'Cardiologist', 'suffix' => null],
            ['name' => 'ENT Specialist', 'suffix' => ', ENT'],
            ['name' => 'Endocrinologist', 'suffix' => null],
            ['name' => 'Family Physician', 'suffix' => ', FM'],
            ['name' => 'Gastroenterologist', 'suffix' => null],
            ['name' => 'General Practitioner', 'suffix' => null],
            ['name' => 'General Surgeon', 'suffix' => null],
            ['name' => 'Gynecologist', 'suffix' => ', GYNE'],
            ['name' => 'Hematologist', 'suffix' => null],
            ['name' => 'Internist', 'suffix' => ', IM'],
            ['name' => 'Nephrologist', 'suffix' => null],
            ['name' => 'Obstetrician', 'suffix' => ', OB'],
            ['name' => 'Ophthalmologist', 'suffix' => null],
            ['name' => 'Orthopedic Surgeon', 'suffix' => null],
            ['name' => 'Pathologist', 'suffix' => null],
            ['name' => 'Pediatrician', 'suffix' => null],
            ['name' => 'Plastic Surgeon', 'suffix' => null],
            ['name' => 'Psychiatrist', 'suffix' => null],
            ['name' => 'Pulmonologist', 'suffix' => null],
            ['name' => 'Radiologist', 'suffix' => null],
            ['name' => 'Rheumatologist', 'suffix' => null],
            ['name' => 'Urologist', 'suffix' => null],
        ]);
    }
};
