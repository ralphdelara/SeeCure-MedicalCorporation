<?php

namespace App\Http\Controllers;

use App\Models\Cashier;
use App\Models\DiscountType;
use App\Models\Payment;
use App\Models\PaymentMethod;
use App\Services\CashierService;
use App\Services\PatientService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class CashierController extends Controller
{
    public function getCashierList(Request $request, ?string $status = null): Response
    {
        $cashierList = app(CashierService::class)->getCashierList(
            $request->keyword,
            $status,
            $request->path(),
        );

        return Inertia::render('cashier/index', compact(
            'cashierList',
        ));
    }

    public function getCashierDetails(Request $request, string $cashierId): Response
    {
        $cashierDetails = app(CashierService::class)->getCashierDetails($cashierId);
        $patientDetails = app(PatientService::class)->getPatientDetails($cashierDetails['patient_id']);
        $discountType = DiscountType::all();
        $paymentMethodOptions = PaymentMethod::all();
        $paymentDetails = Payment::where('cashier_id', $cashierId)->get()->first();

        return Inertia::render('cashier/details/index', compact(
            'cashierDetails',
            'patientDetails',
            'discountType',
            'paymentMethodOptions',
            'paymentDetails',
        ));
    }

    public function updateDetails(Request $request): void
    {
        $details = $request->all();

        app(CashierService::class)->updateDetails($details);
    }

    public function deleteCashier(string $id): void
    {
        Cashier::destroy($id);
    }

    public function completeCashier(string $id): void
    {
        app(CashierService::class)->completeCashier($id);
    }

    public function addOrUpdatePayment(Request $request): RedirectResponse
    {
        $paymentDetails = $request->only(
            'cashier_id',
            'patient_id',
            'visit_id',
            'payment_id',
            'payment_method_id',
            'reference_number',
            'total_amount',
            'amount_received',
            'amount_change',
        );

        // to refresh usePage props
        return back()->with([
            'paymentDetails' => app(CashierService::class)->addOrUpdatePayment($paymentDetails)
        ]);
    }

    public function getAuditLog(string $id): array
    {
        return app(CashierService::class)->getAuditLog($id);
    }

    public function sendBackToBilling(string $billingId): void
    {
        app(CashierService::class)->sendBackToBilling($billingId);
    }
}
