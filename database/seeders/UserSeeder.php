<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\UserDepartment;
use App\Models\UserProfession;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::fillAndInsert([
            'first_name' => 'SYSTEM',
            'last_name' => 'USER',
            'username' => 'system_user',
            'password' => Hash::make('system_pass'),
            'gender_id' => 4, // Unknown

            'status' => true,

            'position_id' => 14, // Bot

            'created_by' => 1, // SYSTEM USER

        ]);

        UserDepartment::fillAndInsert([
            'user_id' => 1, // SYSTEM USER
            'department_id' => 1, // Administrator
        ]);

        UserProfession::fillAndInsert([
            'user_id' => 1, // SYSTEM USER
            'profession_id' => 6, // Other
        ]);
    }
}
