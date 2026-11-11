<?php

namespace App\Http\Controllers;

use App\Enums\BillingTypeEnum;
use App\Enums\DiscountTypeEnum;
use App\Enums\LaboratoryTestEnum;
use App\Enums\LaboratoryTypeEnum;
use App\Models\Billing;
use App\Models\CompanyProfile;
use App\Models\Consultation;
use App\Models\Laboratory;
use App\Models\LaboratoryField;
use App\Models\LaboratoryTestData;
use App\Models\LaboratoryTestFieldData;
use App\Models\Payment;
use App\Models\Pharmacy;
use App\Services\PrintService;
use Auth;
use Inertia\Inertia;
use Inertia\Response;

class PrintController extends Controller
{
    public function __construct(public string $qrUrl = 'https://see-cure.vercel.app/?data=') {}

    public function printPrescription(string $consultationId): Response
    {
        $consultation = Consultation::with(
            'prescriptions',
            'doctor.professions',
            'doctor.specialties',
            'visit.patient.gender',
        )->findOrFail($consultationId);

        $printTitle = 'PRESCRIPTION';
        $prescription = $consultation->prescriptions ?? [];
        $patient = $consultation->visit->patient;
        $rightFullName = $consultation->doctor->full_name;
        $rightLicNo = $consultation->doctor->license_no;
        $rightPtrNo = $consultation->doctor->ptr_no;
        $prescriptionRemarks = $consultation->prescription_remarks;
        $consultDate = $consultation->created_at->format('m/d/Y');
        $prescriptionData = [];
        $prescriptionCount = 0;

        foreach ($prescription->toArray() as $key => $value) {
            if ($key > 0 && ($key + 1) % 7 === 0) {
                $prescriptionCount++;
            }
            $prescriptionData[$prescriptionCount][] = $value;
        }

        $prescription = $prescriptionData;

        return Inertia::render('print-templates/prescription', compact(
            'printTitle',
            'patient',
            'consultDate',
            'rightFullName',
            'rightLicNo',
            'rightPtrNo',
            'prescription',
            'prescriptionRemarks',
        ));
    }

    public function printBilling(string $billingId): Response
    {
        $printTitle = '';
        $billing = Billing::with([
            'details' => function ($query) {
                $query->orderBy('nett_price');
            },
            'visit.patient.suffix',
            'visit.patient.gender',
            'visit.consultation.doctor.professions',
            'visit.consultation.doctor.specialties',
        ])->find($billingId);
        $qrUrl = $this->qrUrl.('Billing|'.$billing->visit->patient?->full_name.'||Billing Details|'.$billing->created_at);
        $printedBy = Auth::user()->full_name;

        $discountPercent = match (true) {
            $billing->visit->patient?->is_senior => config('amounts.senior_discount_percent'),
            $billing->visit->patient?->is_pwd    => config('amounts.pwd_discount_percent'),
            default                              => null,
        };

        $discountType = match (true) {
            $billing->visit->patient?->is_senior => DiscountTypeEnum::SENIOR->description(),
            $billing->visit->patient?->is_pwd    => DiscountTypeEnum::PWD->description(),
            default                              => null,
        };

        $discountIdNo = match (true) {
            $billing->visit->patient?->is_senior => $billing->visit->patient?->senior_citizen_id,
            $billing->visit->patient?->is_pwd    => $billing->visit->patient?->pwd_id,
            default                              => null,
        };

        $billing = $billing->toArray();
        $billingDetails = [];
        $billingDetailsCount = 0;
        $billingItemsCounter = 0;
        $billType = '';

        foreach ($billing['details'] as $key => $value) {
            $billingDetails[$billingDetailsCount][] = $value;

            if ($value['billing_type_id'] === BillingTypeEnum::CONSULTATION->value) {
                $billType = 'Consultation Bill';
            }

            if ($value['billing_type_id'] === BillingTypeEnum::LABORATORY->value) {
                $billType = 'Laboratory Bill';
            }

            if ($value['billing_type_id'] === BillingTypeEnum::RADIOLOGY->value) {
                $billType = 'Radiology Bill';
            }

            if (count($billing['details']) > 16 && ($key + 1) % 16 === 0) {
                $billingItemsCounter = -1;
                $billingDetailsCount++;
            }

            $billingItemsCounter++;
        }

        if (
            count($billing['details']) % 16 === 0
            || ($billing['total_discount'] > 0 && $billingItemsCounter % 14 === 0)
            || ($billing['total_discount'] > 0 && $billingItemsCounter % 15 === 0)
        ) {
            $billingDetails[] = [null];
        }

        $billing['details'] = $billingDetails;

        return Inertia::render('print-templates/billing', compact(
            'printTitle',
            'billing',
            'qrUrl',
            'printedBy',
            'discountType',
            'discountIdNo',
            'discountPercent',
            'billType',
        ));
    }

