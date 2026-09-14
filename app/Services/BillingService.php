<?php

namespace App\Services;

use App\Enums\BillingTypeEnum;
use App\Enums\LaboratoryTestEnum;
use App\Enums\VisitStatusEnum;
use App\Events\BillingViewed;
use App\Models\Billing;
use App\Models\BillingAudit;
use App\Models\BillingDetail;
use App\Models\Laboratory;
use App\Models\Patient;
use App\Models\Visit;
use Arr;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class BillingService
{
    public function getBillingList(
        ?string $keyword,
        ?string $status,
        string $path,
    ): array {
        $billingList = Billing::with([
            'patient' => function ($query) {
                $query->select('id', 'first_name', 'middle_name', 'last_name', 'age', 'gender_id', 'patient_suffix_id');
            },
            'patient.gender' => function ($query) {
                $query->select('id', 'name');
            },
            'details',
            'details.type',
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
            $billingList = $billingList->whereHas('patient', function ($query) use ($keyword) {
                /** @var Builder|Patient $query */
                $query->whereBlind('last_name_index', 'last_name_index', strtolower($keyword))
                    ->orWhereBlind('first_name_index', 'first_name_index', strtolower($keyword))
                    ->orWhereBlind('middle_name_index', 'middle_name_index', strtolower($keyword));
            });
        }

        if ($status === 'completed') {
            $billingList = $billingList->where('is_completed', true);
        } else {
            $billingList = $billingList->whereHas('visit', function ($query) {
                $query->where('visit_status_id', VisitStatusEnum::IN_BILLING);
            });
        }

        $billingList = $billingList->orderBy('created_at')->paginate(50)
            ->withPath('/'.$path)->withQueryString();

        $tableData = $billingList->collect()->toArray();
        $pageData = Arr::except($billingList->toArray(), ['data']);
        $links = app(PageService::class)->limitLinks($billingList, 5);
        $pageData['links'] = $links;

        return compact(
            'tableData',
            'pageData',
        );
    }

    public function storeBilling(
        string $patientId,
        string $visitId,
        ?string $consultationId,
        ?string $laboratoryId,
        ?string $radiologyId,
    ): string {
        $billing = Billing::create([
            'patient_id'       => $patientId,
            'visit_id'         => $visitId,
            'created_by'       => Auth::id(),
            'last_modified_by' => Auth::id(),
        ]);

        $totalPrice = 0;
        $totalDiscount = 0;
        $totalNettPrice = 0;

        if (! empty($consultationId)) {
            BillingDetail::create([
                'billing_id'       => $billing->id,
                'billing_type_id'  => BillingTypeEnum::CONSULTATION,
                'name'             => BillingTypeEnum::CONSULTATION->description(),
                'created_by'       => Auth::id(),
                'last_modified_by' => Auth::id(),
            ]);
        }

        if (! empty($laboratoryId)) {
            $labCosts = $this->storeLabBilling($billing->id, $laboratoryId);
            $totalPrice += $labCosts['totalPrice'];
            $totalNettPrice += $labCosts['totalNettPrice'];
        }

        if (! empty($radiologyId)) {

        }

        Billing::find($billing->id)->update([
            'total_price'      => $totalPrice,
            'total_discount'   => $totalDiscount,
            'total_tax_amount' => $totalNettPrice - ($totalPrice - $totalDiscount),
            'total_nett_price' => $totalNettPrice,
        ]);

        return $billing->id;
    }

    public function storeLabBilling(string $billingId, string $laboratoryId): array
    {
        $labDetails = [];
        $totalPrice = 0;
        $totalNettPrice = 0;

        $laboratory = Laboratory::with('testData', 'testData.fields')->find($laboratoryId);

        foreach ($laboratory->testData as $data) {
            $testEnum = LaboratoryTestEnum::tryFrom($data->laboratory_test_id);

            $totalPrice += $testEnum?->price();
            $totalNettPrice += $testEnum?->price();

            $labDetails[] = [
                'billing_id'       => $billingId,
                'billing_type_id'  => BillingTypeEnum::LABORATORY,
                'name'             => $testEnum?->description() ?? 'N/A',
                'price'            => $testEnum?->price(),
                'nett_price'       => $testEnum?->price(),
                'created_by'       => Auth::id(),
                'last_modified_by' => Auth::id(),
            ];
        }

        BillingDetail::fillAndInsert($labDetails);

        return [
            'totalPrice'     => $totalPrice,
            'totalNettPrice' => $totalNettPrice,
        ];
    }

    public function getSmallPendingBillingList(): array
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
            'billing',
        ])->whereVisitStatusId(VisitStatusEnum::IN_BILLING)->get()->toArray();
    }

    public function getBillingDetails(string $billingId): ?array
    {
        abortIfInvalidUuid($billingId);

        $billing = Billing::with([
            'patient' => function ($query) {
                $query->select('id', 'first_name', 'middle_name', 'last_name', 'age', 'gender_id', 'patient_suffix_id');
            },
            'patient.gender' => function ($query) {
                $query->select('id', 'name');
            },
            'details',
            'details.type',
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
        ])->find($billingId);

        if (empty($billing)) {
            abort(404);
        }

        BillingViewed::dispatch($billing);

        return $billing->toArray();
    }

    public function completeBilling(string $id)
    {
        $billing = Billing::with('visit', 'cashier', 'visit.consultation.prescriptions')
            ->find($id);

        $billing->update([
            'is_completed' => true,
        ]);

        // move to cashier
        Visit::find($billing->visit->id)->update([
            'visit_status_id' => VisitStatusEnum::IN_CASHIER,
        ]);

        app(CashierService::class)->storeCashierDetails($billing);
    }

    public function updateDetails(array $details)
    {
        $id = $details['id'];
        $totalPrice = $details['total_price'];
        $totalDiscount = $details['total_discount'];
        $totalNettPrice = $details['total_nett_price'];

        unset(
            $details['id'],
            $details['total_price'],
            $details['total_discount'],
            $details['total_nett_price'],
        );

        Billing::find($id)->update([
            'total_price'      => $totalPrice,
            'total_discount'   => $totalDiscount,
            'total_tax_amount' => $totalNettPrice - ($totalPrice - $totalDiscount),
            'total_nett_price' => $totalNettPrice,
        ]);

        foreach ($details as $detailId => $field) {

            $discountTypeId = $field['discount_type_id'] !== 0
                ? $field['discount_type_id']
                : null;

            BillingDetail::find($detailId)->update([
                'price'            => $field['price'],
                'discount'         => $field['discount'],
                'discount_type_id' => $discountTypeId,
                'tax_percent'      => $field['tax_percent'],
                'tax_amount'       => $field['nett_price'] - ($field['price'] - $field['discount']),
                'nett_price'       => $field['nett_price'],
            ]);
        }
    }

    public function getAuditLog(string $billingId): array
    {
        return BillingAudit::with([
            'createdBy' => function ($query) {
                $query->select('id', 'first_name', 'middle_name', 'last_name');
            },
            'createdBy.professions',
            'createdBy.specialties',
            'auditType',
        ])
            ->select('audit_type_id', 'data', 'created_by', 'created_at')
            ->where('billing_id', $billingId)
            ->orderBy('created_at', 'desc')
            ->get()->toArray();
    }
}
