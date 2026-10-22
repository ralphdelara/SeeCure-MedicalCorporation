<?php

namespace App\Services;

use App\Enums\VisitStatusEnum;
use App\Models\Billing;
use App\Models\Cashier;
use App\Models\Consultation;
use App\Models\Inventory;
use App\Models\Laboratory;
use App\Models\Patient;
use App\Models\Pharmacy;
use App\Models\User;
use App\Models\Visit;

class NavService
{
    public function getCount(): array
    {
        return [
            'visitsPendingCount' => Visit::whereNotIn('visit_status_id', [
                VisitStatusEnum::ADMITTED,
                VisitStatusEnum::DISCHARGED,
                VisitStatusEnum::COMPLETED,
                VisitStatusEnum::CANCELLED,
            ])->count(),
            'visitsCount'       => Visit::count(),
            'patientCount'      => Patient::count(),
            'consultationCount' => Consultation::with('visit')->where('is_completed', true)
                ->orWhereRelation('visit', 'visit_status_id', VisitStatusEnum::IN_CONSULTATION)->count(),
            'consultationPendingCount' => Consultation::with('visit')->where('is_completed', false)
                ->whereRelation('visit', 'visit_status_id', VisitStatusEnum::IN_CONSULTATION)
                ->count(),
            'consultationCompletedCount' => Consultation::where('is_completed', true)->count(),
            'laboratoryCount'            => Laboratory::with('visit')->where('is_completed', true)
                ->orWhereRelation('visit', 'visit_status_id', VisitStatusEnum::IN_LABORATORY)->count(),
            'laboratoryPendingCount' => Laboratory::with('visit')->where('is_completed', false)
                ->whereRelation('visit', 'visit_status_id', VisitStatusEnum::IN_LABORATORY)->count(),
            'laboratoryCompletedCount' => Laboratory::where('is_completed', true)->count(),
            'inventoryCount'           => Inventory::where('status', true)->count(),
            'inventoryHiddenCount'     => Inventory::where('status', false)->count(),
            'pharmacyCount'            => Pharmacy::count(),
            'pharmacyPendingCount'     => Pharmacy::where('is_completed', false)->count(),
            'pharmacyCompletedCount'   => Pharmacy::where('is_completed', true)->count(),
            'billingCount'             => Billing::count(),
            'billingPendingCount'      => Billing::where('is_completed', false)->count(),
            'billingCompletedCount'    => Billing::where('is_completed', true)->count(),
            'cashierCount'             => Cashier::count(),
            'cashierPendingCount'      => Cashier::where('is_completed', false)->count(),
            'cashierCompletedCount'    => Cashier::where('is_completed', true)->count(),
            'usersCount'               => User::count(),
        ];
    }
}
