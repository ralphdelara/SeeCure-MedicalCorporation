<?php

use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Route;

Route::inertia('/', 'welcome')->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::inertia('dashboard', 'dashboard')->name('dashboard');
    Route::inertia('front-desk', 'front-desk/index')->name('front-desk');
    Route::inertia('patient/list', 'patient/patient-list')->name('patient-list');
    Route::inertia('patient/details', 'patient/patient-details')->name('patient-details');
    Route::prefix('consultation')->group(function () {
        Route::inertia('list', 'consultation')->name('consultation-list');
        
    });
    Route::inertia('laboratory', 'laboratory')->name('laboratory');
    Route::inertia('radiology', 'radiology')->name('radiology');
    Route::inertia('pharmacy', 'pharmacy')->name('pharmacy');
    Route::inertia('cashier', 'cashier')->name('cashier');
    Route::inertia('users', 'users')->name('users');
    Route::inertia('system', 'system')->name('system');

    Route::inertia('announcements', 'announcements')->name('announcements');
    Route::inertia('notes', 'notes')->name('notes');
    Route::inertia('reminders', 'reminders')->name('reminders');
    Route::inertia('calendar', 'calendar')->name('calendar');

    Route::get('test', function () {
        dd(Crypt::encrypt('a'));
    });
});

require __DIR__.'/settings.php';
