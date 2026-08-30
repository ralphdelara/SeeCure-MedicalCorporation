<?php

namespace App\Http\Controllers;

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
}
