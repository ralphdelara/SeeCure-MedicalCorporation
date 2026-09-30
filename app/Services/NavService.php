<?php

namespace App\Services;

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
            'visitsCount' => Visit::count(),
            'patientCount' => Patient::count(),
            'consultationCount' => Consultation::count(),
            'consultationPendingCount' => Consultation::where('is_completed', false)->count(),
            'consultationCompletedCount' => Consultation::where('is_completed', true)->count(),
            'laboratoryCount' => Laboratory::count(),
            'laboratoryPendingCount' => Laboratory::where('is_completed', false)->count(),
            'laboratoryCompletedCount' => Laboratory::where('is_completed', true)->count(),
            'inventoryCount' => Inventory::count(),
            'pharmacyCount' => Pharmacy::count(),
            'pharmacyPendingCount' => Pharmacy::where('is_completed', false)->count(),
            'pharmacyCompletedCount' => Pharmacy::where('is_completed', true)->count(),
            'billingCount' => Billing::count(),
            'billingPendingCount' => Billing::where('is_completed', false)->count(),
            'billingCompletedCount' => Billing::where('is_completed', true)->count(),
            'cashierCount' => Cashier::count(),
            'cashierPendingCount' => Cashier::where('is_completed', false)->count(),
            'cashierCompletedCount' => Cashier::where('is_completed', true)->count(),
            'usersCount' => User::count(),
        ];
    }
}
