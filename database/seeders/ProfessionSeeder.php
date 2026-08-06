<?php

namespace Database\Seeders;

use App\Models\Profession;
use Illuminate\Database\Seeder;

class ProfessionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Profession::fillAndInsert([
            ['name' => 'Doctor', 'prefix' => 'Dr. ', 'suffix' => 'MD'],
            ['name' => 'Medical Technologist', 'prefix' => null, 'suffix' => 'RMT'],
            ['name' => 'Nurse', 'prefix' => null, 'suffix' => 'RN'],
            ['name' => 'Staff', 'prefix' => null, 'suffix' => null],
            ['name' => 'Full Stack Developer', 'prefix' => null, 'suffix' => null],
            ['name' => 'Other', 'prefix' => null, 'suffix' => null],
        ]);
    }
}