    public function printLaboratory(string $laboratoryId): Response
    {
        $printData = [];

        $laboratory = Laboratory::with(
            'visit.patient',
            'visit.patient.barangay',
            'visit.patient.city',
            'visit.patient.province',
            'visit.patient.gender',
            'visit.patient.civilStatus',
            'performedBy.professions',
            'performedBy.specialties',
            'visit.consultation.doctor.professions',
            'visit.consultation.doctor.specialties',
            'remarks',
        )->find($laboratoryId);

        $patient = $laboratory?->visit->patient;

        $chemOthers = [
            LaboratoryTestEnum::RBS,
            LaboratoryTestEnum::HBA1C,
            LaboratoryTestEnum::OGTT_75G,
        ];

        // Clinical Chemistry
        $clinicalChemistry = LaboratoryTestFieldData::with('field', 'testData', 'testData.test')
            ->where('laboratory_test_field_data.laboratory_id', $laboratoryId)
            ->whereRelation('testData', 'laboratory_type_id', LaboratoryTypeEnum::CLINICAL_CHEMISTRY)
            ->whereDoesntHave('testData.test', function ($query) use ($chemOthers) {
                $query->whereIn('id', $chemOthers);
            })
            ->orderBy(
                LaboratoryField::select('order')
                    ->whereColumn('laboratory_fields.id', 'laboratory_test_field_data.laboratory_field_id')
                    ->limit(1), 
                'asc')
            ->get()->toArray();

        $clinicalChemistryOthers = LaboratoryTestFieldData::with('field', 'testData', 'testData.test')
            ->where('laboratory_test_field_data.laboratory_id', $laboratoryId)
            ->whereRelation('testData', 'laboratory_type_id', LaboratoryTypeEnum::CLINICAL_CHEMISTRY)
            ->whereHas('testData.test', function ($query) use ($chemOthers) {
                $query->whereIn('id', $chemOthers);
            })
            ->orderBy(
                LaboratoryField::select('order')
                    ->whereColumn('laboratory_fields.id', 'laboratory_test_field_data.laboratory_field_id')
                    ->limit(1), 
                'asc')
            ->get()->toArray();

        // Hematology
        $hematology = LaboratoryTestFieldData::with('field', 'testData', 'testData.test')
            ->where('laboratory_test_field_data.laboratory_id', $laboratoryId)
            ->whereRelation('testData', 'laboratory_type_id', LaboratoryTypeEnum::CLINICAL_HEMATOLOGY)
            ->orderBy(
                LaboratoryField::select('order')
                    ->whereColumn('laboratory_fields.id', 'laboratory_test_field_data.laboratory_field_id')
                    ->limit(1), 
                'asc')
            ->get()->toArray();
        
        // Urinalysis
        $urinalysis = LaboratoryTestData::with([
            'test',
            'fields' => function ($query) {
                $query->join('laboratory_fields', 'laboratory_test_field_data.laboratory_field_id', '=', 'laboratory_fields.id') // Replace table names / keys if different
                    ->orderBy('laboratory_fields.order', 'asc')
                    ->select('laboratory_test_field_data.*'); // Keeps original model attributes intact
            },
            'fields.field',
        ])->where('laboratory_id', $laboratoryId)
            ->where('laboratory_test_id', LaboratoryTestEnum::URINALYSIS)
            ->orderByRaw('ROW_NUMBER() OVER (ORDER BY created_at DESC, id ASC) ASC')->get()->toArray();
        
        // Fecalysis
        $fecalysisPartial = [];
        $fecalysis = LaboratoryTestData::with([
            'test',
            'fields' => function ($query) {
                $query->join('laboratory_fields', 'laboratory_test_field_data.laboratory_field_id', '=', 'laboratory_fields.id') // Replace table names / keys if different
                    ->orderBy('laboratory_fields.order', 'asc')
                    ->select('laboratory_test_field_data.*'); // Keeps original model attributes intact
            },

            'fields.field',
        ])->where('laboratory_id', $laboratoryId)
            ->whereIn('laboratory_test_id', [LaboratoryTestEnum::FECALYSIS, LaboratoryTestEnum::FECAL_OCCULT_BLOOD])
            ->get()->toArray();
        
        if (count($fecalysis) === 1) {
            if ($fecalysis[0]['test']['id'] === LaboratoryTestEnum::FECAL_OCCULT_BLOOD->value) {
                $fecalysisPartial = $fecalysis;
                $fecalysis = [];
            }
        }

        if (count($fecalysis) > 1) {
            // inserts occult blood in array[6] if both fecalysis and fecal occult blood is checked
            array_splice($fecalysis[0]['fields'], 6, 0, [$fecalysis[1]['fields'][0]]);
            unset($fecalysis[1]);
        }

        $miscellaneous = LaboratoryTestData::with([
            'test',
            'fields',
            'fields.field',
        ])->where('laboratory_id', $laboratoryId)
            ->where(function ($query) {
                $query->whereRelation('test', 'laboratory_type_id', LaboratoryTypeEnum::IMMUNOLOGY_SEROLOGY)
                    ->orWhereIn('laboratory_test_id', [
                        LaboratoryTestEnum::PREGNANCY_URINE,
                    ]);
            })
            ->get()->toArray();

        if (! empty($clinicalChemistry)) {
            $printData[] = [
                'name'    => 'CLINICAL CHEMISTRY',
                'data'    => $clinicalChemistry,
                'type_id' => LaboratoryTypeEnum::CLINICAL_CHEMISTRY,
            ];
        }
        if (! empty($clinicalChemistryOthers)) {
            $printData[] = [
                'name'    => 'CLINICAL CHEMISTRY OTHERS',
                'data'    => $clinicalChemistryOthers,
                'type_id' => LaboratoryTypeEnum::CLINICAL_CHEMISTRY,
            ];
        }

        if (! empty($hematology)) {
            $testIds = array_column(array_column(array_column($hematology, 'test_data'), 'test'), 'id');
            $printData[] = [
                'name'    => 'HEMATOLOGY',
                'data'    => $hematology,
                'type_id' => LaboratoryTypeEnum::CLINICAL_HEMATOLOGY,
                'showPartial' => !in_array(LaboratoryTestEnum::CBC_W_PLATELET_COUNT->value, $testIds)
                    && !in_array(LaboratoryTestEnum::COMPLETE_BLOOD_COUNT->value, $testIds)
            ];
        }
        if (! empty($fecalysis)) {
            $printData[] = [
                'name'    => 'FECALYSIS',
                'data'    => $fecalysis,
                'test_id' => LaboratoryTestEnum::FECALYSIS,
            ];
        }
        if (! empty($fecalysisPartial)) {
            $printData[] = [
                'name'    => 'FECALYSIS PARTIAL',
                'data'    => $fecalysisPartial,
                'test_id' => LaboratoryTestEnum::FECALYSIS,
            ];
        }

        if (! empty($urinalysis)) {
            $printData[] = [
                'name'    => 'URINALYSIS',
                'data'    => $urinalysis,
                'test_id' => LaboratoryTestEnum::URINALYSIS,
            ];
        }

        if (! empty($miscellaneous)) {
            $printData[] = [
                'name'    => 'MISCELLANEOUS',
                'data'    => $miscellaneous,
                'type_id' => LaboratoryTypeEnum::IMMUNOLOGY_SEROLOGY,
            ];
        }

        $remarks = $laboratory?->remarks?->toArray() ?? [];
        $remarksTest = array_column($remarks, 'remarks', 'laboratory_test_id');
        $remarksType = array_column($remarks, 'remarks', 'laboratory_type_id');

        $leftFullName = strtoupper($laboratory->performedBy?->full_name ?? '');
        $leftLicNo = $laboratory->performedBy?->license_no ?? '';

        $rightFullName = 'MARIANETTE NOELLE M. BIEREN, MD, FPSP';
        $rightLicNo = '108620';

        return Inertia::render('print-templates/laboratory', compact(
            'printData',
            'laboratory',
            'patient',
            'rightFullName',
            'rightLicNo',
            'leftFullName',
            'leftLicNo',
            'remarksTest',
            'remarksType',
        ));
    }

