<?php

namespace App\Http\Controllers;

use App\Models\Billing;
use App\Models\DiscountType;
use App\Services\BillingService;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class BillingController extends Controller
{
    public function getBillingList(Request $request, ?string $status = null): Response
    {
        $billingList = app(BillingService::class)->getBillingList(
            $request->keyword,
            $status,
            $request->path(),
        );

        return Inertia::render('billing/index', compact(
            'billingList',
        ));
    }

    public function getBillingDetails(Request $request, string $billingId): Response
    {
        $billingDetails = app(BillingService::class)->getBillingDetails($billingId);
        $patientDetails = $billingDetails['visit']['patient'];
        $discountType = DiscountType::all();

        return Inertia::render('billing/details/index', compact(
            'billingDetails',
            'patientDetails',
            'discountType',
        ));
    }

    public function updateDetails(Request $request): void
    {
        $details = $request->all();

        app(BillingService::class)->updateDetails($details);
    }

    public function deleteBilling(string $id): void
    {
        Billing::destroy($id);
    }

    public function completeBilling(string $id): void
    {
        app(BillingService::class)->completeBilling($id);
    }

    public function getAuditLog(string $id): array
    {
        return app(BillingService::class)->getAuditLog($id);
    }
}
