<?php

namespace App\Http\Controllers;

use App\Events\CallOut;
use App\Models\Billing;
use App\Models\Cashier;
use App\Models\CompanyProfile;
use App\Models\Consultation;
use App\Models\Laboratory;
use App\Models\Pharmacy;
use App\Models\Radiology;
use App\Services\LaboratoryFieldService;
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
        $pendingCounts = [
            'Consultation' => Consultation::where('is_completed', false)->count(),
            'Laboratory'   => Laboratory::where('is_completed', false)->count(),
            'Radiology'    => Radiology::where('is_completed', false)->count(),
            'Billing'      => Billing::where('is_completed', false)->count(),
            'Pharmacy'     => Pharmacy::where('is_completed', false)->count(),
            'Cashier'      => Cashier::where('is_completed', false)->count(),
        ];

        return Inertia::render('system/call-out', compact('pendingCounts'));
    }

    public function callOutPatient(Request $request): void
    {
        broadcast(new CallOut(
            $request->patientName ?? '',
            $request->department ?? '',
            $request->upNext ?? '',
            $request->departmentCount ?? '',
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

    public function refreshTestFieldOrder(): void
    {
        app(LaboratoryFieldService::class)->orderTestFields();
    }

    public function refreshTestFieldNormalRanges(): void
    {
        app(LaboratoryFieldService::class)->refreshNormalRanges();
    }
}