    public function printReceipt(string $receiptId): Response
    {
        abortIfInvalidUuid($receiptId);

        $receiptData = Payment::with([
            'cashier.billing.details',
            'cashier.pharmacy.details',
            'cashier.pharmacy.pickList',
            'method',
            'createdBy' => function ($query) {
                $query->select('id', 'first_name', 'middle_name', 'last_name');
            },
            'createdBy.professions',
            'createdBy.specialties',
        ])->find($receiptId);

        if (empty($receiptData)) {
            abort(404);
        }

        $billing = $receiptData['cashier']['billing'];
        $pharmacy = $receiptData['cashier']['pharmacy'];

        $itemData = $billing ?? $pharmacy;
        $transactionType = $billing ? 'BILLING' : 'PHARMACY';

        if ($billing) {
            $transactionNo = $itemData->transaction_header.'-'.sprintf('%08d', $itemData->transaction_no);
        } else {
            $transactionNo = $itemData->pickList?->transaction_no;
        }

        $companyProfile = CompanyProfile::find(1);

        return Inertia::render('print-templates/receipt', compact(
            'receiptData',
            'itemData',
            'transactionType',
            'transactionNo',
            'companyProfile',
        ));
    }

    public function printPharmacyPickList(string $pharmacyId)
    {
        abortIfInvalidUuid($pharmacyId);

        $pickListData = app(PrintService::class)->generatePickList($pharmacyId);

        $pickListDetails = Pharmacy::with('details')->find($pharmacyId);

        if (empty($pickListDetails)) {
            abort(404);
        }

        return Inertia::render('print-templates/pick-list', compact('pickListDetails', 'pickListData'));
    }
}
