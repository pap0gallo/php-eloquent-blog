<?php

namespace Database\Factories;

use App\Models\Category;
use Faker\Factory as FakerFactory;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    public function definition()
    {
        $faker = FakerFactory::create();

        return [
            'name' => $faker->word(),
            'description' => $faker->sentences(2, true),
            'price' => $faker->randomFloat(2, 100, 1000),
            'category_id' => Category::factory(),
            'is_sponsored' => $faker->boolean(10),
        ];
    }
}
