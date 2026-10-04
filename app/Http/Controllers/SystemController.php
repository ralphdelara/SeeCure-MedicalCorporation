<?php

namespace App\Http\Controllers;

use App\Events\CallOut;
use App\Models\CompanyProfile;
use Auth;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class SystemController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('system/index');
    }

    public function callOut(): Response
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

    public function companyProfile(): Response
    {
        $companyProfile = CompanyProfile::find(1);

        return Inertia::render('system/company-profile', compact('companyProfile'));
    }

    public function updateCompanyProfile(Request $request): void
    {
        $request->validate([
            'company_name' => 'required',
        ]);

        CompanyProfile::find(1)->update([
            'company_name'              => $request->company_name,
            'company_reg_no'            => $request->company_reg_no,
            'non_vat_tin'               => $request->non_vat_tin,
            'min'                       => $request->min,
            'sn'                        => $request->sn,
            'accreditation_no'          => $request->accreditation_no,
            'accreditation_date_issued' => $request->accreditation_date_issued,
            'ptu_no'                    => $request->ptu_no,
            'ptu_date_issued'           => $request->ptu_date_issued,
            'bir_no'                    => $request->bir_no,
            'tel_no'                    => $request->tel_no,
            'phone_no'                  => $request->phone_no,
            'email'                     => $request->email,
            'clinic_hours'              => $request->clinic_hours,
            'address'                   => $request->address,
            'landmark'                  => $request->landmark,
            'last_modified_by'          => Auth::id(),
        ]);
    }
}
