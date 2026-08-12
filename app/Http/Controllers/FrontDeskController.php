<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\CivilStatus;
use App\Models\ConsultationType;
use App\Models\Gender;
use App\Models\Nationality;
use App\Models\PatientSuffix;
use App\Models\Province;
use App\Models\SignsOrSymptom;
use App\Models\VitalSign;
use App\Services\ConsultationService;
use App\Services\DoctorService;
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
        $genderOptions = Gender::all();
        $nationalityOptions = Nationality::all();
        $civilStatusOptions = CivilStatus::all();
        $suffixOptions = PatientSuffix::all();
        $provinceOptions = Province::all();
        $cityOptions = City::select('id', 'name')->where('province_id', '=', 1)->get(); // Aklan
        $signsOrSymptoms = SignsOrSymptom::all();
        $vitalSigns = VitalSign::with('fields')->get();
        $consultationTypes = ConsultationType::all();
        $doctors = app(DoctorService::class)->getDoctorList();

        return Inertia::render('front-desk/index', compact(
            'genderOptions',
            'civilStatusOptions',
            'nationalityOptions',
            'suffixOptions',
            'provinceOptions',
            'cityOptions',
            'signsOrSymptoms',
            'vitalSigns',
            'consultationTypes',
            'doctors',
        ));
    }

    public function queuePatient(Request $request): void
    {
        $request->validate([
            'patient_id'           => 'required_if:form_type,existing',
            'last_name'            => 'required_if:form_type,new|min:3|max:50',
            'first_name'           => 'required_if:form_type,new|min:3|max:50',
            'doctor_id'            => 'required',
            'signs_or_symptoms_id' => 'required',
            'has_consultation' => [
                Rule::prohibitedIf(
                    fn () => (int) request('has_consultation') === 0 && (int) request('has_laboratory') === 0
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

            'doctor_id.required'            => 'Please select a doctor.',
            'signs_or_symptoms_id.required' => 'Please select the signs or symptoms.',

            'has_consultation.prohibited' => 'Please select a medical service.',

            'form_type.required' => 'The form type selection is required.',
        ]);

        $patientDetails = $request->only(
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
            $patientId = app(PatientService::class)->storePatient($patientDetails);
        }

        $visitId = app(VisitService::class)->queuePatient($patientId, $consultDetails);

        $consultationId = app(ConsultationService::class)->createConsultation($visitId, $patientId, $consultDetails);

        app(PatientVitalSignService::class)->storeVitalSigns($patientId, $consultationId, $vitalSigns);

    }
}
