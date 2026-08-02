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
            ['profession' => 'Doctor', 'prefix' => 'Dr. ', 'suffix' => ', MD'],
            ['profession' => 'Medical Technology', 'prefix' => null, 'suffix' => ', RMT'],
            ['profession' => 'Nurse', 'prefix' => null, 'suffix' => ', RN'],
            ['profession' => 'Staff', 'prefix' => null, 'suffix' => null],
            ['profession' => 'Full Stack Developer', 'prefix' => null, 'suffix' => null],
            ['profession' => 'Other', 'prefix' => null, 'suffix' => null],
        ]);
    }
}
