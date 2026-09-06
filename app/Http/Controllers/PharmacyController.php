<?php

namespace App\Http\Controllers;

use Inertia\Inertia;

class PharmacyController extends Controller
{
    public function index()
    {
        return Inertia::render('pharmacy/index', []);
    }
}
