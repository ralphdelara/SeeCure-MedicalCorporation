<?php

namespace App\Http\Controllers;

use App\Models\DocumentType;
use App\Models\InventoryCategory;
use App\Models\Laboratory;
use App\Models\PatientVitalSign;
use App\Models\Prescription;
use App\Models\Relationship;
use App\Models\SignsOrSymptom;
use App\Models\Visit;
use App\Models\VitalSign;
use App\Services\ConsultationService;
use App\Services\DoctorService;
use App\Services\LaboratoryService;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class ConsultationController extends Controller
{
    public function getConsultationList(Request $request, ?string $status = null): Response
    {
        $consultationList = app(ConsultationService::class)->getConsultationList(
            $request->keyword,
            $status,
            $request->path(),
        );

        return Inertia::render('consultation/index', compact(
            'consultationList',
        ));
    }

    public function getPendingConsultationList(Request $request): Response
    {
        $consultationList = app(ConsultationService::class)->getConsultationList(
            $request->keyword,
            $request->selectId,
            $request->path(),
        );

        return Inertia::render('consultation/index', compact(
            'consultationList',
        ));
    }

    public function getConsultationDetails(string $consultationId): Response
    {
        $consultationDetails = app(ConsultationService::class)->getConsultationDetails($consultationId);
        $signsOrSymptoms = SignsOrSymptom::all();
        $vitalSigns = VitalSign::with('fields')->get();
        $patientDetails = $consultationDetails['visit']['patient'];
        $patientDetails['visits'] = Visit::with([
            // consultation
            'consultation',
            'consultation.soap',
            'consultation.diagnosis',
            'consultation.diagnosis.icd10Codes.icd10Code',
            'consultation.prescriptions',
            'consultation.doctor.professions',
            'consultation.doctor.specialties',
            'consultation.signsOrSymptoms',
            'consultation.guardianRelationship',
            'consultation.vitalSigns.vitalSign',
            'consultation.vitalSigns.vitalSignField',
            'consultation.vitalSigns.createdBy' => function ($query) {
                $query->select('id', 'first_name', 'middle_name', 'last_name');
            },
            'consultation.vitalSigns.createdBy.professions',
            'consultation.vitalSigns.createdBy.specialties',
            'consultation.vitalSigns.lastModifiedBy' => function ($query) {
                $query->select('id', 'first_name', 'middle_name', 'last_name');
            },
            'consultation.vitalSigns.lastModifiedBy.professions',
            'consultation.vitalSigns.lastModifiedBy.specialties',
            // laboratory
            'laboratory.remarks',
            'laboratory.testData',
            'laboratory.testData.type',
            'laboratory.testData.test',
            'laboratory.testData.fields' => function ($query) {
                $query->orderBy('id');
            },
            'laboratory.testData.fields.field',
            'laboratory.performedBy' => function ($query) {
                $query->select('id', 'first_name', 'middle_name', 'last_name');
            },
            'laboratory.performedBy.professions',
            'laboratory.performedBy.specialties',
            'laboratory.createdBy' => function ($query) {
                $query->select('id', 'first_name', 'middle_name', 'last_name');
            },
            'laboratory.createdBy.professions',
            'laboratory.createdBy.specialties',
            'laboratory.lastModifiedBy' => function ($query) {
                $query->select('id', 'first_name', 'middle_name', 'last_name');
            },
            'laboratory.lastModifiedBy.professions',
            'laboratory.lastModifiedBy.specialties',
            // radiology
            'radiology',
            'createdBy',
            'createdBy.professions',
            'createdBy.specialties',
            'priorityTypes',
            'status',
        ])->where('patient_id', $patientDetails['id'])
            ->where('id', '!=', $consultationDetails['visit']['id'])->get();

        $laboratory = $consultationDetails['visit']['laboratory'];
        $doctors = app(DoctorService::class)->getDoctorList();
        $relationshipOptions = Relationship::all();
        $inventoryCategories = InventoryCategory::all();
        $laboratoryFormOptions = app(LaboratoryService::class)->getLaboratoryFormOptions();
        $documentTypeOptions = DocumentType::all();

        return Inertia::render('consultation/details/index', compact(
            'consultationDetails',
            'signsOrSymptoms',
            'vitalSigns',
            'patientDetails',
            'doctors',
            'relationshipOptions',
            'documentTypeOptions',
            'inventoryCategories',
            'laboratoryFormOptions',
            'laboratory',
        ));
    }

    public function updateDetails(Request $request): void
    {
        $details = $request->only('id', 'prescription_remarks', 'guardian_name', 'guardian_contact_number', 'guardian_email', 'guardian_relationship_id', 'signs_or_symptoms_id', 'doctor_id', 'consult_reason');

        app(ConsultationService::class)->updateDetails($details);
    }

    public function updateSoap(Request $request): void
    {
        $soapDetails = $request->only('id', 'subjective', 'assessment', 'plan');

        app(ConsultationService::class)->updateSoap($soapDetails);
    }

    public function updateDiagnosis(Request $request): void
    {
        $diagnosisDetails = $request->only('id', 'diagnosis', 'icd10Ids');

        app(ConsultationService::class)->updateDiagnosis($diagnosisDetails);
    }

    public function addOrUpdatePrescription(Request $request): void
    {
        $request->validate([
            'consultation_id' => 'required',
            'inventory_name'  => 'required',
            'quantity'        => 'required',
            'dosage'          => 'required',
        ]);

        $prescriptionDetails = $request->only(
            'id',
            'consultation_id',
            'inventory_id',
            'inventory_name',
            'quantity',
            'dosage',
            'sig',
        );

        app(ConsultationService::class)->addOrUpdatePrescription($prescriptionDetails);
    }

    public function addOrUpdateVitalSigns(Request $request): void
    {
        $request->validate([
            'consultation_id' => 'required',
            'patient_id'      => 'required',
            'vital_sign_id'   => 'required',
        ]);

        $fields = $request->collect()
            ->filter(function ($value, $key) {
                return str_starts_with($key, 'field_id_');
            })
            ->all();

        $vitalSignDetails = $request->only('id', 'consultation_id', 'patient_id', 'vital_sign_id');

        app(ConsultationService::class)->addOrUpdateVitalSigns($vitalSignDetails, $fields);
    }

    public function deletePrescription(string $id): void
    {
        Prescription::destroy($id);
    }

    public function deleteVitalSigns(string $patientVitalSignsId): void
    {
        PatientVitalSign::destroy($patientVitalSignsId);
    }

    public function getAuditLog(string $consultationId): array
    {
        return app(ConsultationService::class)->getAuditLog($consultationId);
    }

    public function completeConsultation(string $consultationId): void
    {
        app(ConsultationService::class)->completeConsultation($consultationId);
    }

    public function addLaboratory(Request $request): void
    {
        $laboratoryDetails = $request->only(
            'visit_id',
            'laboratory_id',
            'laboratory_package_id',
            'other_test_ids',
        );

        // Prevent adding new record if has pending laboratory
        $pendingLabCount = Laboratory::where('visit_id', $laboratoryDetails['visit_id'])
            ->where('is_completed', false)->count();

        if ($pendingLabCount > 0) {
            return;
        }

        // sets has_laboratory to true because the visit record will now have a laboratory record
        Visit::find($laboratoryDetails['visit_id'])->update([
            'has_laboratory' => true,
        ]);

        app(LaboratoryService::class)->storeLaboratory($laboratoryDetails['visit_id'], $laboratoryDetails);
    }
}
