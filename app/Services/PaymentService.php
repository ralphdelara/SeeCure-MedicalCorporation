<?php

namespace App\Services;

use App\Enums\PaymentStatusEnum;
use App\Enums\VisitStatusEnum;
use App\Events\PaymentViewed;
use App\Models\Billing;
use App\Models\Patient;
use App\Models\Payment;
use App\Models\PaymentAudit;
use App\Models\Visit;
use Arr;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class PaymentService
{
    public function getPaymentList(
        ?string $keyword,
        ?string $status,
        string $path,
    ): array {
        $paymentList = Billing::with([
            'patient' => function ($query) {
                $query->select('id', 'first_name', 'middle_name', 'last_name', 'age', 'gender_id', 'patient_suffix_id');
            },
            'patient.gender' => function ($query) {
                $query->select('id', 'name');
            },
            'method',
            'status',
            'createdBy' => function ($query) {
                $query->select('id', 'first_name', 'middle_name', 'last_name');
            },
            'createdBy.professions',
            'createdBy.specialties',
            'lastModifiedBy' => function ($query) {
                $query->select('id', 'first_name', 'middle_name', 'last_name');
            },
            'lastModifiedBy.professions',
            'lastModifiedBy.specialties',
        ]);

        if (! empty($keyword)) {
            $paymentList = $paymentList->whereHas('patient', function ($query) use ($keyword) {
                /** @var Builder|Patient $query */
                $query->whereBlind('last_name_index', 'last_name_index', strtolower($keyword))
                    ->orWhereBlind('first_name_index', 'first_name_index', strtolower($keyword))
                    ->orWhereBlind('middle_name_index', 'middle_name_index', strtolower($keyword));
            });
        }

        if ($status === 'completed') {
            $paymentList = $paymentList->where('payment_status_id', PaymentStatusEnum::SUCCESS);
        } else {
            $paymentList = $paymentList->whereHas('visit', function ($query) {
                $query->where('visit_status_id', VisitStatusEnum::IN_CASHIER)
                    ->where('payment_status_id', PaymentStatusEnum::PENDING);
            });
        }

        $paymentList = $paymentList->orderBy('created_at')->paginate(50)
            ->withPath('/'.$path)->withQueryString();

        $tableData = $paymentList->collect()->toArray();
        $pageData = Arr::except($paymentList->toArray(), ['data']);
        $links = app(PageService::class)->limitLinks($paymentList, 5);
        $pageData['links'] = $links;

        return compact(
            'tableData',
            'pageData',
        );
    }

    public function storePayment(
        string $patientId,
        string $visitId,
        string $billingId,
    ): string {
        $payment = Payment::create([
            'patient_id'        => $patientId,
            'visit_id'          => $visitId,
            'billing_id'        => $billingId,
            'payment_status_id' => PaymentStatusEnum::PENDING,
            'created_by'        => Auth::id(),
            'last_modified_by'  => Auth::id(),
        ]);

        return $payment->id;
    }

    public function getSmallPendingPaymentList(): array
    {
        return Visit::with([
            'patient' => function ($query) {
                $query->select('id', 'first_name', 'middle_name', 'last_name', 'patient_suffix_id', 'age', 'gender_id');
            },
            'patient.gender' => function ($query) {
                $query->select('id', 'name');
            },
            'patient.suffix' => function ($query) {
                $query->select('id', 'name');
            },
            'payment',
        ])->whereVisitStatusId(VisitStatusEnum::IN_CASHIER)->get()->toArray();
    }

    public function getPaymentDetails(string $paymentId): ?array
    {
        $payment = Payment::with([
            'patient' => function ($query) {
                $query->select('id', 'first_name', 'middle_name', 'last_name', 'age', 'gender_id', 'patient_suffix_id');
            },
            'patient.gender' => function ($query) {
                $query->select('id', 'name');
            },
            'billing',
        ])->find($paymentId);

        if (empty($payment)) {
            abort(404);
        }

        PaymentViewed::dispatch($payment);

        return $payment->toArray();
    }

    public function completePayment(array $paymentDetails)
    {
        $payment = Payment::find($paymentDetails['id']);

        $payment->update([
            'payment_method_id' => $paymentDetails['payment_method_id'],
            'payment_status_id' => PaymentStatusEnum::SUCCESS,

            'reference_number' => $paymentDetails['reference_number'],
            'total_amount'     => $paymentDetails['total_amount'],
            'amount_received'  => $paymentDetails['amount_received'],
            'amount_paid'      => $paymentDetails['amount_paid'],
            'amount_change'    => $paymentDetails['amount_change'],

            'last_modified_by' => Auth::id(),
        ]);

        Visit::find($payment->visit->id)->update([
            'visit_status_id' => VisitStatusEnum::COMPLETED,
        ]);
    }

    public function getAuditLog(string $paymentId): array
    {
        return PaymentAudit::with([
            'createdBy' => function ($query) {
                $query->select('id', 'first_name', 'middle_name', 'last_name');
            },
            'createdBy.professions',
            'createdBy.specialties',
            'auditType',
        ])
            ->select('audit_type_id', 'data', 'created_by', 'created_at')
            ->where('payment_id', $paymentId)
            ->orderBy('created_at', 'desc')
            ->get()->toArray();
    }
}
