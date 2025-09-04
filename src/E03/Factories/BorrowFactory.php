<?php

namespace Database\Factories;

use App\Models\Borrow;
use App\Models\Book;
use App\Models\User;
use Faker\Factory as FakerFactory;
use Illuminate\Database\Eloquent\Factories\Factory;

class BorrowFactory extends Factory
{
    protected $model = Borrow::class;

    public function definition()
    {
        $faker = FakerFactory::create();

        return [
            'book_id' => Book::factory(),
            'user_id' => User::factory(),
            'borrow_date' => $faker->date(),
            'return_date' => $faker->dateTimeBetween('now', '+1 month'),
        ];
    }
}
