<?php

namespace App\Http\Controllers;

use App\Events\CallOut;
use Illuminate\Http\Request;
use Inertia\Inertia;

class SystemController extends Controller
{
    public function index()
    {
        return Inertia::render('system/index');
    }

    public function callOut()
    {
        return Inertia::render('system/call-out');
    }

    public function callOutPatient(Request $request): void
    {
        broadcast(new CallOut(
            $request->patientName ?? '',
            $request->department ?? '',
        ));
    }
}
