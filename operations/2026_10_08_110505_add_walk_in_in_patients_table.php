<?php

use App\Enums\PatientStatusEnum;
use App\Models\Patient;
use App\Models\Visit;
use Illuminate\Support\Facades\Auth;
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
        $patient = Patient::create([
            'last_name'        => 'WALK IN',
            'first_name'       => 'PATIENT',
            'last_name_index'  => 'WALK IN',
            'first_name_index' => 'PATIENT',
            'status_id'        => PatientStatusEnum::INACTIVE,
            'created_by'       => Auth::systemUser()->id,
            'last_modified_by' => Auth::systemUser()->id,
        ]);

        Visit::where('patient_id', null)->update([
            'patient_id' => $patient->id,
        ]);
    }
};
