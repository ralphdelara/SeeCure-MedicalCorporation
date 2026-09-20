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
            'visit.patient' => function ($query) {
                $query->select('id', 'first_name', 'middle_name', 'last_name', 'age', 'gender_id', 'patient_suffix_id');
            },
            'visit.patient.suffix',
            'visit.patient.gender',
            'details',
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
            $pharmacyList = $pharmacyList->whereHas('visit.patient', function ($query) use ($keyword) {
                /** @var Builder|Patient $query */
                $query->whereBlind('last_name_index', 'last_name_index', strtolower($keyword))
                    ->orWhereBlind('first_name_index', 'first_name_index', strtolower($keyword))
                    ->orWhereBlind('middle_name_index', 'middle_name_index', strtolower($keyword));
            });
        }

        if ($status === 'completed') {
            $pharmacyList = $pharmacyList->where('is_completed', true);
        } else {
            $pharmacyList = $pharmacyList->where('is_completed', false);
            // removed ->where('visit_status_id', VisitStatusEnum::IN_PHARMACY)
            // to show all pending patients, patient can choose not to purchase medicine
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
            'visit',
            'visit.consultation' => function ($query) {
                $query->select('id', 'visit_id');
            },
            'visit.laboratory',
            'visit.radiology',
            'visit.patient' => function ($query) {
                $query->select('id', 'first_name', 'middle_name', 'last_name', 'age', 'gender_id', 'patient_suffix_id');
            },
            'visit.patient.suffix',
            'visit.patient.gender',
            'details',
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

    public function storePharmacy(Visit $visit, array $prescriptions): ?string
    {
        if (empty($prescriptions) || isAllNull(array_column($prescriptions, 'inventory_id'))) {
            return null;
        }

        if (Pharmacy::where('visit_id', $visit->id)->count() > 0) {
            abort(409);
        }

        $pharmacy = Pharmacy::create([
            'visit_id'         => $visit->id,
            'created_by'       => Auth::id(),
            'last_modified_by' => Auth::id(),
        ]);

        $totalCostPrice = 0;
        $totalTotalPrice = 0;
        $totalDiscount = 0;
        $totalTaxAmount = 0;
        $totalNettPrice = 0;
        $totalQuantity = 0;
        $pharmacyDetails = [];
        $inventoryIds = array_column($prescriptions, 'inventory_id');
        $inventoryPrices = app(InventoryService::class)->getPrices($inventoryIds);

        foreach ($prescriptions as $prescription) {
            $quantity = $prescription['quantity'];

            $costPrice = $prescription['inventory_id'] ? $inventoryPrices[$prescription['inventory_id']]['selling_price_vat_exclusive'] : 0;
            $totalPrice = $costPrice * $quantity;
            $taxPercent = $prescription['inventory_id'] ? $inventoryPrices[$prescription['inventory_id']]['vat_percent'] : 0;
            $taxAmount = $totalPrice * ($taxPercent / 100);
            $nettPrice = $totalPrice + $taxAmount;

            // Dont add prescription record if inventory_id is null it means its outside drug
            if (empty($prescription['inventory_id'])) {
                continue;
            }

            $pharmacyDetails[] = [
                'pharmacy_id'      => $pharmacy->id,
                'name'             => $prescription['inventory_name'],
                'cost_price'       => $costPrice,
                'quantity'         => $quantity,
                'total_price'      => $totalPrice,
                'tax_percent'      => $taxPercent,
                'tax_amount'       => $taxAmount,
                'nett_price'       => $nettPrice,
                'created_by'       => Auth::id(),
                'last_modified_by' => Auth::id(),
            ];

            $totalCostPrice += $costPrice;
            $totalTotalPrice += $totalPrice;
            $totalDiscount += 0;
            $totalTaxAmount += $taxAmount;
            $totalNettPrice += $nettPrice;
            $totalQuantity += $quantity;
        }

        $pharmacy->update([
            'total_cost_price' => $totalCostPrice,
            'total_quantity'   => $totalQuantity,
            'total_price'      => $totalTotalPrice,
            'total_discount'   => $totalDiscount,
            'total_tax'        => $totalTaxAmount,
            'total_nett_price' => $totalNettPrice,
        ]);

        PharmacyDetail::fillAndInsert($pharmacyDetails);

        // commented for now to prevent changing visit status to pharmacy
        /*
        $visit->update([
            'visit_status_id' => VisitStatusEnum::IN_PHARMACY,
        ]);*/

        return $pharmacy->id;
    }

    public function completePharmacy(string $id): void
    {
        $pharmacy = Pharmacy::find($id);

        if ($pharmacy->is_completed) {
            abort(404);
        }

        $pharmacy->update([
            'is_completed' => true,
        ]);

        // create cashier data for payments
        app(CashierService::class)->storeCashier(
            visitId: $pharmacy->visit_id,
            pharmacyId: $pharmacy->id,
        );
    }

    public function updateDetails(array $details)
    {
        $id = $details['id'];
        $totalCostPrice = $details['total_cost_price'];
        $totalQuantity = $details['total_quantity'];
        $totalPrice = $details['total_price'];
        $totalDiscount = $details['total_discount'];
        $totalNettPrice = $details['total_nett_price'];

        unset(
            $details['id'],
            $details['total_cost_price'],
            $details['total_quantity'],
            $details['total_price'],
            $details['total_discount'],
            $details['total_nett_price'],
        );

        Pharmacy::find($id)->update([
            'total_cost_price' => $totalCostPrice,
            'total_quantity'   => $totalQuantity,
            'total_price'      => $totalPrice,
            'total_discount'   => $totalDiscount,
            'total_tax'        => $totalNettPrice - ($totalPrice - $totalDiscount),
            'total_nett_price' => $totalNettPrice,
        ]);

        foreach ($details as $detailId => $field) {

            $discountTypeId = $field['discount_type_id'] !== 0
                ? $field['discount_type_id']
                : null;

            PharmacyDetail::find($detailId)->update([
                'cost_price'       => $field['cost_price'],
                'total_price'      => $field['total_price'],
                'quantity'         => $field['quantity'],
                'discount'         => $field['discount'],
                'discount_type_id' => $discountTypeId,
                'tax_percent'      => $field['tax_percent'],
                'tax_amount'       => $field['nett_price'] - ($field['total_price'] - $field['discount']),
                'nett_price'       => $field['nett_price'],
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
