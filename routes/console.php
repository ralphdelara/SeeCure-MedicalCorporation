<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Schedule::command('patient:order-list')->dailyAt('12:20');

// Backup database to google drive
Schedule::command('backup:run --only-db')->dailyAt('12:30');
