<?php

namespace App\Services;

use App\Enums\VisitStatusEnum;
use App\Events\NotifyBilling;
use App\Events\NotifyCashier;
use App\Events\NotifyDoctor;
use App\Events\NotifyFrontDesk;
use App\Events\NotifyLaboratory;
use App\Events\NotifyPharmacy;
use App\Events\NotifyRadiology;
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
            'is_walk_in'       => $visitDetails['is_walk_in'],
            'visit_status_id'  => $visitDetails['visit_status_id'],
            'created_by'       => Auth::id(),
            'created_at'       => $visitDetails['created_at'],
            'last_modified_by' => Auth::id(),
        ]);

        $visit->priorityTypes()->sync($visitDetails['priority_type_ids']);

        return $visit->id;
    }

    public function getPendingData(array $arrayData): array
    {
        foreach ($arrayData as $data) {
            if (array_key_exists('is_completed', $data) && ! $data['is_completed']) {
                return [
                    'id'      => $data['id'],
                    'pending' => true,
                ];
            }
        }

        return [
            'id'      => null,
            'pending' => false,
        ];
    }

    public function notifyDepartments(Visit $visit): void
    {
        if (
            $visit->visit_status_id
            === VisitStatusEnum::IN_BILLING
        ) {
            $count = Visit::where('visit_status_id', VisitStatusEnum::IN_BILLING)->count();

            broadcast(new NotifyBilling(
                'Notification',
                'Patient has been placed in billing',
                $count,
            ));
        }

        if (
            $visit->visit_status_id
            === VisitStatusEnum::IN_CASHIER
        ) {
            $count = Visit::where('visit_status_id', VisitStatusEnum::IN_CASHIER)->count();

            broadcast(new NotifyCashier(
                'Notification',
                'Patient has been placed in cashier',
                $count,
            ));
        }

        if (
            $visit->visit_status_id
            === VisitStatusEnum::IN_PHARMACY
        ) {
            $count = Visit::where('visit_status_id', VisitStatusEnum::IN_PHARMACY)->count();

            broadcast(new NotifyPharmacy(
                'Notification',
                'Patient has been placed in pharmacy',
                $count,
            ));
        }

        if (
            $visit->visit_status_id
            === VisitStatusEnum::IN_LABORATORY
        ) {
            $count = Visit::where('visit_status_id', VisitStatusEnum::IN_LABORATORY)->count();

            broadcast(new NotifyLaboratory(
                'Notification',
                'Patient has been placed in laboratory',
                $count,
            ));
        }

        if (
            $visit->visit_status_id
            === VisitStatusEnum::IN_CONSULTATION
        ) {
            $count = Visit::where('visit_status_id', VisitStatusEnum::IN_CONSULTATION)->count();

            broadcast(new NotifyDoctor(
                'Notification',
                'Patient has been placed in consultation',
                $count,
            ));
        }

        if (
            $visit->visit_status_id
            === VisitStatusEnum::IN_RADIOLOGY
        ) {
            $count = Visit::where('visit_status_id', VisitStatusEnum::IN_RADIOLOGY)->count();

            broadcast(new NotifyRadiology(
                'Notification',
                'Patient has been placed in radiology',
                $count,
            ));
        }

        $this->notifyFrontDesk();
    }

    public function notifyFrontDesk(): void
    {
        broadcast(new NotifyFrontDesk(
            'Notification',
            '',
            0,
        ));
    }
}
