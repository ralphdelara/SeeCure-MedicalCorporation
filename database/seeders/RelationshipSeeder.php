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
            ['relationship' => 'Parent'],
            ['relationship' => 'Spouse'],
            ['relationship' => 'Child'],
            ['relationship' => 'Sibling'],
            ['relationship' => 'Legal Guardian'],
            ['relationship' => 'Foster Parent'],
            ['relationship' => 'Grandparent'],
            ['relationship' => 'Grandchild'],
            ['relationship' => 'Aunt / Uncle'],
            ['relationship' => 'Cousin'],
            ['relationship' => 'Others'],
        ]);
    }
}
