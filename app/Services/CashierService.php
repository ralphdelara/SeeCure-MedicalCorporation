<?php

namespace App\Services;

use App\Enums\BillingTypeEnum;
use App\Enums\CashierTypeEnum;
use App\Enums\PaymentMethodEnum;
use App\Enums\PaymentStatusEnum;
use App\Enums\VisitStatusEnum;
use App\Events\CashierViewed;
use App\Models\Billing;
use App\Models\Cashier;
use App\Models\CashierAudit;
use App\Models\CashierDetail;
use App\Models\Inventory;
use App\Models\Patient;
use App\Models\Payment;
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
            'patient' => function ($query) {
                $query->select('id', 'first_name', 'middle_name', 'last_name', 'age', 'gender_id', 'patient_suffix_id');
            },
            'patient.gender' => function ($query) {
                $query->select('id', 'name');
            },
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
            'visit',
        ]);

        if (! empty($keyword)) {
            $cashierList = $cashierList->whereHas('patient', function ($query) use ($keyword) {
                /** @var Builder|Patient $query */
                $query->whereBlind('last_name_index', 'last_name_index', strtolower($keyword))
                    ->orWhereBlind('first_name_index', 'first_name_index', strtolower($keyword))
                    ->orWhereBlind('middle_name_index', 'middle_name_index', strtolower($keyword));
            });
        }

        if ($status === 'completed') {
            $cashierList = $cashierList->where('is_completed', true);
        } else {
            $cashierList = $cashierList->whereHas('visit', function ($query) {
                $query->where('visit_status_id', VisitStatusEnum::IN_CASHIER);
            });
        }

        $cashierList = $cashierList->orderBy('created_at')->paginate(50)
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
        string $patientId,
        string $visitId,
        ?string $billingId,
    ): string {
        $cashier = Cashier::create([
            'patient_id'       => $patientId,
            'visit_id'         => $visitId,
            'billing_id'       => $billingId,
            'created_by'       => Auth::id(),
            'last_modified_by' => Auth::id(),
        ]);

        return $cashier->id;
    }

    public function storeCashierDetails(Billing $billing): void
    {
        // to prevent cashier details duplicate
        if (! empty($billing->cashier->details->toArray())) {
            return;
        }

        $totalCostPrice = 0;
        $totalTotalPrice = 0;
        $totalDiscount = 0;
        $totalTaxAmount = 0;
        $totalNettPrice = 0;

        $consultation = $billing->visit->consultation;

        if (! empty($consultation)) {
            $consultation->consultationId;

            $prescriptions = $consultation->prescriptions;
            $inventoryIds = $prescriptions->pluck('inventory_id')->toArray();
            $inventoryPrices = array_column(Inventory::select(
                'id',
                'selling_price_vat_exclusive',
                'selling_price_vat_inclusive',
                'vat_amount',
                'vat_percent',
            )->whereIn('id', $inventoryIds)->get()->toArray(), null, 'id');

            $prescriptionData = [];

            foreach ($prescriptions as $prescription) {
                $costPrice = $prescription->inventory_id ? $inventoryPrices[$prescription->inventory_id]['selling_price_vat_exclusive'] : 0;
                $totalPrice = $costPrice * $prescription->quantity;
                $taxPercent = $prescription->inventory_id ? $inventoryPrices[$prescription->inventory_id]['vat_percent'] : 0;
                $taxAmount = $totalPrice * ($taxPercent / 100);
                $nettPrice = $totalPrice + $taxAmount;

                $prescriptionData[] = [
                    'cashier_id'       => $billing->cashier->id,
                    'cashier_type_id'  => CashierTypeEnum::PRESCRIPTION,
                    'name'             => $prescription->inventory_name.(empty($prescription->inventory_id) ? ' (Outside Drug)' : ''),
                    'cost_price'       => $costPrice,
                    'quantity'         => $prescription->quantity,
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
            }

            CashierDetail::fillAndInsert($prescriptionData);
        }

        if (! empty($billing)) {
            $billingDetails = $billing->details;
            $billingDetailsData = [];

            foreach ($billingDetails as $detail) {
                $cashierType = match (BillingTypeEnum::tryFrom($detail->billing_type_id)) {
                    BillingTypeEnum::CONSULTATION => CashierTypeEnum::CONSULTATION,
                    BillingTypeEnum::LABORATORY   => CashierTypeEnum::LABORATORY,
                    BillingTypeEnum::RADIOLOGY    => CashierTypeEnum::RADIOLOGY,
                };

                $billingDetailsData[] = [
                    'cashier_id'       => $billing->cashier->id,
                    'cashier_type_id'  => $cashierType,
                    'name'             => $detail->name,
                    'cost_price'       => $detail->price,
                    'quantity'         => 1,
                    'total_price'      => $detail->price,
                    'discount'         => $detail->discount,
                    'discount_type_id' => $detail->discount_type_id,
                    'tax_percent'      => $detail->tax_percent,
                    'tax_amount'       => $detail->tax_amount,
                    'nett_price'       => $detail->nett_price,
                    'created_by'       => Auth::id(),
                    'last_modified_by' => Auth::id(),
                ];

                $totalCostPrice += $detail->price;
                $totalTotalPrice += $detail->price;
                $totalDiscount += $detail->discount;
                $totalTaxAmount += $detail->tax_amount;
                $totalNettPrice += $detail->nett_price;
            }

            CashierDetail::fillAndInsert($billingDetailsData);
        }

        // update total price in cashier table
        Cashier::find($billing->cashier->id)->update([
            'total_cost_price' => $totalCostPrice,
            'total_price'      => $totalTotalPrice,
            'total_discount'   => $totalDiscount,
            'total_tax'        => $totalTaxAmount,
            'total_nett_price' => $totalNettPrice,
        ]);

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
        ])->whereVisitStatusId(VisitStatusEnum::IN_BILLING)->get()->toArray();
    }

    public function getCashierDetails(string $cashierId): ?array
    {
        $cashier = Cashier::with([
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
        ])->orderBy(
            CashierDetail::select('created_at')->whereColumn('cashier_details.id', 'cashier.id'),
        )->find($cashierId);

        if (empty($cashier)) {
            abort(404);
        }

        CashierViewed::dispatch($cashier);

        return $cashier->toArray();
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

        if (app(VisitService::class)->hasPending($cashier->visit->laboratory?->toArray() ?? [])) {
            // move to laboratory
            Visit::find($cashier->visit->id)->update([
                'visit_status_id' => VisitStatusEnum::IN_LABORATORY,
            ]);
        } elseif (app(VisitService::class)->hasPending($cashier->visit->radiology?->toArray() ?? [])) {
            // move to radiology
            Visit::find($cashier->visit->id)->update([
                'visit_status_id' => VisitStatusEnum::IN_RADIOLOGY,
            ]);
        } else {
            // move to pharmacy
            Visit::find($cashier->visit->id)->update([
                'visit_status_id' => VisitStatusEnum::IN_PHARMACY,
            ]);
        }
    }

    public function updateDetails(array $details)
    {
        $id = $details['id'];
        $totalCostPrice = $details['total_cost_price'];
        $totalPrice = $details['total_price'];
        $totalDiscount = $details['total_discount'];
        $totalNettPrice = $details['total_nett_price'];

        unset(
            $details['id'],
            $details['total_cost_price'],
            $details['total_price'],
            $details['total_discount'],
            $details['total_nett_price'],
        );

        Cashier::find($id)->update([
            'total_cost_price' => $totalCostPrice,
            'total_price'      => $totalPrice,
            'total_discount'   => $totalDiscount,
            'total_tax_amount' => $totalNettPrice - ($totalPrice - $totalDiscount),
            'total_nett_price' => $totalNettPrice,
        ]);

        foreach ($details as $detailId => $field) {
            CashierDetail::find($detailId)->update([
                'cost_price'       => $field['cost_price'],
                'quantity'         => $field['quantity'],
                'total_price'      => $field['total_price'],
                'discount'         => $field['discount'],
                'discount_type_id' => $field['discount_type_id'],
                'tax_percent'      => $field['tax_percent'],
                'tax_amount'       => $field['nett_price'] - ($field['total_price'] - $field['discount']),
                'nett_price'       => $field['nett_price'],
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
            $paymentDetails['receipt_sequence_header'] = now()->format('Ymd');
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
}
