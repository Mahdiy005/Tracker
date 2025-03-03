<?php

namespace Database\Factories;

use App\Enums\AttendanceStatus;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ActivityLog>
 */
class ActivityLogFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'activity_type' => getRandomString(getEnumsValue(AttendanceStatus::cases())),
            'is_violate' => false,
            'duration' => fake()->numberBetween(4, 9),
            'user_id' => User::inRandomOrder()->first()->id ?? 2,
        ];
    }
}
