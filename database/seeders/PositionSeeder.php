<?php

namespace Database\Seeders;

use App\Models\Position;
use Illuminate\Database\Seeder;

class PositionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Position::fillAndInsert([
            // Admin
            ['position' => 'Head of Admin'],
            ['position' => 'Admin Aide'],

            // Finance
            ['position' => 'Head of Finance'],
            ['position' => 'Accountant'],
            ['position' => 'Finance Officer'],

            // Pharmacy
            ['position' => 'General Practitioner'],
            ['position' => 'Pharmacist'],
            ['position' => 'Pharmacy Assistant'],

            // Laboratory
            ['position' => 'Head of Laboratory'],
            ['position' => 'Medical Technologist Supervisor'],
            ['position' => 'Medical Technologist'],
            ['position' => 'Laboratory Aide'],

            // IT
            ['position' => 'Full Stack Software Engineer'],
            ['position' => 'Bot'],
        ]);
    }
}
