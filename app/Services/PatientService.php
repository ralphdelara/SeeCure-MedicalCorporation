<?php

namespace App\Services;

use App\Models\Patient;
use Illuminate\Support\Facades\Auth;

class PatientService
{
    public function getPatientList(): array
    {
        return [];
    }

    public function storePatient(array $patientDetails): string
    {
        $patientDetails['status_id'] = 1; // Waiting
        $patientDetails['created_by'] = Auth::id();

        $patient = Patient::create($patientDetails);

        return (string)$patient->id;
    }
}
