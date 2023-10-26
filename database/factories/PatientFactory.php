<?php

namespace Database\Factories;

use App\Enums\PatientType;
use App\Models\Owner;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Patient>
 */
class PatientFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'date_of_birth' => fake()->dateTimeBetween('-10year', '-5year'),
            'name' => fake()->unique()->firstName(),
            'owner_id' => Owner::factory(),
            'type' => fake()->randomElement(['cat', 'dog', 'rabbit']),
        ];
    }
}
