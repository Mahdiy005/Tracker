<?php

namespace Database\Seeders;

use App\Models\ComplaintReplies;
use Database\Factories\ComplaintRepliesFactory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ComplaintRepliesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ComplaintReplies::factory(20)->create();
    }
}
