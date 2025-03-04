<?php

namespace Database\Factories;

use App\Enums\AttendanceStatus;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Attendance>
 */
class AttendanceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'status' => getRandomString([AttendanceStatus::ATTEND->value, AttendanceStatus::ABSENT->value]),
            'user_id' => User::inRandomOrder()->first()->id ?? 1,
            'created_at' => now()->subDays(rand(0, 5))->addSeconds(rand(0, 86400)),
        ];
    }
}
