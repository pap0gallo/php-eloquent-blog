<?php

namespace Database\Factories;

use App\Models\Book;
use App\Models\Author;
use Faker\Factory as FakerFactory;
use Illuminate\Database\Eloquent\Factories\Factory;

class BookFactory extends Factory
{
    protected $model = Book::class;

    public function definition()
    {
        $faker = FakerFactory::create();

        return [
            'title' => $faker->sentence(),
            'genre' => $faker->word(),
            'author' => $faker->name(),
            'copies_available' => $faker->numberBetween(0, 3),
        ];
    }
}
