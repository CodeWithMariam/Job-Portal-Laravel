<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\JobType;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Category::factory(5)->create();
        \App\Models\JobType::factory()->count(10)->create();

    }
}
