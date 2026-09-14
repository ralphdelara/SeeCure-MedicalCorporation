<?php

namespace App\Services;

use App\Models\Visit;
use Illuminate\Support\Facades\Auth;

class VisitService
{
    public function storeVisit(string $patientId, array $visitDetails): string
    {
        $visit = Visit::create([
            'patient_id'       => $patientId,
            'has_consultation' => $visitDetails['has_consultation'],
            'has_laboratory'   => $visitDetails['has_laboratory'],
            'has_radiology'    => $visitDetails['has_radiology'],
            'is_emergency'     => $visitDetails['is_emergency'],
            'visit_status_id'  => $visitDetails['visit_status_id'],
            'created_by'       => Auth::id(),
            'last_modified_by' => Auth::id(),
        ]);

        $visit->priorityTypes()->sync($visitDetails['priority_type_ids']);

        return $visit->id;
    }

    public function hasPending(array $arrayData): bool
    {
        foreach ($arrayData as $data) {
            if (!$data['is_completed']) {
                return true;
            }
        }

        return false;
    }
}
