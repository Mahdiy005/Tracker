<?php

namespace Database\Seeders;

use App\Enums\UserRole;
use App\Models\User;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $serial = IdGenerator::generate([
            'table' => 'users',
            'field' => 'serial',
            'length' => 15,
            'prefix' => 'ADMIN-',
        ]);
        User::create([
            'name' => 'admin',
            'email' => 'admin@mail.com',
            'image' => '/',
            'serial' => $serial,
            'password' => '123456789',
            'phone' => '012345678',
            'position' => 'Front-end',
            'role' => UserRole::ADMIN->value
        ]);

        User::factory(30)->create();
    }
}
