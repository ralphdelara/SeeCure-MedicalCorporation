<?php

namespace Database\Seeders;

use App\Models\VitalSign;
use Illuminate\Database\Seeder;

class VitalSignSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        VitalSign::fillAndInsert([
            ['name' => 'Blood Pressure (BP)'],
            ['name' => 'Cardiac Rate (CR)'],
            ['name' => 'Respiratory Rate (RR)'],
            ['name' => 'Oxygen Saturation (O₂Sat)'],
            ['name' => 'Body Weight (BW)'],
            ['name' => 'Temperature (Temp)'],
        ]);
    }
}
