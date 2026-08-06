<?php

namespace Database\Seeders;

use App\Models\SignsOrSymptom;
use Illuminate\Database\Seeder;

class SignsOrSymptomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        SignsOrSymptom::fillAndInsert([
            ['name' => 'Cough'],
            ['name' => 'Colds'],
            ['name' => 'Fever'],
            ['name' => 'Headache'],
            ['name' => 'Stomach Pain'],
            ['name' => 'Sorethroat'],
            ['name' => 'Difficulty of Breathing'],
            ['name' => 'Diarrhea'],
            ['name' => 'Loss of Smell'],
            ['name' => 'Loss of Taste'],
        ]);
    }
}
