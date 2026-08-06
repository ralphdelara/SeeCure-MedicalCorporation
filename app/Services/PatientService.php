<?php

namespace App\Services;

use App\Models\Patient;
use Illuminate\Support\Facades\Auth;

class PatientService
{
    public function storePatient(array $patientDetails): int
    {
        $patientDetails['status_id'] = 1; // Waiting
        $patientDetails['created_by'] = Auth::id();

        $patient = Patient::create($patientDetails);

        return $patient->id;
    }
}
