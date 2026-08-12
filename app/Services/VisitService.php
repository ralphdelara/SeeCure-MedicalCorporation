<?php

namespace App\Services;

use App\Models\Visit;
use Illuminate\Support\Facades\Auth;

class VisitService
{
    public function queuePatient(int $patientId, array $consultDetails): int
    {
        $visit = Visit::create([
            'patient_id'              => $patientId,
            'guardian_name'           => $consultDetails['guardian_name'],
            'guardian_contact_number' => $consultDetails['guardian_contact_number'],
            'guardian_email'          => $consultDetails['guardian_email'],
            'status_id'               => 1, // Pending
            'doctor_id'               => $consultDetails['doctor_id'],
            'created_by'              => Auth::id(),
        ]);

        return $visit->id;
    }
}
