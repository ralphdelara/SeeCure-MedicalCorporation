<?php

namespace App\Http\Controllers;

use App\Enums\ConsultationStatusEnum;
use App\Events\NotifyDoctor;
use App\Models\LaboratoryTestType;
use App\Models\SignsOrSymptom;
use App\Models\VitalSign;
use App\Services\ConsultationService;
use App\Services\DoctorService;
use App\Services\LaboratoryService;
use App\Services\PatientService;
use App\Services\PatientVitalSignService;
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
        $laboratoryTestOptions = LaboratoryTestType::all();
        $incompleteConsultationList = app(ConsultationService::class)->getIncompleteConsultation();
        $incompleteConsultationStatuses = ConsultationStatusEnum::incompleteStatusesDropdown();

        return Inertia::render('front-desk/index', compact(
            'formOptions',
            'signsOrSymptoms',
            'vitalSigns',
            'doctors',
            'laboratoryTestOptions',
            'incompleteConsultationList',
            'incompleteConsultationStatuses',
        ));
    }

    public function queuePatient(Request $request): void
    {
        $request->validate([
            'patient_id'           => 'required_if:form_type,existing',
            'last_name'            => 'required_if:form_type,new|max:50',
            'first_name'           => 'required_if:form_type,new|max:50',
            'doctor_id'            => 'required_if:has_consultation,1',
            'signs_or_symptoms_id' => 'required',
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
        );

        $consultDetails = $request->only(
            'guardian_name',
            'guardian_contact_number',
            'guardian_email',
            'doctor_id',
            'consultation_types_id',
            'signs_or_symptoms_id',
        );

        $vitalSigns = $request->vital_signs;

        $patientId = $request->input('patient_id');

        if ($request->input('form_type') === 'new') {
            $patientId = app(PatientService::class)->addOrUpdatePatient($patientDetails);
        }

        $visitId = app(VisitService::class)->queuePatient($patientId, $consultDetails);

        $consultationId = null;

        if ($request->has_consultation === 1) {
            $consultationId = app(ConsultationService::class)->storeConsultation($visitId, $patientId, $consultDetails);

            broadcast(new NotifyDoctor(
                'Notification',
                'A new patient has been queued',
                0,
                $consultDetails['doctor_id'],
            ));
        }

        if ($request->has_laboratory === 1) {
            app(LaboratoryService::class)->storeLaboratory($visitId, $patientId, $consultDetails);
        }

        app(PatientVitalSignService::class)->storeVitalSigns($patientId, $consultationId, $vitalSigns);
    }
}
