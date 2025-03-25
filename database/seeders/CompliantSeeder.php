<?php

namespace Database\Seeders;

use App\Models\Compliant;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CompliantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Compliant::factory(20)->create();
    }
}
