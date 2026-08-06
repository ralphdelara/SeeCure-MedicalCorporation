<?php

namespace Database\Seeders;

use App\Models\ConsultationType;
use Illuminate\Database\Seeder;

class ConsultationTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ConsultationType::fillAndInsert([
            ['name' => 'Consultation'],
            ['name' => 'Laboratory'],
        ]);
    }
}
