<?php

namespace App\Http\Controllers;

use App\Models\PrivacyPolicy;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response;

class PrivacyPolicyController extends Controller
{
    public function privacyPolicy(): Response
    {
        $privacyPolicy = PrivacyPolicy::get()->last();

        return Inertia::render('privacy-policy/index', compact('privacyPolicy'));
    }

    public function updatePrivacyPolicy(Request $request): void
    {
        abort_if(!Auth::user()->is_admin, 403);

        $privacyPolicyDetails = $request->only('id', 'policy', 'insertNew');
        $id = $privacyPolicyDetails['id'];
        unset($privacyPolicyDetails['id']);

        if ($privacyPolicyDetails['insertNew'] === 1) {
            PrivacyPolicy::create([
                'policy' => $privacyPolicyDetails['policy'],
                'created_by' => Auth::id(),
                'last_modified_by' => Auth::id(),
            ]);
        } else {
            PrivacyPolicy::find($id)->update([
                'policy' => $privacyPolicyDetails['policy'],
                'last_modified_by' => Auth::id(),
            ]);
        }
    }
}
