<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Role::fillAndInsert([
            ['name' => 'Cashier'],
            ['name' => 'Front Desk'],
            ['name' => 'Laboratory'],
            ['name' => 'Medical Practitioner'],
            ['name' => 'System Administrator'],
        ]);
    }
}
