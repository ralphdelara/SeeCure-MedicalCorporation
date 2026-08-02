<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        $this->call([
            AuditTypeSeeder::class,
            ConsultationStatusSeeder::class,
            DepartmentSeeder::class,
            GenderSeeder::class,
            PatientStatusSeeder::class,
            PatientSuffixSeeder::class,
            PositionSeeder::class,
            ProfessionSeeder::class,
            RelationshipSeeder::class,
            RoleSeeder::class,
            SpecialtySeeder::class,
            CivilStatusSeeder::class,
            NationalitySeeder::class,

            ProvinceSeeder::class,
            CitySeeder::class,
            BarangaySeeder::class,

            UserSeeder::class,
        ]);
    }
}
