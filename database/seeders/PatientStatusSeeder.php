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
            ['name' => 'Waiting'],
            ['name' => 'In Consultation'],
            ['name' => 'In Laboratory'],
            ['name' => 'In Radiology'],
            ['name' => 'In Cashier'],
            ['name' => 'Admitted'],
            ['name' => 'Referred'],
            ['name' => 'For Discharge'],
            ['name' => 'Discharged'],
            ['name' => 'Inactive'],
        ]);
    }
}
