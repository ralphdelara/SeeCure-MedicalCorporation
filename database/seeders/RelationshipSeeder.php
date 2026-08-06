<?php

namespace Database\Seeders;

use App\Models\Relationship;
use Illuminate\Database\Seeder;

class RelationshipSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Relationship::fillAndInsert([
            ['name' => 'Parent'],
            ['name' => 'Spouse'],
            ['name' => 'Child'],
            ['name' => 'Sibling'],
            ['name' => 'Legal Guardian'],
            ['name' => 'Foster Parent'],
            ['name' => 'Grandparent'],
            ['name' => 'Grandchild'],
            ['name' => 'Aunt / Uncle'],
            ['name' => 'Cousin'],
            ['name' => 'Others'],
        ]);
    }
}
