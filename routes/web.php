<?php

use App\Events\CallOut;
use App\Http\Controllers\AddressController;
use App\Http\Controllers\BillingController;
use App\Http\Controllers\ConsultationController;
use App\Http\Controllers\FrontDeskController;
use App\Http\Controllers\Icd10CodeController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\LaboratoryController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\PharmacyController;
use App\Http\Controllers\PrintController;
use App\Http\Controllers\SystemController;
use App\Http\Controllers\UserController;
use App\Models\DiscountType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::permanentRedirect('/', '/login');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::inertia('dashboard', 'dashboard')->name('dashboard');
    Route::prefix('front-desk')->group(function () {
        Route::get('/', [FrontDeskController::class, 'index'])->name('front-desk');
        Route::post('/', [FrontDeskController::class, 'queue'])->name('front-desk.queue');
        Route::delete('/{id}', [FrontDeskController::class, 'deleteQueue'])->name('front-desk.delete');
    });

    Route::get('/patients', [PatientController::class, 'index'])->name('patients');
    Route::prefix('patient')->group(function () {
        Route::get('/search', [PatientController::class, 'getSmallPatientList'])->name('patient.search');
        Route::match(['post', 'put'], '/', [PatientController::class, 'addOrUpdatePatient'])->name('patient.add-or-update');
        Route::delete('/{id}', [PatientController::class, 'deletePatient'])->name('patient.delete');
        Route::get('/{id}', [PatientController::class, 'getPatientDetails'])->name('patient.details');
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
            Route::post('/call-out', [ConsultationController::class, 'callOutPatient'])->name('consultation.call-out');
            Route::patch('/complete/{consultationId}', [ConsultationController::class, 'completeConsultation'])->name('consultation.completed');
        });
    });

    Route::prefix('laboratory')->group(function() {
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

    Route::prefix('billing')->group(function() {
        Route::get('/{status?}', [BillingController::class, 'getBillingList'])->name('billing');
        Route::get('/package/{id}/tests', [BillingController::class, 'getTests'])->name('billing.package.tests');
        Route::post('/', [BillingController::class, 'addOrUpdateBilling'])->name('billing.add-or-update');
        Route::prefix('/details')->group(function () {
            Route::get('/{id}', [BillingController::class, 'getBillingDetails'])->name('billing.details');
            Route::get('/{id}/audit-log', [BillingController::class, 'getAuditLog'])->name('billing.details.audit-log');
            Route::patch('/', [BillingController::class, 'updateDetails'])->name('billing.details.update');
            Route::patch('/complete/{id}', [BillingController::class, 'completeBilling'])->name('billing.completed');
        });
        Route::delete('/{id}', [BillingController::class, 'deleteBilling'])->name('billing.delete');
    });

    Route::inertia('radiology', 'radiology')->name('radiology');
    Route::prefix('inventory')->group(function () {
        Route::get('/', [InventoryController::class, 'index'])->name('inventory');
        Route::get('/search', [InventoryController::class, 'getSmallInventoryList'])->name('inventory.search');
        Route::match(['POST', 'PUT'], '/', [InventoryController::class, 'addOrUpdateInventory'])
            ->name('inventory.add-or-update-inventory');
        Route::delete('/{id}', [InventoryController::class, 'deleteInventory'])->name('inventory.delete');
    });
    Route::inertia('cashier', 'cashier')->name('cashier');

    Route::get('/users', [UserController::class, 'index'])->name('users');
    Route::prefix('user')->group(function () {
        Route::match(['post', 'put'], '/', [UserController::class, 'addOrUpdateUser'])->name('user.add-or-update');
        Route::delete('/{id}', [UserController::class, 'deleteUser'])->name('user.delete');
        Route::get('/{id}', [UserController::class, 'getUserDetails'])->name('user.details');
    });

    Route::prefix('system')->group(function () {
        Route::get('/', [SystemController::class, 'index'])->name('system');
        Route::get('/call-out', [SystemController::class, 'callOut'])->name('system.call-out');
    });

    Route::inertia('announcements', 'announcements')->name('announcements');
    Route::inertia('notes', 'notes')->name('notes');
    Route::inertia('reminders', 'reminders')->name('reminders');
    Route::inertia('calendar', 'calendar')->name('calendar');

    Route::prefix('address')->group(function () {
        Route::get('/province/{provinceId}/city', [AddressController::class, 'getCityList'])->name('address.cities');
        Route::get('/city/{cityId}/barangay', [AddressController::class, 'getBarangayList'])->name('address.barangays');
    });

    Route::prefix('pharmacy')->group(function () {
        Route::get('/', [PharmacyController::class, 'index'])->name('pharmacy');
    });

    Route::prefix('settings')->group(function () {
        Route::get('/icd10-codes', [Icd10CodeController::class, 'getIcd10Codes']);
    });

    Route::prefix('print')->group(function () {
        Route::get('/prescription/{consultationId}', [PrintController::class, 'printPrescription'])->name('print.prescription');
    });

    Route::get('/testt', function () {
        DiscountType::find(1)->update([
            'name' => Crypt::encryptString('Senior'),
        ]);
        DiscountType::find(2)->update([
            'name' => Crypt::encryptString('PWD'),
        ]);
        DiscountType::find(3)->update([
            'name' => Crypt::encryptString('Promo'),
        ]);
    });
    Route::inertia('/test-socket', 'test-reverb')->name('test');
    Route::get('/test-socket-send', function (Request $request) {
        broadcast(new CallOut(
            $request->patientName ?? '',
            $request->department ?? '',
        ));
    })->name('test-notify');
    Route::inertia('/test-speech', 'calendar')->name('test-speech');
});
