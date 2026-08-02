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
            ['city' => 'Altavas', 'province_id' => 1],
            ['city' => 'Balete', 'province_id' => 1],
            ['city' => 'Banga', 'province_id' => 1],
            ['city' => 'Batan', 'province_id' => 1],
            ['city' => 'Buruanga', 'province_id' => 1],
            ['city' => 'Ibajay', 'province_id' => 1],
            ['city' => 'Kalibo', 'province_id' => 1],
            ['city' => 'Lezo', 'province_id' => 1],
            ['city' => 'Libacao', 'province_id' => 1],
            ['city' => 'Madalag', 'province_id' => 1],
            ['city' => 'Makato', 'province_id' => 1],
            ['city' => 'Malay', 'province_id' => 1],
            ['city' => 'Malinao', 'province_id' => 1],
            ['city' => 'Nabas', 'province_id' => 1],
            ['city' => 'New Washington', 'province_id' => 1],
            ['city' => 'Numancia', 'province_id' => 1],
            ['city' => 'Tangalan', 'province_id' => 1],
        ]);
    }
}
