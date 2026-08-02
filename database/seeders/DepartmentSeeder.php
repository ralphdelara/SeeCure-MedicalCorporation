<?php

namespace Database\Seeders;

use App\Models\Department;
use Illuminate\Database\Seeder;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Department::fillAndInsert([
            ['department' => 'Administrator'],
            ['department' => 'Consultation'],
            ['department' => 'Finance'],
            ['department' => 'Information Technology'],
            ['department' => 'Laboratory'],
            ['department' => 'Pharmacy'],
        ]);
    }
}
