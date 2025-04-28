<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Vilation>
 */
class VilationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'violation_type' => $this->faker->randomElement(['Phone', 'Smoke', 'Unauthorized Entry', 'Test Violation']),
            'detected_by' => $this->faker->randomElement(['ai', 'manual']),
            'violation_image' => $this->faker->imageUrl(640, 480, 'violation', true),
            'user_id' => User::inRandomOrder()->first()->id, // Pick random existing user
            'created_at' => $this->faker->dateTimeBetween('first day of January this year', 'last day of December this year'),
            'updated_at' => now(),
        ];
    }
}
