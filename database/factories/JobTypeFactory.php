<?php

namespace Database\Factories;

use App\Models\JobType;
use Illuminate\Database\Eloquent\Factories\Factory;

class JobTypeFactory extends Factory
{
    protected $model = JobType::class;

    public function definition()
    {
        return [
            'name' => fake()->name()
        ];
    }
}


