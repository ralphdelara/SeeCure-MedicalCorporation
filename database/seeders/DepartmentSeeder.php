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
            ['name' => 'Administrator'],
            ['name' => 'Consultation'],
            ['name' => 'Finance'],
            ['name' => 'Information Technology'],
            ['name' => 'Laboratory'],
            ['name' => 'Pharmacy'],
        ]);
    }
}
