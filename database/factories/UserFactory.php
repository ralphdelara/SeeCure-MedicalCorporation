<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends Factory<User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'first_name'     => fake()->name(),
            'last_name'      => fake()->name(),
            'email'          => fake()->unique()->safeEmail(),
            'username'       => fake()->name(),
            'password'       => static::$password ??= Hash::make('password'),
            'remember_token' => Str::random(10),
            'status'         => true,
            'position_id'    => 1,
            'created_by'     => 1,
        ];
    }
}
