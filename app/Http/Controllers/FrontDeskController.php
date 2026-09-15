<?php

namespace App\Http\Controllers;

use App\Enums\PriorityTypeEnum;
use App\Enums\VisitStatusEnum;
use App\Events\NotifyBilling;
use App\Events\NotifyDoctor;
use App\Models\Patient;
use App\Models\PriorityType;
use App\Models\Relationship;
use App\Models\SignsOrSymptom;
use App\Models\Visit;
use App\Models\VitalSign;
use App\Services\BillingService;
use App\Services\CashierService;
use App\Services\ConsultationService;
use App\Services\DoctorService;
use App\Services\LaboratoryService;
use App\Services\PatientService;
use App\Services\PatientVitalSignService;
use App\Services\PharmacyService;
use App\Services\RadiologyService;
use App\Services\VisitService;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Inertia\Inertia;
use Inertia\Response;

class FrontDeskController extends Controller
{
    public function index(): Response
    {
        $formOptions = app(PatientService::class)->getPatientFormOptions();
        $signsOrSymptoms = SignsOrSymptom::all();
        $vitalSigns = VitalSign::with('fields')->get();
        $doctors = app(DoctorService::class)->getDoctorList();
        $laboratoryTestOptions = [];
        $relationshipOptions = Relationship::all();
        $consultationList = app(ConsultationService::class)->getSmallPendingConsultationList();
        $laboratoryList = app(LaboratoryService::class)->getSmallPendingLaboratoryList();
        $billingList = app(BillingService::class)->getSmallPendingBillingList();
        $cashierList = app(CashierService::class)->getSmallPendingCashierList();
        $radiologyList = app(RadiologyService::class)->getSmallPendingRadiologyList();
        $pharmacyList = app(PharmacyService::class)->getSmallPendingPharmacyList();
        $priorityTypeOptions = PriorityType::all();
        $laboratoryFormOptions = app(LaboratoryService::class)->getLaboratoryFormOptions();

        return Inertia::render('front-desk/index', compact(
            'formOptions',
            'signsOrSymptoms',
            'vitalSigns',
            'doctors',
            'relationshipOptions',
            'laboratoryTestOptions',
            'consultationList',
            'laboratoryList',
            'billingList',
            'cashierList',
            'radiologyList',
            'pharmacyList',
            'priorityTypeOptions',
            'laboratoryFormOptions',
        ));
    }

    public function queue(Request $request): void
    {
        $this->validate($request);

        $patientDetails = $this->queuePatient($request);

        $patientId = $patientDetails['patientId'];

        $visitId = $this->queueVisit($request, $patientId, $patientDetails['isSenior']);

        $consultationId = null;

        if ($request->has_consultation === 1) {
            $consultationId = $this->queueConsultation(
                $request,
                $patientId,
                $visitId,
            );
        }

        $laboratoryId = null;

        if ($request->has_laboratory === 1) {
            $laboratoryId = $this->queueLaboratory(
                $request,
                $patientId,
                $visitId,
                $consultationId,
            );
        }

        $radiologyId = null;

        if ($request->has_radiology === 1) {
            $radiologyId = $this->queueRadiology(
                $request,
                $patientId,
                $visitId,
                $consultationId,
            );
        }

        // set consultationIdForBilling to null if theres a laboratory or radiology request
        // because the patient is not yet consulted so there shouldnt be Consultation in billing
        if (! empty($laboratoryId) || ! empty($radiologyId)) {
            $consultationIdForBilling = null;
            // create billing and cashier data if there is a laboratory or radiology
            // billing id for payment data
            $billingId = app(BillingService::class)->storeBilling(
                $patientId,
                $visitId,
                $consultationIdForBilling,
                $laboratoryId,
                $radiologyId,
            );

            app(CashierService::class)->storeCashier(
                $patientId,
                $visitId,
                $billingId,
            );

            broadcast(new NotifyBilling(
                'Notification',
                'Patient has been placed in billing',
                Visit::where('visit_status_id', VisitStatusEnum::IN_BILLING)->count(),
            ));

            app(VisitService::class)->notifyFrontDesk();
        }

        if (
            $request->has_laboratory === 0
            && $request->has_radiology === 0
            && $request->has_consultation === 1
        ) {
            broadcast(new NotifyDoctor(
                'Notification',
                'Patient has been placed in consultation',
                Visit::where('visit_status_id', VisitStatusEnum::IN_CONSULTATION)->count(),
            ));

            app(VisitService::class)->notifyFrontDesk();
        }
    }

