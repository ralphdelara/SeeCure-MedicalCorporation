<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\DiscountType;
use App\Models\PaymentMethod;
use App\Services\PaymentService;
use App\Services\PatientService;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class PaymentController extends Controller
{
    public function getPaymentList(Request $request, ?string $status = null): Response
    {
        $paymentList = app(PaymentService::class)->getPaymentList(
            $request->keyword,
            $status,
            $request->path(),
        );

        return Inertia::render('payment/index', compact(
            'paymentList',
        ));
    }

    public function getPaymentDetails(Request $request, string $paymentId): Response
    {
        $paymentDetails = app(PaymentService::class)->getPaymentDetails($paymentId);
        $patientDetails = app(PatientService::class)->getPatientDetails($paymentDetails['patient_id']);
        $paymentMethod = PaymentMethod::all();

        return Inertia::render('payment/details/index', compact(
            'paymentDetails',
            'patientDetails',
            'paymentMethod',
        ));
    }

    public function completePayment(Request $request): void
    {
        $paymentDetails = $request->only(
            'id',
            'payment_method_id',
            'payment_status_id',
            'reference_number',
            'total_amount',
            'amount_received',
            'amount_paid',
            'amount_change',
        );

        app(PaymentService::class)->completePayment($paymentDetails);
    }

    public function getAuditLog(string $id): array
    {
        return app(PaymentService::class)->getAuditLog($id);
    }
}
