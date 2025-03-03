<?php

namespace Database\Seeders;

use App\Models\ActivityLog;
use Database\Factories\ActivityLogFactory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ActivityLogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ActivityLog::factory(10)->create();
    }
}
