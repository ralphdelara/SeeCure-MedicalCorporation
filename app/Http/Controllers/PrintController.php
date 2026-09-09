<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class PrintController extends Controller
{
    public function printPrescription(string $consultationId): Response
    {
        return Inertia::render('print-templates/default');
    }
}
