<?php

namespace Database\Seeders;

use App\Models\Vilation;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class VilationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Vilation::factory(100)->create();
    }
}
