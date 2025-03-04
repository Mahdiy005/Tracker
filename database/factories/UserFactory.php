<?php

namespace Database\Factories;

use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
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
        // $serial = IdGenerator::generate([
        //     'table' => 'users',
        //     'field' => 'serial',
        //     'length' => 15,
        //     'prefix' => 'TRACK-',
        // ]);
        // User::create([
        //     'name' => 'admin',
        //     'email' => 'admin@mail.com',
        //     'image' => '/',
        //     'serial' => $serial,
        //     'password' => '123456789',
        //     'phone' => '012345678',
        //     'position' => 'Front-end',
        //     'role' => UserRole::ADMIN->value
        // ]);
        return [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'image' => '',
            'password' => '123456789',
            'phone' => '012345678',
            'position' => fake()->jobTitle(),
            'serial' => 'TRACK-' . (string) \Illuminate\Support\Str::uuid(),
            'role' => 'user',
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn(array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
