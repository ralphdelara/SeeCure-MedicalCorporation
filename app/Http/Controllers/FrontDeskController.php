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
        $priorityTypeOptions = PriorityType::all();
        $laboratoryFormOptions = app(LaboratoryService::class)->getLaboratoryFormOptions();

        return Inertia::render('front-desk/index', compact(
            'formOptions',
            'signsOrSymptoms',
            'vitalSigns',
            'doctors',
            'relationshipOptions',
            'laboratoryTestOptions',
            'priorityTypeOptions',
            'laboratoryFormOptions',
        ));
    }

    public function getQueueList()
    {
        $consultationList = app(ConsultationService::class)->getSmallPendingConsultationList();
        $laboratoryList = app(LaboratoryService::class)->getSmallPendingLaboratoryList();
        $billingList = app(BillingService::class)->getSmallPendingBillingList();
        $cashierList = app(CashierService::class)->getSmallPendingCashierList();
        $radiologyList = app(RadiologyService::class)->getSmallPendingRadiologyList();
        $pharmacyList = app(PharmacyService::class)->getSmallPendingPharmacyList();

        return compact(
            'consultationList',
            'laboratoryList',
            'billingList',
            'cashierList',
            'radiologyList',
            'pharmacyList',
        );
    }

    public function queue(Request $request): void
    {
        $this->validate($request);

        $patientDetails = $this->queuePatient($request);

        $patientId = $patientDetails['patientId'];

        $visitId = $this->queueVisit($request, $patientId, $patientDetails['isSenior'], $patientDetails['isPwd']);

        $laboratoryId = null;

        if ($request->has_laboratory === 1) {
            $laboratoryId = $this->queueLaboratory(
                $request,
                $visitId,
            );
        }

        $radiologyId = null;

        if ($request->has_radiology === 1) {
            $radiologyId = $this->queueRadiology(
                $request,
                $visitId,
            );
        }

        // create billing if visit has laboratory or radiology
        if ($request->has_laboratory === 1 || $request->has_radiology === 1) {
            app(BillingService::class)->storeBilling(
                visitId: $visitId,
                laboratoryId: $laboratoryId,
                radiologyId: $radiologyId,
            );

            broadcast(new NotifyBilling(
                'Notification',
                'Patient has been placed in billing',
                Visit::where('visit_status_id', VisitStatusEnum::IN_BILLING)->count(),
            ));
        }

        // create consultation and notify the doctor
        if ($request->has_consultation === 1) {
            $consultationId = $this->queueConsultation(
                $request,
                $visitId,
            );

            if (! empty($request->vital_signs)) {
                app(PatientVitalSignService::class)->storeVitalSigns($patientId, $consultationId, $request->vital_signs);
            }

            if (
                $request->has_laboratory === 0
                && $request->has_radiology === 0
            ) {
                broadcast(new NotifyDoctor(
                    'Notification',
                    'Patient has been placed in consultation',
                    Visit::where('visit_status_id', VisitStatusEnum::IN_CONSULTATION)->count(),
                ));
            }
        }
    }

    public function validate(Request $request)
    {
        $request->validate([
            'patient_id'            => 'required_if:form_type,existing',
            'last_name'             => 'required_if:form_type,new|max:50',
            'first_name'            => 'required_if:form_type,new|max:50',
            'doctor_id'             => 'required_if:has_consultation,1',
            'laboratory_package_id' => 'required_if:has_laboratory,1',
            'other_test_ids'        => 'required_if:laboratory_package_id,3',
            'has_consultation'      => [
                Rule::prohibitedIf(
                    fn () => (int) request('has_consultation') === 0 && (int) request('has_laboratory') === 0 && (int) request('has_radiology') === 0,
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

            'doctor_id.required_if'             => 'Please select a doctor.',
            'laboratory_package_id.required_if' => 'Please select a laboratory package.',
            'other_test_ids.required_if'        => 'Please select a laboratory test.',

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
            'pwd_id',
            'control_no',
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

        $isPwd = ! empty($patientDetails['pwd_id']);

        if ($request->input('form_type') === 'new') {
            // this will prevent replacing existing patients if accidentally selected
            $patientDetails['patient_id'] = null;

            if (empty($patientDetails['control_no'])) {
                unset($patientDetails['control_no']);
            }

            if ($request->is_walk_in === 1) {
                $patientDetails['control_no'] = '0';
            }

            $patient = app(PatientService::class)->addOrUpdatePatient($patientDetails);
            $patientDetails['patient_id'] = $patient->id;
            $patientId = $patient->id;
        }

        if ($request->input('form_type') === 'existing') {
            $patient = Patient::find($patientId);

            $isSenior = $patient->is_senior;
            $isPwd = $patient->is_pwd;
        }

        return [
            'patientId' => $patientId,
            'isSenior'  => $isSenior,
            'isPwd'     => $isPwd,
        ];
    }

    public function queueVisit(Request $request, string $patientId, bool $isSenior, bool $isPwd): string
    {
        $visitDetails = $request->only(
            'patient_id',
            'has_consultation',
            'has_laboratory',
            'has_radiology',
            'is_emergency',
            'is_walk_in',
            'priority_type_ids',
            'created_at',
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

        if ($isPwd && ! in_array(PriorityTypeEnum::PERSONS_WITH_DISABILITY->value, $visitDetails['priority_type_ids'])) {
            $visitDetails['priority_type_ids'][] = PriorityTypeEnum::PERSONS_WITH_DISABILITY;
        }

        return app(VisitService::class)->storeVisit($patientId, $visitDetails);
    }

    public function queueConsultation(
        Request $request,
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

        return app(ConsultationService::class)->storeConsultation($visitId, $consultDetails);
    }

    public function queueLaboratory(
        Request $request,
        string $visitId,
    ): string {
        $laboratoryDetails = $request->only(
            'laboratory_id',
            'laboratory_package_id',
            'other_test_ids',
        );

        return app(LaboratoryService::class)->storeLaboratory($visitId, $laboratoryDetails);
    }

    public function queueRadiology(
        Request $request,
        string $visitId,
    ): string {
        return '';
    }

    public function deleteQueue(string $id): void
    {
        Visit::destroy($id);
    }
}
