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
        User::create([
            'first_name' => 'SYSTEM',
            'last_name'  => 'USER',
            'username'   => 'system_user',
            'password'   => Hash::make('system_pass'),
            'gender_id'  => 4, // Unknown

            'status' => true,

            'position_id' => 14, // Bot

            'created_by' => 1, // SYSTEM USER

        ]);

        UserDepartment::create([
            'user_id'       => 1, // SYSTEM USER
            'department_id' => 1, // Administrator
        ]);

        UserProfession::create([
            'user_id'       => 1, // SYSTEM USER
            'profession_id' => 6, // Other
        ]);

        User::create([
            'first_name' => 'Lyka Loraine',
            'last_name'  => 'Zulueta',
            'username'   => 'lykaz',
            'password'   => Hash::make('chintot'),
            'gender_id'  => 1, // Female

            'status' => true,

            'position_id' => 6, // GP

            'created_by' => 1, // SYSTEM USER

        ]);

        UserDepartment::create([
            'user_id'       => 2,
            'department_id' => 2, // Consultation
        ]);

        UserProfession::create([
            'user_id'       => 2,
            'profession_id' => 1, // Doctor
        ]);
        UserProfession::create([
            'user_id'       => 2,
            'profession_id' => 2, // Med tech
        ]);
    }
}
