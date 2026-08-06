<?php

namespace Database\Seeders;

use App\Models\City;
use Illuminate\Database\Seeder;

class CitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        City::fillAndInsert([
            ['name' => 'Altavas', 'province_id' => 1],
            ['name' => 'Balete', 'province_id' => 1],
            ['name' => 'Banga', 'province_id' => 1],
            ['name' => 'Batan', 'province_id' => 1],
            ['name' => 'Buruanga', 'province_id' => 1],
            ['name' => 'Ibajay', 'province_id' => 1],
            ['name' => 'Kalibo', 'province_id' => 1],
            ['name' => 'Lezo', 'province_id' => 1],
            ['name' => 'Libacao', 'province_id' => 1],
            ['name' => 'Madalag', 'province_id' => 1],
            ['name' => 'Makato', 'province_id' => 1],
            ['name' => 'Malay', 'province_id' => 1],
            ['name' => 'Malinao', 'province_id' => 1],
            ['name' => 'Nabas', 'province_id' => 1],
            ['name' => 'New Washington', 'province_id' => 1],
            ['name' => 'Numancia', 'province_id' => 1],
            ['name' => 'Tangalan', 'province_id' => 1],
        ]);
    }
}
