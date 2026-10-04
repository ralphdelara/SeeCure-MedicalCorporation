<?php

namespace App\Http\Controllers;

use App\Models\DiscountType;
use App\Models\InventoryCategory;
use App\Models\Pharmacy;
use App\Models\PharmacyDetail;
use App\Services\PharmacyService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class PharmacyController extends Controller
{
    public function getPharmacyList(Request $request, ?string $status = null): Response
    {
        $pharmacyList = app(PharmacyService::class)->getPharmacyList(
            $request->keyword,
            $status,
            $request->path(),
        );

        return Inertia::render('pharmacy/index', compact(
            'pharmacyList',
        ));
    }

    public function getPharmacyDetails(Request $request, string $pharmacyId): Response
    {
        $pharmacyDetails = app(PharmacyService::class)->getPharmacyDetails($pharmacyId);
        $patientDetails = $pharmacyDetails['visit']['patient'];
        $discountType = DiscountType::all();
        $inventoryCategories = InventoryCategory::all();

        return Inertia::render('pharmacy/details/index', compact(
            'pharmacyDetails',
            'patientDetails',
            'discountType',
            'inventoryCategories',
        ));
    }

    public function updateDetails(Request $request): void
    {
        $details = $request->all();

        app(PharmacyService::class)->updateDetails($details);
    }

    public function deletePharmacy(string $id): void
    {
        Pharmacy::destroy($id);
    }

    public function completePharmacy(string $id): void
    {
        app(PharmacyService::class)->completePharmacy($id);
    }

    public function addOrUpdatePayment(Request $request): RedirectResponse
    {
        $paymentDetails = $request->only(
            'pharmacy_id',
            'patient_id',
            'visit_id',
            'payment_id',
            'payment_method_id',
            'reference_number',
            'total_amount',
            'amount_received',
            'amount_change',
        );

        // to refresh usePage props
        return back()->with([
            'paymentDetails' => app(PharmacyService::class)->addOrUpdatePayment($paymentDetails),
        ]);
    }

    public function addItem(Request $request): void
    {
        $request->validate([
            'pharmacy_id'  => 'required',
            'inventory_id' => 'required',
        ]);

        $pharmacyItemDetails = $request->only(
            'id',
            'pharmacy_id',
            'inventory_id',
            'name',
            'cost_price',
            'quantity',
            'total_price',
            'discount',
            'discount_type_id',
            'tax_percent',
            'tax_amount',
            'nett_price',
        );

        app(PharmacyService::class)->addItem($pharmacyItemDetails);
    }

    public function deletePharmacyDetail(string $id): void
    {
        $pharmacyDetail = PharmacyDetail::find($id);
        $pharmacyId = $pharmacyDetail->pharmacy_id;
        $pharmacyDetail->delete();

        app(PharmacyService::class)->recomputePharmacyTotals($pharmacyId);
    }

    public function getAuditLog(string $id): array
    {
        return app(PharmacyService::class)->getAuditLog($id);
    }
}
