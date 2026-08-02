<?php

namespace Database\Seeders;

use App\Models\CivilStatus;
use Illuminate\Database\Seeder;

class CivilStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        CivilStatus::fillAndInsert([
            ['civil_status' => 'Single'],
            ['civil_status' => 'Married'],
            ['civil_status' => 'Widowed'],
            ['civil_status' => 'Divorced'],
            ['civil_status' => 'Separated'],
            ['civil_status' => 'Anulled'],
            ['civil_status' => 'Cohabiting/Common-law'],
            ['civil_status' => 'Registered Partnership'],
            ['civil_status' => 'Newborn'],
            ['civil_status' => 'Child'],
        ]);
    }
}
