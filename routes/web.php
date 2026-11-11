<?php

use App\Http\Controllers\AddressController;
use App\Http\Controllers\BillingController;
use App\Http\Controllers\BillingSuppliesController;
use App\Http\Controllers\CashierController;
use App\Http\Controllers\ConsultationController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\FrontDeskController;
use App\Http\Controllers\Icd10CodeController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\LaboratoryController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\PharmacyController;
use App\Http\Controllers\PrintController;
use App\Http\Controllers\SystemController;
use App\Http\Controllers\UserController;
use App\Services\LaboratoryFieldService;
use App\Services\LaboratoryService;
use Illuminate\Support\Facades\Route;

Route::permanentRedirect('/', '/login');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::prefix('dashboard')->group(function () {
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
        Route::get('/reports', [DashboardController::class, 'getReports'])->name('reports');
        Route::get('/reports/data', [DashboardController::class, 'getReportData'])->name('reports.data');
    });

    Route::prefix('front-desk')->group(function () {
        Route::get('/', [FrontDeskController::class, 'index'])->name('front-desk');
        Route::get('/queue-list', [FrontDeskController::class, 'getQueueList'])->name('front-desk.queue-list');
        Route::get('/visits', [FrontDeskController::class, 'index'])->name('visits');
        Route::post('/', [FrontDeskController::class, 'queue'])->name('front-desk.queue');
        Route::delete('/{id}', [FrontDeskController::class, 'deleteQueue'])->name('front-desk.delete');
    });

    Route::get('/patients', [PatientController::class, 'index'])->name('patients');
    Route::prefix('patient')->group(function () {
        Route::get('/search', [PatientController::class, 'getSmallPatientList'])->name('patient.search');
        Route::match(['post', 'put'], '/', [PatientController::class, 'addOrUpdatePatient'])->name('patient.add-or-update');
        Route::delete('/{id}', [PatientController::class, 'deletePatient'])->name('patient.delete');
        Route::get('/{id}', [PatientController::class, 'getPatientDetails'])->name('patient.details');
        Route::get('/{id}/audit-log', [PatientController::class, 'getAuditLog'])->name('patient.details.audit-log');
    });

    Route::prefix('/admissions')->group(function () {
        Route::get('/', [DashboardController::class, 'index'])->name('admissions');
        Route::get('/admitted', [DashboardController::class, 'index'])->name('admitted');
        Route::get('/discharged', [DashboardController::class, 'index'])->name('discharged');
        Route::get('/transfer', [DashboardController::class, 'index'])->name('transfer');
        Route::get('/wards', [DashboardController::class, 'index'])->name('wards');
    });

    Route::prefix('/consultations')->group(function () {
        Route::get('/{status?}', [ConsultationController::class, 'getConsultationList'])->name('consultations');
    });
    Route::prefix('consultation')->group(function () {
        Route::prefix('/details')->group(function () {
            Route::get('/{consultationId}', [ConsultationController::class, 'getConsultationDetails'])->name('consultation.details');
            Route::get('/{consultationId}/audit-log', [ConsultationController::class, 'getAuditLog'])->name('consultation.audit-log');
            Route::patch('/', [ConsultationController::class, 'updateDetails'])->name('consultation.details.update');
            Route::patch('/soap', [ConsultationController::class, 'updateSoap'])->name('consultation.details.update.soap');
            Route::patch('/diagnosis', [ConsultationController::class, 'updateDiagnosis'])->name('consultation.details.update.diagnosis');
            Route::post('/prescription', [ConsultationController::class, 'addOrUpdatePrescription'])->name('consultation.details.add-or-update.prescription');
            Route::delete('/prescription/{prescriptionId}', [ConsultationController::class, 'deletePrescription'])->name('consultation.details.delete.prescription');
            Route::delete('/vital-signs/{patientVitalSignsId}', [ConsultationController::class, 'deleteVitalSigns'])->name('consultation.details.delete.vital-signs');
            Route::post('/vital-signs', [ConsultationController::class, 'addOrUpdateVitalSigns'])->name('consultation.details.add-or-update.vital-signs');
            Route::patch('/complete/{consultationId}', [ConsultationController::class, 'completeConsultation'])->name('consultation.completed');
            Route::post('/laboratory/add', [ConsultationController::class, 'addLaboratory'])->name('add.laboratory');
        });
    });

    Route::prefix('laboratory')->group(function () {
        Route::get('/{status?}', [LaboratoryController::class, 'getLaboratoryList'])->name('laboratory');
        Route::get('/package/{id}/tests', [LaboratoryController::class, 'getTests'])->name('laboratory.package.tests');
        Route::post('/', [LaboratoryController::class, 'addOrUpdateLaboratory'])->name('laboratory.add-or-update');
        Route::prefix('/details')->group(function () {
            Route::get('/{id}', [LaboratoryController::class, 'getLaboratoryDetails'])->name('laboratory.details');
            Route::get('/{id}/audit-log', [LaboratoryController::class, 'getAuditLog'])->name('laboratory.details.audit-log');
            Route::patch('/', [LaboratoryController::class, 'updateDetails'])->name('laboratory.details.update');
            Route::patch('/complete/{id}', [LaboratoryController::class, 'completeLaboratory'])->name('laboratory.completed');
        });
        Route::delete('/{id}', [LaboratoryController::class, 'deleteLaboratory'])->name('laboratory.delete');
    });

    Route::prefix('billing')->group(function () {
        Route::get('/supplies', [BillingController::class, 'getBillingSuppliesList'])->name('billing-supplies');
        Route::get('/{status?}', [BillingController::class, 'getBillingList'])->name('billing');
        Route::get('/package/{id}/tests', [BillingController::class, 'getTests'])->name('billing.package.tests');
        Route::post('/', [BillingController::class, 'addOrUpdateBilling'])->name('billing.add-or-update');
        Route::prefix('/details')->group(function () {
            Route::get('/{id}', [BillingController::class, 'getBillingDetails'])->name('billing.details');
            Route::get('/{id}/audit-log', [BillingController::class, 'getAuditLog'])->name('billing.details.audit-log');
            Route::patch('/', [BillingController::class, 'updateDetails'])->name('billing.details.update');
            Route::patch('/complete/{id}', [BillingController::class, 'completeBilling'])->name('billing.completed');
            Route::delete('{id}', [BillingController::class, 'deleteBillingDetail'])->name('billing.details.delete');
        });
        Route::post('/billing-supplies', [BillingSuppliesController::class, 'addOrUpdateBillingSupplies'])->name('billing-supplies.add-or-update');
        Route::delete('/billing-supplies/{id}', [BillingSuppliesController::class, 'deleteBillingSupply'])->name('billing-supplies.delete');
        Route::post('/billing-supplies/item', [BillingSuppliesController::class, 'addBillingSuppliesItem'])->name('billing-supplies.item');
        Route::delete('/{id}', [BillingController::class, 'deleteBilling'])->name('billing.delete');
    });

    Route::prefix('cashier')->group(function () {
        Route::get('/{status?}', [CashierController::class, 'getCashierList'])->name('cashier');
        Route::post('/', [CashierController::class, 'addOrUpdateCashier'])->name('cashier.add-or-update');
        Route::prefix('/details')->group(function () {
            Route::get('/{id}', [CashierController::class, 'getCashierDetails'])->name('cashier.details');
            Route::get('/{id}/audit-log', [CashierController::class, 'getAuditLog'])->name('cashier.details.audit-log');
            Route::patch('/complete/{id}', [CashierController::class, 'completeCashier'])->name('cashier.completed');
            Route::post('/payment', [CashierController::class, 'addOrUpdatePayment'])->name('cashier.details.add-or-update-payment');
            Route::patch('/send-back-to-billing/{billingId}', [CashierController::class, 'sendBackToBilling'])->name('cashier.details.send-back-to-billing');
            Route::patch('/send-back-to-pharmacy/{pharmacyId}', [CashierController::class, 'sendBackToPharmacy'])->name('cashier.details.send-back-to-pharmacy');
        });
    });

    Route::prefix('pharmacy')->group(function () {
        Route::get('/{status?}', [PharmacyController::class, 'getPharmacyList'])->name('pharmacy');
        Route::post('/', [PharmacyController::class, 'addOrUpdatePharmacy'])->name('pharmacy.add-or-update');
        Route::prefix('/details')->group(function () {
            Route::get('/{id}', [PharmacyController::class, 'getPharmacyDetails'])->name('pharmacy.details');
            Route::get('/{id}/audit-log', [PharmacyController::class, 'getAuditLog'])->name('pharmacy.details.audit-log');
            Route::patch('/', [PharmacyController::class, 'updateDetails'])->name('pharmacy.details.update');
            Route::patch('/complete/{id}', [PharmacyController::class, 'completePharmacy'])->name('pharmacy.completed');
            Route::post('/pharmacy/item', [PharmacyController::class, 'addItem'])->name('pharmacy.item');
            Route::delete('{id}', [PharmacyController::class, 'deletePharmacyDetail'])->name('pharmacy.details.delete');
        });
        Route::delete('/{id}', [PharmacyController::class, 'deletePharmacy'])->name('pharmacy.delete');
    });

    Route::inertia('radiology/{radiologyId?}', 'radiology')->name('radiology');
    Route::prefix('inventory')->group(function () {
        Route::get('/search', [InventoryController::class, 'getSmallInventoryList'])->name('inventory.search');
        Route::get('/{listType?}', [InventoryController::class, 'index'])->name('inventory');
        Route::prefix('details')->group(function () {
            Route::get('/{inventoryId}', [InventoryController::class, 'getInventoryDetails'])->name('inventory.details');
            Route::post('/{inventoryId}/stock-movement', [InventoryController::class, 'addOrUpdateStockMovement'])->name('inventory.stock-movement.add-or-update');
            Route::delete('/{inventoryId}/stock-movement/{stockMovementId}', [InventoryController::class, 'deleteStockMovement'])->name('inventory.details.delete.stock-movement');
        });
        Route::get('/{id}/audit-log', [InventoryController::class, 'getAuditLog'])->name('inventory.details.audit-log');
        Route::match(['POST', 'PUT'], '/', [InventoryController::class, 'addOrUpdateInventory'])
            ->name('inventory.add-or-update-inventory');
        Route::delete('/{id}', [InventoryController::class, 'deleteInventory'])->name('inventory.delete');
        Route::patch('/{id}/hide', [InventoryController::class, 'hideItem'])->name('inventory.set-item-to-hide');
        Route::patch('/{id}/show', [InventoryController::class, 'showItem'])->name('inventory.set-item-to-show');
    });

    Route::get('/users', [UserController::class, 'index'])->name('users');
    Route::prefix('user')->group(function () {
        Route::get('/profile', [UserController::class, 'index'])->name('user.profile');
        Route::get('/departments', [UserController::class, 'index'])->name('user.departments');
        Route::match(['post', 'put'], '/', [UserController::class, 'addOrUpdateUser'])->name('user.add-or-update');
        Route::delete('/{id}', [UserController::class, 'deleteUser'])->name('user.delete');
        Route::get('/{id}', [UserController::class, 'getUserDetails'])->name('user.details');
        Route::get('/{id}/audit-log', [UserController::class, 'getAuditLog'])->name('user.details.audit-log');

    });

    Route::prefix('system')->group(function () {
        Route::get('/', [SystemController::class, 'index'])->name('system');
        Route::get('/call-out', [SystemController::class, 'callOut'])->name('system.call-out');
        Route::get('/company-profile', [SystemController::class, 'companyProfile'])->name('system.company-profile');
        Route::put('/company-profile', [SystemController::class, 'updateCompanyProfile'])->name('system.company-profile.update');

        Route::post('/call-out', [SystemController::class, 'callOutPatient'])->name('system.call-out-patient');
    });

    Route::inertia('guide', 'guide')->name('guide');
    Route::inertia('notes', 'notes')->name('notes');
    Route::inertia('reminders', 'reminders')->name('reminders');
    Route::inertia('calendar', 'calendar')->name('calendar');

    Route::prefix('address')->group(function () {
        Route::get('/province/{provinceId}/city', [AddressController::class, 'getCityList'])->name('address.cities');
        Route::get('/city/{cityId}/barangay', [AddressController::class, 'getBarangayList'])->name('address.barangays');
    });

    Route::prefix('settings')->group(function () {
        Route::get('/icd10-codes', [Icd10CodeController::class, 'getIcd10Codes']);
    });

    Route::prefix('print')->group(function () {
        Route::get('/prescription/{consultationId}', [PrintController::class, 'printPrescription'])->name('print.prescription');
        Route::get('/billing/{billingId}', [PrintController::class, 'printBilling'])->name('print.billing');
        Route::get('/receipt/{receiptNo}', [PrintController::class, 'printReceipt'])->name('print.receipt');
        Route::get('/laboratory/{laboratoryId}', [PrintController::class, 'printLaboratory'])->name('print.laboratory');
        Route::get('/pharmacy/pick-list/{pharmacyId}', [PrintController::class, 'printPharmacyPickList'])->name('print.pharmacy-pick-list');
    });

    Route::prefix('documents')->group(function () {
        Route::post('/addOrUpdate', [DocumentController::class, 'addOrUpdateDocument'])->name('documents.add-or-update');
        Route::get('/download/{departmentId}/{fileName}/{department}', [DocumentController::class, 'downloadDocument'])->name('documents.download');
        Route::delete('/delete/{documentId}/{departmentId}/{department}', [DocumentController::class, 'deleteDocument'])->name('documents.delete');
    });

    Route::get('order', function () {
        app(LaboratoryFieldService::class)->orderTestFields();
    });
});

Route::get('/ping', function () {
    return response()->noContent();
});
