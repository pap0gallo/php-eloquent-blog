<?php

namespace Database\Factories;

use Faker\Factory as FakerFactory;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;

class TopicFactory extends Factory
{
    public function definition()
    {
        $faker = FakerFactory::create();

        return [
            'user_id' => User::factory(),
            'title' => $faker->sentence(),
            'body' => $faker->paragraph(),
        ];
    }
}
