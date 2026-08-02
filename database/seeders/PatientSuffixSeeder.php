<?php

namespace Database\Seeders;

use App\Models\PatientSuffix;
use Illuminate\Database\Seeder;

class PatientSuffixSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        PatientSuffix::fillAndInsert([
            ['suffix' => 'Sr.'],
            ['suffix' => 'Jr.'],
            ['suffix' => 'II'],
            ['suffix' => 'III'],
        ]);
    }
}
