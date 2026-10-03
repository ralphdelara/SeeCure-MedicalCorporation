<?php

namespace App\Http\Controllers;

use App\Enums\LaboratoryTestEnum;
use App\Enums\LaboratoryTypeEnum;
use App\Models\Billing;
use App\Models\CompanyProfile;
use App\Models\Consultation;
use App\Models\Laboratory;
use App\Models\LaboratoryTestData;
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
        $printTitle = 'BILLING';
        $billing = Billing::with('details', 'visit.patient.suffix')->find($billingId);
        $qrUrl = $this->qrUrl.('Billing|'.$billing->visit->patient->full_name.'||Billing Details|'.$billing->created_at);
        $printedBy = Auth::user()->full_name;

        return Inertia::render('print-templates/billing', compact(
            'printTitle',
            'billing',
            'qrUrl',
            'printedBy',
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
            'remarks',
        )->find($laboratoryId);

        $patient = $laboratory?->visit->patient;

        // Clinical Chemistry
        $clinicalChemistry = LaboratoryTestData::with([
            'test',
            'fields' => function ($query) {
                $query->orderBy('id');
            },
            'fields.field',
        ])
            ->where('laboratory_id', $laboratoryId)
            ->where('laboratory_type_id', LaboratoryTypeEnum::CLINICAL_CHEMISTRY)
            ->get()
            ->toArray();
        $hematology = LaboratoryTestData::with([
            'test',
            'fields' => function ($query) {
                $query->orderBy('id');
            },
            'fields.field',
        ])->where('laboratory_id', $laboratoryId)
            ->where('laboratory_type_id', LaboratoryTypeEnum::CLINICAL_HEMATOLOGY)->get()->toArray();
        // Urinalysis
        $urinalysis = LaboratoryTestData::with([
            'test',
            'fields' => function ($query) {
                $query->orderBy('id');
            },
            'fields.field',
        ])->where('laboratory_id', $laboratoryId)
            ->where('laboratory_test_id', LaboratoryTestEnum::URINALYSIS)->get()->toArray();
        // Fecalysis
        $fecalysis = LaboratoryTestData::with([
            'test',
            'fields' => function ($query) {
                $query->orderBy('id');
            },
            'fields.field',
        ])->where('laboratory_id', $laboratoryId)
            ->where('laboratory_test_id', LaboratoryTestEnum::FECALYSIS)->get()->toArray();

        $miscellaneous = LaboratoryTestData::with([
            'test',
            'fields' => function ($query) {
                $query->orderBy('id');
            },
            'fields.field',
        ])->where('laboratory_id', $laboratoryId)
            ->whereNotIn('laboratory_test_id', array_column($clinicalChemistry, 'laboratory_test_id'))
            ->whereNotIn('laboratory_test_id', array_column($hematology, 'laboratory_test_id'))
            ->whereNotIn('laboratory_test_id', array_column($urinalysis, 'laboratory_test_id'))
            ->whereNotIn('laboratory_test_id', array_column($fecalysis, 'laboratory_test_id'))
            ->get()->toArray();

        if (! empty($clinicalChemistry)) {
            $printData[] = [
                'name'    => 'CLINICAL CHEMISTRY',
                'data'    => $clinicalChemistry,
                'type_id' => LaboratoryTypeEnum::CLINICAL_CHEMISTRY,
            ];
        }
        if (! empty($hematology)) {
            $printData[] = [
                'name'    => 'HEMATOLOGY',
                'data'    => $hematology,
                'type_id' => LaboratoryTypeEnum::CLINICAL_HEMATOLOGY,
            ];
        }
        if (! empty($fecalysis)) {
            $printData[] = [
                'name'    => 'FECALYSIS',
                'data'    => $fecalysis,
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

        $remarks = $laboratory->remarks->toArray();
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
            'cashier.billing.details', 'cashier.pharmacy.details', 'method',
            'createdBy' => function ($query) {
                $query->select('id', 'first_name', 'middle_name', 'last_name');
            },
            'createdBy.professions',
            'createdBy.specialties',
        ])->find($receiptId);
        $company = CompanyProfile::find(1);

        if (empty($receiptData)) {
            abort(404);
        }

        $billing = $receiptData['cashier']['billing'];
        $pharmacy = $receiptData['cashier']['pharmacy'];

        $itemData = $billing ?? $pharmacy;
        $transactionNo = $itemData->transaction_no;

        $companyDetails = config('company');

        return Inertia::render('print-templates/receipt', compact(
            'receiptData',
            'itemData',
            'company',
            'transactionNo',
            'companyDetails',
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
