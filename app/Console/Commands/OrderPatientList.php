<?php

namespace App\Console\Commands;

use App\Services\PatientService;
use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;

#[Signature('patient:order-list')]
#[Description('This command orders the patient list')]
class OrderPatientList extends Command
{
    /**
     * Execute the console command.
     */
    public function handle()
    {
        app(PatientService::class)->updatePatientOrder();
    }
}
