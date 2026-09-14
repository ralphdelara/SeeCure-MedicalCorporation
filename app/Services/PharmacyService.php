<?php

namespace App\Services;

use App\Enums\PaymentMethodEnum;
use App\Enums\PaymentStatusEnum;
use App\Enums\VisitStatusEnum;
use App\Events\PharmacyViewed;
use App\Models\Patient;
use App\Models\Payment;
use App\Models\Pharmacy;
use App\Models\PharmacyAudit;
use App\Models\PharmacyDetail;
use App\Models\Prescription;
use App\Models\Visit;
use Arr;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class PharmacyService
{
    public function getPharmacyList(
        ?string $keyword,
        ?string $status,
        string $path,
    ): array {
        $pharmacyList = Pharmacy::with([
            'patient' => function ($query) {
                $query->select('id', 'first_name', 'middle_name', 'last_name', 'age', 'gender_id', 'patient_suffix_id');
            },
            'patient.gender' => function ($query) {
                $query->select('id', 'name');
            },
            'details.prescription',
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
            'visit',
        ]);

        if (! empty($keyword)) {
            $pharmacyList = $pharmacyList->whereHas('patient', function ($query) use ($keyword) {
                /** @var Builder|Patient $query */
                $query->whereBlind('last_name_index', 'last_name_index', strtolower($keyword))
                    ->orWhereBlind('first_name_index', 'first_name_index', strtolower($keyword))
                    ->orWhereBlind('middle_name_index', 'middle_name_index', strtolower($keyword));
            });
        }

        if ($status === 'completed') {
            $pharmacyList = $pharmacyList->where('is_completed', true);
        } else {
            $pharmacyList = $pharmacyList->whereHas('visit', function ($query) {
                $query->where('visit_status_id', VisitStatusEnum::IN_PHARMACY)
                    ->where('is_completed', false);
            });
        }

        $pharmacyList = $pharmacyList->orderBy('created_at')->paginate(50)
            ->withPath('/'.$path)->withQueryString();

        $tableData = $pharmacyList->collect()->toArray();
        $pageData = Arr::except($pharmacyList->toArray(), ['data']);
        $links = app(PageService::class)->limitLinks($pharmacyList, 5);
        $pageData['links'] = $links;

        return compact(
            'tableData',
            'pageData',
        );
    }

    public function getSmallPendingPharmacyList(): array
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
        ])->whereVisitStatusId(VisitStatusEnum::IN_PHARMACY)->get()->toArray();
    }

    public function getPharmacyDetails(string $pharmacyId): ?array
    {
        abortIfInvalidUuid($pharmacyId);

        $pharmacy = Pharmacy::with([
            'patient' => function ($query) {
                $query->select('id', 'first_name', 'middle_name', 'last_name', 'age', 'gender_id', 'patient_suffix_id');
            },
            'patient.gender' => function ($query) {
                $query->select('id', 'name');
            },
            'details',
            'details.prescription',
            'details.createdBy' => function ($query) {
                $query->select('id', 'first_name', 'middle_name', 'last_name');
            },
            'details.createdBy.professions',
            'details.createdBy.specialties',
            'details.lastModifiedBy' => function ($query) {
                $query->select('id', 'first_name', 'middle_name', 'last_name');
            },
            'details.lastModifiedBy.professions',
            'details.lastModifiedBy.specialties',
            'visit' => function ($query) {
                $query->select('id');
            },
            'visit.consultation' => function ($query) {
                $query->select('id', 'visit_id');
            },
            'visit.laboratory',
            'visit.radiology',
        ])->orderBy(
            PharmacyDetail::select('created_at')->whereColumn('pharmacy_details.id', 'pharmacy.id'),
        )->find($pharmacyId);

        if (empty($pharmacy)) {
            abort(404);
        }

        PharmacyViewed::dispatch($pharmacy);

        $pharmacy = $pharmacy->toArray();
        $pharmacy['moveToText'] = 'Cashier';

        return $pharmacy;
    }

    public function storePharmacy(
        string $patientId,
        string $visitId,
        string $consultationId,
        string $billingId,
    ): string {
        $pharmacy = Pharmacy::create([
            'patient_id'       => $patientId,
            'visit_id'         => $visitId,
            'consultation_id'  => $consultationId,
            'billing_id'       => $billingId,
            'created_by'       => Auth::id(),
            'last_modified_by' => Auth::id(),
        ]);

        $prescriptions = Prescription::with('createdBy', 'lastModifiedBy')
            ->where('consultation_id', $consultationId)->get();
        $pharmacyDetails = [];

        foreach ($prescriptions as $prescription) {
            $pharmacyDetails[] = [
                'pharmacy_id'           => $pharmacy->id,
                'prescription_id'       => $prescription->id,
                'prescription_quantity' => $prescription->quantity,
                'pharmacy_quantity'     => $prescription->quantity,
                'created_by'            => $prescription->created_by,
                'last_modified_by'      => $prescription->last_modified_by,
            ];
        }

        PharmacyDetail::fillAndInsert($pharmacyDetails);

        return $pharmacy->id;
    }

    public function completePharmacy(string $id)
    {
        $pharmacy = Pharmacy::with('billing', 'details.prescription')->find($id);

        if ($pharmacy->is_completed) {
            abort(404);
        }

        $pharmacy->update([
            'is_completed' => true,
        ]);

        // move to cashier
        Visit::find($pharmacy->visit->id)->update([
            'visit_status_id' => VisitStatusEnum::IN_CASHIER,
        ]);

        app(CashierService::class)->storeCashierDetails($pharmacy->billing, $pharmacy->details->toArray());
    }

    public function updateDetails(array $details)
    {
        unset($details['id']);

        foreach ($details as $detailId => $field) {
            PharmacyDetail::find($detailId)->update([
                'pharmacy_quantity' => $field['pharmacy_quantity'],
                'last_modified_by'  => Auth::id(),
            ]);
        }
    }

    public function addOrUpdatePayment(array $paymentDetails): array
    {
        $paymentDetails['pharmacy_id'];
        $paymentId = $paymentDetails['payment_id'];
        $amountReceived = (float) $paymentDetails['amount_received'];
        $totalAmount = (float) $paymentDetails['total_amount'];

        // This prevents created_by from being updated
        unset($paymentDetails['created_by']);
        unset($paymentDetails['payment_id']);
        unset($paymentDetails['id']);

        if (empty($paymentId)) {
            $paymentDetails['receipt_sequence_header'] = now()->format('Ymd');
            $paymentDetails['payment_status_id'] = PaymentStatusEnum::SUCCESS;
            $paymentDetails['created_by'] = Auth::id();
        } else {
            unset(
                $paymentDetails['patient_id'],
                $paymentDetails['visit_id'],
                $paymentDetails['pharmacy_id'],
            );
        }

        $paymentDetails['amount_paid'] = $amountReceived > $totalAmount
            ? $totalAmount
            : $amountReceived - $totalAmount;

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

    public function getAuditLog(string $pharmacyId): array
    {
        return PharmacyAudit::with([
            'createdBy' => function ($query) {
                $query->select('id', 'first_name', 'middle_name', 'last_name');
            },
            'createdBy.professions',
            'createdBy.specialties',
            'auditType',
        ])
            ->select('audit_type_id', 'data', 'created_by', 'created_at')
            ->where('pharmacy_id', $pharmacyId)
            ->orderBy('created_at', 'desc')
            ->get()->toArray();
    }
}
