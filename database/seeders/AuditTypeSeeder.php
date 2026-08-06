<?php

namespace Database\Seeders;

use App\Models\AuditType;
use Illuminate\Database\Seeder;

class AuditTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        AuditType::fillAndInsert([
            ['name' => 'Add'],
            ['name' => 'Edit'],
            ['name' => 'Delete'],
            ['name' => 'View'],
        ]);
    }
}
