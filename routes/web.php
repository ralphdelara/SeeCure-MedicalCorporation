<?php

use App\Http\Controllers\AddressController;
use App\Http\Controllers\ConsultationController;
use App\Http\Controllers\FrontDeskController;
use App\Http\Controllers\Icd10CodeController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\PharmacyController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::permanentRedirect('/', '/login');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::inertia('dashboard', 'dashboard')->name('dashboard');
    Route::prefix('front-desk')->group(function () {
        Route::get('/', [FrontDeskController::class, 'index'])->name('front-desk');
        Route::post('/', [FrontDeskController::class, 'queuePatient'])->name('front-desk.queue-patient');
    });

    Route::get('/patients', [PatientController::class, 'index'])->name('patients');
    Route::prefix('patient')->group(function () {
        Route::match(['post', 'put'], '/', [PatientController::class, 'addOrUpdatePatient'])->name('patient.add-or-update');
        Route::delete('/{id}', [PatientController::class, 'deletePatient'])->name('patient.delete');
        Route::get('/{id}', [PatientController::class, 'getPatientDetails'])->name('patient.details');
    });

    Route::prefix('consultation')->group(function () {
        Route::get('/', [ConsultationController::class, 'index'])->name('consultation');
        Route::get('/details/{id}', [ConsultationController::class, 'getConsultationDetails'])->name('consultation.details');
    });
    Route::inertia('laboratory', 'laboratory')->name('laboratory');
    Route::inertia('radiology', 'radiology')->name('radiology');
    Route::prefix('pharmacy')->group(function () {
        Route::get('/', [PharmacyController::class, 'index'])->name('pharmacy');
        Route::match(['POST', 'PUT'], '/', [PharmacyController::class, 'addOrUpdateProduct'])
            ->name('pharmacy.add-or-update-product');
        Route::delete('/{id}', [PharmacyController::class, 'deleteProduct'])->name('pharmacy.delete');
    });
    Route::inertia('cashier', 'cashier')->name('cashier');

    Route::get('/users', [UserController::class, 'index'])->name('users');
    Route::prefix('user')->group(function () {
        Route::match(['post', 'put'], '/', [UserController::class, 'addOrUpdateUser'])->name('user.add-or-update');
        Route::delete('/{id}', [UserController::class, 'deleteUser'])->name('user.delete');
        Route::get('/{id}', [UserController::class, 'getUserDetails'])->name('user.details');
    });

    Route::inertia('system', 'system')->name('system');

    Route::inertia('announcements', 'announcements')->name('announcements');
    Route::inertia('notes', 'notes')->name('notes');
    Route::inertia('reminders', 'reminders')->name('reminders');
    Route::inertia('calendar', 'calendar')->name('calendar');

    Route::prefix('address')->group(function () {
        Route::get('/city/{cityId}/barangay', [AddressController::class, 'barangay'])->name('barangay-list');
    });

    Route::prefix('settings')->group(function () {
        Route::get('/icd10-codes', [Icd10CodeController::class, 'getIcd10Codes']);
    });
    Route::inertia('test1', 'test')->name('test');

    Route::get('test', function () {
        dd(formatName('test abcd efg-hijk'));
    });
});
