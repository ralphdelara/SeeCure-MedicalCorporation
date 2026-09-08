<?php

namespace App\Http\Controllers;

use App\Events\CallOut;
use App\Models\Consultation;
use App\Models\InventoryCategory;
use App\Models\LaboratoryTestType;
use App\Models\Prescription;
use App\Models\Relationship;
use App\Models\SignsOrSymptom;
use App\Models\VitalSign;
use App\Services\ConsultationService;
use App\Services\DoctorService;
use App\Services\LaboratoryService;
use App\Services\PatientService;
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

    public function getConsultationDetails(Request $request, string $consultationId): Response
    {
        $consultationDetails = app(ConsultationService::class)->getConsultationDetails($consultationId);
        $signsOrSymptoms = SignsOrSymptom::all();
        $vitalSigns = VitalSign::with('fields')->get();
        $patientDetails = app(PatientService::class)->getPatientDetails($consultationDetails['patient_id']);
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
        ));
    }

    public function updateDetails(Request $request): void
    {
        $details = $request->only('id', 'guardian_name', 'guardian_contact_number', 'guardian_email', 'guardian_relationship_id', 'signs_or_symptoms_id', 'doctor_id');

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

    public function deletePrescription(string $id): void
    {
        Prescription::destroy($id);
    }

    public function callOutPatient(Request $request): void
    {
        broadcast(new CallOut(
            $request->patientName ?? '',
            'Consultation',
        ));
    }

    public function getAuditLog(string $consultationId): array
    {
        return app(ConsultationService::class)->getAuditLog($consultationId);
    }

    public function completeConsultation(string $consultationId): void
    {
        app(ConsultationService::class)->completeConsultation($consultationId);
    }
}
