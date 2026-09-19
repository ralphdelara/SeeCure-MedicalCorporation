<?php

namespace App\Http\Controllers;

use App\Enums\LaboratoryTestEnum;
use App\Enums\LaboratoryTypeEnum;
use App\Models\Billing;
use App\Models\CompanyProfile;
use App\Models\Laboratory;
use App\Models\LaboratoryTestData;
use App\Models\Payment;
use App\Models\Pharmacy;
use App\Models\Prescription;
use Inertia\Inertia;
use Inertia\Response;

class PrintController extends Controller
{
    public function __construct(public string $qrUrl = 'https://see-cure.vercel.app/?data=') {}

    public function printPrescription(string $consultationId): Response
    {
        $prescription = Prescription::with(
            'consultation',
            'consultation.doctor.professions',
            'consultation.doctor.specialties',
        )->where('consultation_id', $consultationId)->get();

        $printTitle = 'PRESCRIPTION';
        $consultation = $prescription?->first()?->consultation;
        $rightFullName = $consultation?->doctor->full_name;
        $rightLicNo = $consultation?->doctor->license_no;
        $rightPtrNo = $consultation?->doctor->ptr_no;

        return Inertia::render('print-templates/prescription', compact(
            'printTitle',
            'rightFullName',
            'rightLicNo',
            'rightPtrNo',
            'prescription',
        ));
    }

    public function printBilling(string $billingId): Response
    {
        $printTitle = 'BILLING';
        $billing = Billing::with('details', 'visit.patient.suffix')->find($billingId);
        $qrUrl = $this->qrUrl.('Billing|'.$billing->visit->patient->full_name.'||Billing Details|'.$billing->created_at);

        return Inertia::render('print-templates/billing', compact(
            'printTitle',
            'billing',
            'qrUrl',
        ));
    }

    public function printLaboratory(string $laboratoryId): Response
    {
        $printData = [];

        $laboratory = Laboratory::with(
            'patient',
            'patient.barangay',
            'patient.city',
            'patient.province',
            'patient.gender',
            'patient.civilStatus',
            'performedBy.professions',
            'performedBy.specialties',
            'remarks',
        )->find($laboratoryId);

        $patient = $laboratory?->patient;

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

        $receiptData = Payment::with('cashier.billing.details', 'cashier.pharmacy.details')->find($receiptId);
        $company = CompanyProfile::find(1);
        $billing = $receiptData['cashier']['billing'];
        $pharmacy = $receiptData['cashier']['pharmacy'];

        $itemData = $billing ?? $pharmacy;

        if (empty($receiptData)) {
            abort(404);
        }

        return Inertia::render('print-templates/receipt', compact('receiptData', 'itemData', 'company'));
    }

    public function printPharmacyPickList(string $pharmacyId)
    {
        abortIfInvalidUuid($pharmacyId);

        $pickListDetails = Pharmacy::with('details')->find($pharmacyId);

        if (empty($pickListDetails)) {
            abort(404);
        }

        return Inertia::render('print-templates/pick-list', compact('pickListDetails'));
    }
}
