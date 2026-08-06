<?php

namespace App\Services;

use App\Models\Consultation;
use Illuminate\Support\Facades\Auth;

class ConsultationService
{
    public function queuePatient(int $patientId, array $consultDetails): int
    {
        $consultation = Consultation::create([
            'patient_id'              => $patientId,
            'guardian_name'           => $consultDetails['guardian_name'],
            'guardian_contact_number' => $consultDetails['guardian_contact_number'],
            'guardian_email'          => $consultDetails['guardian_email'],
            'status_id'               => 1, // Pending
            'doctor_id'               => $consultDetails['doctor_id'],
            'created_by'              => Auth::id(),
        ]);

        // insert consultation types
        $data = array_map(fn ($id) => [
            'consultation_id' => $consultation->id,
            'type_id'         => $id,
        ], $consultDetails['consultation_types_id']);
        $consultation->types()->insert($data);

        // insert signs or symptoms
        $data = array_map(fn ($id) => [
            'consultation_id'     => $consultation->id,
            'signs_or_symptom_id' => $id,
        ], $consultDetails['signs_or_symptoms_id']);
        $consultation->signsOrSymptoms()->insert($data);

        return $consultation->id;
    }
}
