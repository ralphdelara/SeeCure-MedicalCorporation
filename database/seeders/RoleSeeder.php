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
            ['role' => 'Cashier'],
            ['role' => 'Front Desk'],
            ['role' => 'Laboratory'],
            ['role' => 'Medical Practitioner'],
            ['role' => 'System Administrator'],
        ]);
    }
}
