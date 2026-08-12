<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Inertia\Response;

class PatientController extends Controller
{
    public function index(): Response
    {
        $patientList = [];

        return Inertia::render('patient/index', compact(
            'patientList',
        ));
    }

    public function getPatientDetails(): Response
    {
        $patientDetails = [];

        return Inertia::render('patient/details', compact(
            'patientDetails',
        ));
    }
}