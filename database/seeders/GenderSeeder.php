<?php

namespace Database\Seeders;

use App\Models\Gender;
use Illuminate\Database\Seeder;

class GenderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Gender::fillAndInsert([
            ['name' => 'Female'],
            ['name' => 'Male'],
            ['name' => 'Others'],
            ['name' => 'Unknown'],
        ]);
    }
}
