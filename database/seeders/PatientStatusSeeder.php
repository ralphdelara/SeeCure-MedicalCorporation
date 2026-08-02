<?php

namespace Database\Seeders;

use App\Models\PatientStatus;
use Illuminate\Database\Seeder;

class PatientStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        PatientStatus::fillAndInsert([
            ['status' => 'Waiting'],
            ['status' => 'In Consultation'],
            ['status' => 'In Laboratory'],
            ['status' => 'In Radiology'],
            ['status' => 'In Cashier'],
            ['status' => 'Admitted'],
            ['status' => 'Referred'],
            ['status' => 'For Discharge'],
            ['status' => 'Discharged'],
            ['status' => 'Inactive'],
        ]);
    }
}
