<?php

namespace App\Services;

use App\Enums\PaymentMethodEnum;
use App\Enums\PaymentStatusEnum;
use App\Enums\VisitStatusEnum;
use App\Events\CashierViewed;
use App\Models\Billing;
use App\Models\Cashier;
use App\Models\CashierAudit;
use App\Models\Patient;
use App\Models\Payment;
use App\Models\Pharmacy;
use App\Models\Visit;
use Arr;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class CashierService
{
    public function getCashierList(
        ?string $keyword,
        ?string $status,
        string $path,
    ): array {
        $cashierList = Cashier::with([
            'visit.patient' => function ($query) {
                $query->select('id', 'first_name', 'middle_name', 'last_name', 'age', 'gender_id', 'patient_suffix_id');
            },
            'visit.patient.suffix',
            'visit.patient.gender',
            'visit.priorityTypes',
            'billing',
            'pharmacy',
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
        ])->withExists([
            'visit as has_priority' => function ($query) {
                $query->whereHas('priorityTypes');
            },
        ]);

        if (! empty($keyword)) {
            $cashierList = $cashierList->whereHas('visit.patient', function ($query) use ($keyword) {
                /** @var Builder|Patient $query */

                // Group the OR conditions inside a sub-query callback
                $query->where(function ($subQuery) use ($keyword) {
                    $searchKeyword = strtolower($keyword);

                    $subQuery->whereBlind('last_name_index', 'last_name_index', $searchKeyword)
                        ->orWhereBlind('first_name_index', 'first_name_index', $searchKeyword)
                        ->orWhereBlind('middle_name_index', 'middle_name_index', $searchKeyword);
                });
            });
        }

        if ($status === 'completed') {
            $cashierList = $cashierList->where('is_completed', true);
        } elseif ($status === 'pending-today') {
            // Dont add IN_CASHIER filter because it contradicts with billing and pharmacy status
            $cashierList = $cashierList->whereMonth('created_at', now()->format('m'))
                ->whereDay('created_at', now()->format('d'))
                ->whereYear('created_at', now()->format('Y'))
                ->where('is_completed', false);
        } else {
            // Dont add IN_CASHIER filter because it contradicts with billing and pharmacy status
            $cashierList = $cashierList->where('is_completed', false);
        }

        if ($status !== 'completed') {
            // emergency patients first
            $cashierList = $cashierList->orderBy(
                Visit::select('is_emergency')
                    ->whereColumn('visits.id', 'cashier.visit_id')
                    ->limit(1),
                'desc',
            );

            // priority patients first
            $cashierList = $cashierList->orderBy(
                'has_priority',
                'desc',
            );

            $cashierList = $cashierList->orderBy('created_at');
        } else {
            $cashierList = $cashierList->orderBy('created_at', 'desc');
        }

        $cashierList = $cashierList->paginate(50)
            ->withPath('/'.$path)->withQueryString();

        $tableData = $cashierList->collect()->toArray();
        $pageData = Arr::except($cashierList->toArray(), ['data']);
        $links = app(PageService::class)->limitLinks($cashierList, 5);
        $pageData['links'] = $links;

        return compact(
            'tableData',
            'pageData',
        );
    }

    public function storeCashier(
        string $visitId,
        ?string $billingId = null,
        ?string $pharmacyId = null,
    ): string {
        $cashier = Cashier::create([
            'visit_id'         => $visitId,
            'billing_id'       => $billingId,
            'pharmacy_id'      => $pharmacyId,
            'created_by'       => Auth::id(),
            'last_modified_by' => Auth::id(),
        ]);

        Visit::find($visitId)->update([
            'visit_status_id' => VisitStatusEnum::IN_CASHIER,
        ]);

        return $cashier->id;
    }

    public function getSmallPendingCashierList(): array
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
            'cashier',
        ])->whereVisitStatusId(VisitStatusEnum::IN_CASHIER)->get()->toArray();
    }

    public function getCashierDetails(string $cashierId): ?array
    {
        abortIfInvalidUuid($cashierId);

        $cashier = Cashier::with([
            'payment',
            'visit.patient' => function ($query) {
                $query->select('id', 'first_name', 'middle_name', 'last_name', 'age', 'gender_id', 'patient_suffix_id', 'barangay_id', 'city_id', 'province_id');
            },
            'visit.patient.suffix',
            'visit.patient.gender',
            'visit.laboratory',
            'visit.radiology',
            'billing.details',
            'pharmacy.details',
        ])->find($cashierId);

        if (empty($cashier)) {
            abort(404);
        }

        CashierViewed::dispatch($cashier);

        $lab = app(VisitService::class)->getPendingData($cashier->visit->laboratory?->toArray() ?? []);
        $radio = app(VisitService::class)->getPendingData($cashier->visit->radiology?->toArray() ?? []);

        $moveToText = 'Completed';

        if ($lab['pending']) {
            // move to lab if has pending laboratory
            $moveToText = 'Laboratory';
        } elseif ($radio['pending']) {
            // move to radio if has pending radiology
            $moveToText = 'Radiology';
        }

        $cashier = $cashier->toArray();
        $cashier['moveToText'] = $moveToText;

        return $cashier;
    }

    public function completeCashier(string $id)
    {
        $cashier = Cashier::with(
            'visit',
            'visit.laboratory',
            'visit.radiology',
            'payment',
        )->find($id);

        if ($cashier->is_completed) {
            abort(404);
        }

        $cashier->update([
            'is_completed' => true,
        ]);

        $lab = app(VisitService::class)->getPendingData($cashier->visit->laboratory?->toArray() ?? []);
        $radio = app(VisitService::class)->getPendingData($cashier->radiology?->toArray() ?? []);

        if ($lab['pending']) {
            // move to lab if has pending lab requests
            Visit::find($cashier->visit->id)->update([
                'visit_status_id' => VisitStatusEnum::IN_LABORATORY,
            ]);
        } elseif ($radio['pending']) {
            // move to radio if has pending radio requests
            Visit::find($cashier->visit->id)->update([
                'visit_status_id' => VisitStatusEnum::IN_RADIOLOGY,
            ]);
        } elseif(!empty($cashier->billing_id)) {
            // complete the patient visit if the transaction is billing
            Visit::find($cashier->visit->id)->update([
                'visit_status_id' => VisitStatusEnum::COMPLETED,
            ]);
        }
    }

    public function addOrUpdatePayment(array $paymentDetails): array
    {
        $paymentDetails['cashier_id'];
        $paymentId = $paymentDetails['payment_id'];
        $amountReceived = (float) $paymentDetails['amount_received'];
        $totalAmount = (float) $paymentDetails['total_amount'];

        // This prevents created_by from being updated
        unset($paymentDetails['created_by']);
        unset($paymentDetails['payment_id']);
        unset($paymentDetails['id']);

        if (empty($paymentId)) {
            $paymentDetails['transaction_header'] = now()->format('Ymd');
            $paymentDetails['payment_status_id'] = PaymentStatusEnum::SUCCESS;
            $paymentDetails['created_by'] = Auth::id();
        } else {
            unset(
                $paymentDetails['patient_id'],
                $paymentDetails['visit_id'],
                $paymentDetails['cashier_id'],
            );
        }

        $paymentDetails['amount_paid'] = $amountReceived > $totalAmount
            ? $totalAmount
            : $amountReceived;

        if ($paymentDetails['payment_method_id'] === PaymentMethodEnum::CASH->value) {
            unset($paymentDetails['reference_number']);
        } elseif (! empty($paymentDetails['payment_method_id'])) {
            $paymentDetails['amount_received'] = $totalAmount;
            $paymentDetails['amount_paid'] = $totalAmount;
            $paymentDetails['amount_change'] = 0;
        }

        $paymentDetails['last_modified_by'] = Auth::id();

        $payment = Payment::updateOrCreate(
            ['id' => $paymentId],
            $paymentDetails,
        );

        return $payment->toArray();
    }

    public function getAuditLog(string $cashierId): array
    {
        return CashierAudit::with([
            'createdBy' => function ($query) {
                $query->select('id', 'first_name', 'middle_name', 'last_name');
            },
            'createdBy.professions',
            'createdBy.specialties',
            'auditType',
        ])
            ->select('audit_type_id', 'data', 'created_by', 'created_at')
            ->where('cashier_id', $cashierId)
            ->orderBy('created_at', 'desc')
            ->get()->toArray();
    }

    public function sendBackToBilling(string $billingId): void
    {
        $billing = Billing::with('visit')->find($billingId);

        // move back to billing
        Visit::find($billing->visit->id)->update([
            'visit_status_id' => VisitStatusEnum::IN_BILLING,
        ]);

        // update billing is_completed status to false
        $billing->update([
            'is_completed' => false,
        ]);

        // delete Cashier Details
        Cashier::whereBillingId($billingId)->delete();
    }

    public function sendBackToPharmacy(string $pharmacyId): void
    {
        $pharmacy = Pharmacy::with('visit')->find($pharmacyId);

        // move back to pharmacy
        Visit::find($pharmacy->visit->id)->update([
            'visit_status_id' => VisitStatusEnum::IN_PHARMACY,
        ]);

        // update pharmacy is_completed status to false
        $pharmacy->update([
            'is_completed' => false,
        ]);

        // delete Cashier Details
        Cashier::wherePharmacyId($pharmacyId)->delete();
    }
}
