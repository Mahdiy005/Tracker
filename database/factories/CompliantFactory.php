<?php

namespace Database\Factories;

use App\Enums\CompliantStatus;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Compliant>
 */
class CompliantFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'subject' => fake()->word(),
            'message' => fake()->text(),
            'status' => getRandomString(getEnumsValue(CompliantStatus::cases())),
            'user_id' => User::where('role', 'user')->inRandomOrder()->value('id'),
        ];
    }
}
