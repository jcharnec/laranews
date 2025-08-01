<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    protected $model = User::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
            'email_verified_at' => now(),
            'password' => bcrypt('password'), // ✅ más legible que un hash en duro
            'remember_token' => Str::random(10),

            // Opcionales si usas estos campos:
            'population' => $this->faker->city,
            'postal_code' => $this->faker->postcode,
            'birthdate' => $this->faker->date('Y-m-d', '2005-01-01'),
        ];
    }
}
