<?php

namespace Database\Factories;

use App\Models\Review;
use App\Models\Book;
use App\Models\User;
use Faker\Factory as FakerFactory;
use Illuminate\Database\Eloquent\Factories\Factory;

class ReviewFactory extends Factory
{
    protected $model = Review::class;

    public function definition()
    {
        $faker = FakerFactory::create();

        return [
            'book_id' => Book::factory(),
            'reviewer_id' => User::factory(),
            'rating' => $faker->numberBetween(1, 5),
        ];
    }
}