    public function validate(Request $request)
    {
        $request->validate([
            'patient_id'           => 'required_if:form_type,existing',
            'last_name'            => 'required_if:form_type,new|max:50',
            'first_name'           => 'required_if:form_type,new|max:50',
            'doctor_id'            => 'required_if:has_consultation,1',
            'signs_or_symptoms_id' => 'required_if:has_consultation,1',
            'has_consultation'     => [
                Rule::prohibitedIf(
                    fn () => (int) request('has_consultation') === 0 && (int) request('has_laboratory') === 0,
                ),
            ],
        ], [
            'patient_id.required_if' => 'Please select a patient.',

            'last_name.required_if' => 'The last name is required.',
            'last_name.min'         => 'The last name must be at least 3 characters.',
            'last_name.max'         => 'The last name may not be greater than 50 characters.',

            'first_name.required_if' => 'The first name is required.',
            'first_name.min'         => 'The first name must be at least 3 characters.',
            'first_name.max'         => 'The first name may not be greater than 50 characters.',

            'doctor_id.required_if'         => 'Please select a doctor.',
            'signs_or_symptoms_id.required' => 'Please select the signs or symptoms.',

            'has_consultation.prohibited' => 'Please select a medical service.',

            'form_type.required' => 'The form type selection is required.',
        ]);
    }

    public function queuePatient(Request $request): array
    {
        $patientDetails = $request->only(
            'patient_id',
            'last_name',
            'first_name',
            'middle_name',
            'date_of_birth',
            'age',
            'contact_number1',
            'contact_number2',
            'email',
            'occupation',
            'philhealth_id',
            'house_no',
            'street',
            'barangay_id',
            'city_id',
            'province_id',
            'photo',
            'gender_id',
            'civil_status_id',
            'nationality_id',
            'patient_suffix_id',
            'senior_citizen_id',
        );

        $patientId = $patientDetails['patient_id'];
        $isSenior = false;

        if (! empty($patientDetails['date_of_birth'])) {
            if (computeExactAge($patientDetails['date_of_birth']) >= 60) {
                $isSenior = true;
            } else {
                $patientDetails['senior_citizen_id'] = '';
            }
        }

        if ($request->input('form_type') === 'new') {
            $patient = app(PatientService::class)->addOrUpdatePatient($patientDetails);
            $patientId = $patient->id;
        }

        if ($request->input('form_type') === 'existing') {
            $patient = Patient::find($patientId);

            $isSenior = $patient->is_senior;
        }

        return [
            'patientId' => $patientId,
            'isSenior'  => $isSenior,
        ];
    }

    public function queueVisit(Request $request, string $patientId, bool $isSenior): string
    {
        $visitDetails = $request->only(
            'patient_id',
            'has_consultation',
            'has_laboratory',
            'has_radiology',
            'is_emergency',
            'priority_type_ids',
        );

        if (
            $visitDetails['has_laboratory'] === 1
            || $visitDetails['has_radiology'] === 1
        ) {
            $visitDetails['visit_status_id'] = VisitStatusEnum::IN_BILLING;
        } else {
            $visitDetails['visit_status_id'] = VisitStatusEnum::IN_CONSULTATION;
        }

        if ($isSenior) {
            $visitDetails['priority_type_ids'][] = PriorityTypeEnum::SENIOR_CITIZEN;
        }

        return app(VisitService::class)->storeVisit($patientId, $visitDetails);
    }

    public function queueConsultation(
        Request $request,
        string $patientId,
        string $visitId,
    ): string {
        $consultDetails = $request->only(
            'guardian_name',
            'guardian_contact_number',
            'guardian_email',
            'guardian_relationship_id',
            'doctor_id',
            'consultation_types_id',
            'signs_or_symptoms_id',
            'consult_reason',
        );
        $vitalSigns = $request->vital_signs;

        $consultationId = app(ConsultationService::class)->storeConsultation($visitId, $patientId, $consultDetails);

        app(PatientVitalSignService::class)->storeVitalSigns($patientId, $consultationId, $vitalSigns);

        return $consultationId;
    }

    public function queueLaboratory(
        Request $request,
        string $patientId,
        string $visitId,
        ?string $consultationId,
    ): string {
        $laboratoryDetails = $request->only(
            'laboratory_id',
            'laboratory_package_id',
            'other_test_ids',
        );

        return app(LaboratoryService::class)->storeLaboratory($visitId, $patientId, $consultationId, $laboratoryDetails);
    }

    public function queueRadiology(
        Request $request,
        string $patientId,
        string $visitId,
        string $consultationId,
    ): string {
        return '';
    }

    public function deleteQueue(string $id): void
    {
        Visit::destroy($id);
    }
}
