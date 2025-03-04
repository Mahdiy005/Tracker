<?php

namespace Database\Factories;

use App\Enums\UserRole;
use App\Models\User;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class RegularUserFactory extends Factory
{
    protected $model = User::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $serial = IdGenerator::generate([
            'table' => 'users',
            'field' => 'serial',
            'length' => 15,
            'prefix' => 'TRACK-',
        ]);
        return [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'image' => '/',
            'serial' => $serial,
            'password' => '123456789',
            'phone' => '012345678',
            'position' => fake()->jobTitle(),
            'role' => UserRole::USER->value
        ];
    }
}
