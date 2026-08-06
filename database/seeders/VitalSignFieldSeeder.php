<?php

namespace Database\Seeders;

use App\Models\VitalSignField;
use Illuminate\Database\Seeder;

class VitalSignFieldSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        VitalSignField::fillAndInsert([
            ['name' => 'Systolic', 'vital_sign_id' => 1, 'unit' => 'mmHg'],
            ['name' => 'Diastolic', 'vital_sign_id' => 1, 'unit' => 'mmHg'],
            ['name' => 'Rate', 'vital_sign_id' => 2, 'unit' => 'bpm'],
            ['name' => 'Rate', 'vital_sign_id' => 3, 'unit' => 'bpm'],
            ['name' => 'Percentage', 'vital_sign_id' => 4, 'unit' => '%'],
            ['name' => 'Weight', 'vital_sign_id' => 5, 'unit' => 'kg'],
            ['name' => 'Degrees', 'vital_sign_id' => 6, 'unit' => '°C'],
        ]);
    }
}
