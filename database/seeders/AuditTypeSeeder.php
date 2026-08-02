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
            ['audit_type' => 'Add'],
            ['audit_type' => 'Edit'],
            ['audit_type' => 'Delete'],
            ['audit_type' => 'View'],
        ]);
    }
}
