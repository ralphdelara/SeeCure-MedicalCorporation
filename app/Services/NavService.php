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
            'consultationPendingTodayCount' => Consultation::with('visit')->where('is_completed', false)
                ->whereRelation('visit', 'visit_status_id', VisitStatusEnum::IN_CONSULTATION)
                ->whereMonth('created_at', now()->format('m'))
                ->whereDay('created_at', now()->format('d'))
                ->whereYear('created_at', now()->format('Y'))
                ->count(),
            'consultationPendingCount' => Consultation::with('visit')->where('is_completed', false)
                ->whereRelation('visit', 'visit_status_id', VisitStatusEnum::IN_CONSULTATION)
                ->count(),
            'consultationCompletedCount' => Consultation::where('is_completed', true)->count(),
            'laboratoryCount'            => Laboratory::with('visit')->where('is_completed', true)
                ->orWhereRelation('visit', 'visit_status_id', VisitStatusEnum::IN_LABORATORY)->count(),
            'laboratoryPendingTodayCount' => Laboratory::with('visit')->where('is_completed', false)
                ->whereRelation('visit', 'visit_status_id', VisitStatusEnum::IN_LABORATORY)
                ->whereMonth('created_at', now()->format('m'))
                ->whereDay('created_at', now()->format('d'))
                ->whereYear('created_at', now()->format('Y'))
                ->count(),
            'laboratoryPendingCount' => Laboratory::with('visit')->where('is_completed', false)
                ->whereRelation('visit', 'visit_status_id', VisitStatusEnum::IN_LABORATORY)->count(),
            'laboratoryCompletedCount' => Laboratory::where('is_completed', true)->count(),
            'inventoryCount'           => Inventory::where('status', true)->count(),
            'inventoryHiddenCount'     => Inventory::where('status', false)->count(),
            'pharmacyCount'            => Pharmacy::count(),
            // Dont add IN_PHARMACY filter because it contradicts with billing
            'pharmacyPendingTodayCount' => Pharmacy::with('visit')->where('is_completed', false)
                //->whereRelation('visit', 'visit_status_id', VisitStatusEnum::IN_PHARMACY)
                ->whereMonth('created_at', now()->format('m'))
                ->whereDay('created_at', now()->format('d'))
                ->whereYear('created_at', now()->format('Y'))
                ->count(),
            // Dont add IN_PHARMACY filter because it contradicts with billing
            'pharmacyPendingCount'     => Pharmacy::where('is_completed', false)
                //->whereRelation('visit', 'visit_status_id', VisitStatusEnum::IN_PHARMACY)
                ->count(),
            'pharmacyCompletedCount'   => Pharmacy::where('is_completed', true)->count(),
            'billingCount'             => Billing::count(),
            // Dont add IN_BILLING filter because it contradicts with pharmacy status
            'billingPendingTodayCount' => Billing::where('is_completed', false)
                ->whereMonth('created_at', now()->format('m'))
                ->whereDay('created_at', now()->format('d'))
                ->whereYear('created_at', now()->format('Y'))
                ->count(),
            // Dont add IN_BILLING filter because it contradicts with pharmacy status
            'billingPendingCount' => Billing::with('visit')->where('is_completed', false)
                ->count(),
            'billingCompletedCount'    => Billing::where('is_completed', true)->count(),
            'cashierCount'             => Cashier::count(),
            // Dont add IN_CASHIER filter because it contradicts with billing and pharmacy status
            'cashierPendingTodayCount' => Cashier::where('is_completed', false)
                ->whereMonth('created_at', now()->format('m'))
                ->whereDay('created_at', now()->format('d'))
                ->whereYear('created_at', now()->format('Y'))
                ->count(),
            // Dont add IN_CASHIER filter because it contradicts with billing and pharmacy status
            'cashierPendingCount'      => Cashier::where('is_completed', false)->count(),
            'cashierCompletedCount'    => Cashier::where('is_completed', true)->count(),
            'usersCount'               => User::count(),
        ];
    }
}
