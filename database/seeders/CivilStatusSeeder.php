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
            ['name' => 'Single'],
            ['name' => 'Married'],
            ['name' => 'Widowed'],
            ['name' => 'Divorced'],
            ['name' => 'Separated'],
            ['name' => 'Anulled'],
            ['name' => 'Cohabiting/Common-law'],
            ['name' => 'Registered Partnership'],
            ['name' => 'Newborn'],
            ['name' => 'Child'],
        ]);
    }
}
