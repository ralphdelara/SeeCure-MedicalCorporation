<?php

namespace Database\Seeders;

use App\Models\ConsultationStatus;
use Illuminate\Database\Seeder;

class ConsultationStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ConsultationStatus::fillAndInsert([
            ['name' => 'Pending'],
            ['name' => 'Ongoing'],
            ['name' => 'Completed'],
            ['name' => 'Cancelled'],
        ]);
    }
}
