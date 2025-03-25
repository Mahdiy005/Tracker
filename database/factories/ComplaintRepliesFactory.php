<?php

namespace Database\Factories;

use App\Models\Compliant;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ComplaintReplies>
 */
class ComplaintRepliesFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'reply' => fake()->text(),
            'compliant_id' => Compliant::query()->inRandomOrder()->value('id'),
            'user_id' => User::where('role', 'admin')->inRandomOrder()->value('id'),
        ];
    }
}
