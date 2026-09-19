<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use App\Models\VitalSign;
use App\Services\PatientService;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class PatientController extends Controller
{
    public function index(Request $request): Response
    {
        $formOptions = app(PatientService::class)->getPatientFormOptions();
        $patientList = app(PatientService::class)->getPatientList(
            $request->keyword,
            $request->selectId,
            $request->path(),
        );

        return Inertia::render('patient/index', compact(
            'formOptions',
            'patientList',
        ));
    }

    public function getPatientDetails(string $id): Response
    {
        $formOptions = app(PatientService::class)->getPatientFormOptions();
        $patientDetails = app(PatientService::class)->getPatientDetails($id);
        $vitalSigns = VitalSign::with('fields')->get();

        return Inertia::render('patient/details/index', compact(
            'formOptions',
            'patientDetails',
            'vitalSigns',
        ));
    }

    public function addOrUpdatePatient(Request $request): void
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
        );

        app(PatientService::class)->addOrUpdatePatient($patientDetails);
    }

    public function deletePatient(string $patientId): void
    {
        Patient::destroy($patientId);
    }

    public function getSmallPatientList(Request $request): array
    {
        return app(PatientService::class)->getSmallPatientList($request->keyword);
    }

    public function getAuditLog(string $id): array
    {
        return app(PatientService::class)->getAuditLog($id);
    }
}
