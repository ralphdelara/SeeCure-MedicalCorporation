<?php

namespace Database\Seeders;

use App\Models\Specialty;
use Illuminate\Database\Seeder;

class SpecialtySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Specialty::fillAndInsert([
            ['name' => 'Anesthesiology', 'suffix' => null],
            ['name' => 'Cardiology', 'suffix' => null],
            ['name' => 'Ear, Nose and Throat', 'suffix' => ', ENT'],
            ['name' => 'Endocrinology', 'suffix' => null],
            ['name' => 'Family Medicine', 'suffix' => ', FM'],
            ['name' => 'Gastroenterology', 'suffix' => null],
            ['name' => 'General Practice', 'suffix' => null],
            ['name' => 'General Surgery', 'suffix' => null],
            ['name' => 'Gynecology', 'suffix' => ', GYNE'],
            ['name' => 'Hematology', 'suffix' => null],
            ['name' => 'Internal Medicine', 'suffix' => ', IM'],
            ['name' => 'Nephrology', 'suffix' => null],
            ['name' => 'Obstetrics', 'suffix' => ', OB'],
            ['name' => 'Opthalmology', 'suffix' => null],
            ['name' => 'Othopedic Surgery', 'suffix' => null],
            ['name' => 'Pathology', 'suffix' => null],
            ['name' => 'Pediatrics', 'suffix' => null],
            ['name' => 'Plastic Surgery', 'suffix' => null],
            ['name' => 'Psychiatry', 'suffix' => null],
            ['name' => 'Pulmonology', 'suffix' => null],
            ['name' => 'Radiology', 'suffix' => null],
            ['name' => 'Rheumatology', 'suffix' => null],
            ['name' => 'Urology', 'suffix' => null],
        ]);
    }
}
