<?php

namespace App\Http\Controllers;

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
        $laboratory = $consultationDetails['visit']['laboratory'];
        $doctors = app(DoctorService::class)->getDoctorList();
        $relationshipOptions = Relationship::all();
        $inventoryCategories = InventoryCategory::all();
        $laboratoryFormOptions = app(LaboratoryService::class)->getLaboratoryFormOptions();

        return Inertia::render('consultation/details/index', compact(
            'consultationDetails',
            'signsOrSymptoms',
            'vitalSigns',
            'patientDetails',
            'doctors',
            'relationshipOptions',
            'inventoryCategories',
            'laboratoryFormOptions',
            'laboratory',
        ));
    }

    public function updateDetails(Request $request): void
    {
        $details = $request->only('id', 'guardian_name', 'guardian_contact_number', 'guardian_email', 'guardian_relationship_id', 'signs_or_symptoms_id', 'doctor_id', 'consult_reason');

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
