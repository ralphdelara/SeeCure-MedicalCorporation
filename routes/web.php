<?php

use App\Http\Controllers\AddressController;
use App\Http\Controllers\ConsultationController;
use App\Http\Controllers\FrontDeskController;
use App\Http\Controllers\PharmacyController;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Route;

Route::permanentRedirect('/', '/login');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::inertia('dashboard', 'dashboard')->name('dashboard');
    Route::prefix('front-desk')->group(function () {
        Route::get('/', [FrontDeskController::class, 'index'])->name('front-desk');
        Route::post('/', [FrontDeskController::class, 'queuePatient'])->name('front-desk.queue-patient');
    });
    Route::inertia('patient/list', 'patient/list')->name('patient-list');
    Route::inertia('patient/details', 'patient/details')->name('patient-details');
    Route::prefix('consultation')->group(function () {
        Route::get('/list', [ConsultationController::class, 'index'])->name('consultation');

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
    Route::inertia('users', 'users')->name('users');
    Route::inertia('system', 'system')->name('system');

    Route::inertia('announcements', 'announcements')->name('announcements');
    Route::inertia('notes', 'notes')->name('notes');
    Route::inertia('reminders', 'reminders')->name('reminders');
    Route::inertia('calendar', 'calendar')->name('calendar');

    Route::prefix('address')->group(function () {
        Route::get('/city/{cityId}/barangay', [AddressController::class, 'barangay'])->name('barangay-list');
    });

    Route::get('test', function () {
        dd(Crypt::encrypt('Item 1'));
    });
});

require __DIR__.'/settings.php';
