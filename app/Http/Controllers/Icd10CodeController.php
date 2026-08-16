<?php

namespace App\Http\Controllers;

use App\Models\Icd10Code;
use Illuminate\Http\Request;

class Icd10CodeController extends Controller
{
    public function getIcd10Codes(Request $request): array
    {
        return Icd10Code::whereLike('code', '%' . $request->keyword . '%')
            ->orWhereLike('description', '%' . $request->keyword . '%')
            ->orderBy('code')
            ->limit(20)->get()->toArray();
    }
}
