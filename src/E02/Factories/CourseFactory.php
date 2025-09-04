<?php

namespace Database\Factories;

use Faker\Factory as FakerFactory;
use Illuminate\Database\Eloquent\Factories\Factory;

class CourseFactory extends Factory
{
    public function definition()
    {
        $faker = FakerFactory::create();
        return [
            'name' => $faker->sentence(),
            'body' => $faker->paragraph(),
        ];
    }
}
