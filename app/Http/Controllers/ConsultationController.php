<?php

namespace App\Http\Controllers;

use App\Models\LaboratoryTestType;
use App\Models\SignsOrSymptom;
use App\Models\VitalSign;
use App\Services\ConsultationService;
use App\Services\PatientService;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class ConsultationController extends Controller
{
    public function index(Request $request): Response
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

    public function getConsultationDetails(string $id): Response
    {
        $consultationDetails = app(ConsultationService::class)->getConsultationDetails($id);
        $signsOrSymptoms = SignsOrSymptom::all();
        $laboratoryTestOptions = LaboratoryTestType::all();
        $vitalSigns = VitalSign::with('fields')->get();
        $patientDetails = app(PatientService::class)->getPatientDetails($consultationDetails['patient_id']);

        return Inertia::render('consultation/details/index', compact(
            'consultationDetails',
            'signsOrSymptoms',
            'laboratoryTestOptions',
            'vitalSigns',
            'patientDetails',
        ));
    }
}
