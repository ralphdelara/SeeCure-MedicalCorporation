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
            ['specialty' => 'Anesthesiology', 'suffix' => null],
            ['specialty' => 'Cardiology', 'suffix' => null],
            ['specialty' => 'Ear, Nose and Throat', 'suffix' => ', ENT'],
            ['specialty' => 'Endocrinology', 'suffix' => null],
            ['specialty' => 'Family Medicine', 'suffix' => ', FM'],
            ['specialty' => 'Gastroenterology', 'suffix' => null],
            ['specialty' => 'General Practice', 'suffix' => null],
            ['specialty' => 'General Surgery', 'suffix' => null],
            ['specialty' => 'Gynecology', 'suffix' => ', GYNE'],
            ['specialty' => 'Hematology', 'suffix' => null],
            ['specialty' => 'Internal Medicine', 'suffix' => ', IM'],
            ['specialty' => 'Nephrology', 'suffix' => null],
            ['specialty' => 'Obstetrics', 'suffix' => ', OB'],
            ['specialty' => 'Opthalmology', 'suffix' => null],
            ['specialty' => 'Othopedic Surgery', 'suffix' => null],
            ['specialty' => 'Pathology', 'suffix' => null],
            ['specialty' => 'Pediatrics', 'suffix' => null],
            ['specialty' => 'Plastic Surgery', 'suffix' => null],
            ['specialty' => 'Psychiatry', 'suffix' => null],
            ['specialty' => 'Pulmonology', 'suffix' => null],
            ['specialty' => 'Radiology', 'suffix' => null],
            ['specialty' => 'Rheumatology', 'suffix' => null],
            ['specialty' => 'Urology', 'suffix' => null],
        ]);
    }
}
