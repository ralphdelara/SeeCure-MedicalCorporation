<?php

namespace App\Services;

use App\Models\PatientVitalSign;
use Illuminate\Support\Facades\Auth;

class PatientVitalSignService
{
    public function storeVitalSigns(
        string $patientId,
        ?string $consultationId,
        array $vitalSignsDetails,
    ): void {
        if (empty($vitalSignsDetails)) {
            return;
        }

        $vitalSignsData = [];
        foreach ($vitalSignsDetails as $vitalSignId => $vitalSignField) {
            foreach ($vitalSignField as $fieldId => $value) {
                if (empty($value)) {
                    continue;
                }

                $vitalSignsData[] = [
                    'patient_id'          => $patientId,
                    'consultation_id'     => $consultationId,
                    'vital_sign_id'       => $vitalSignId,
                    'vital_sign_field_id' => $fieldId,
                    'value'               => $value,
                    'created_by'          => Auth::id(),
                ];
            }
        }

        PatientVitalSign::fillAndInsert($vitalSignsData);
    }
}
