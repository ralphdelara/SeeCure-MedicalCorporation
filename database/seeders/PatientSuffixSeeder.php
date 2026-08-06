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
            ['name' => 'Sr.'],
            ['name' => 'Jr.'],
            ['name' => 'II'],
            ['name' => 'III'],
        ]);
    }
}
