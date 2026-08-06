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
            ['name' => 'Head of Admin'],
            ['name' => 'Admin Aide'],

            // Finance
            ['name' => 'Head of Finance'],
            ['name' => 'Accountant'],
            ['name' => 'Finance Officer'],

            // Pharmacy
            ['name' => 'General Practitioner'],
            ['name' => 'Pharmacist'],
            ['name' => 'Pharmacy Assistant'],

            // Laboratory
            ['name' => 'Head of Laboratory'],
            ['name' => 'Medical Technologist Supervisor'],
            ['name' => 'Medical Technologist'],
            ['name' => 'Laboratory Aide'],

            // IT
            ['name' => 'Full Stack Software Engineer'],
            ['name' => 'Bot'],
        ]);
    }
}
