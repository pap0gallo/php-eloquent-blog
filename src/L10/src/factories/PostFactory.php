<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
use App\Models\Post;
use Faker\Factory as Faker;

class PostFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Post::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $faker = Faker::create();

        return [
            'title' => $faker->sentence,
            'body' => $faker->text,
            'state' => collect(['draft', 'published'])->random(),
            'likes_count' => mt_rand(0, 100),
            'creator_id' => function () {
                return User::first()->id;
            }
        ];
    }
}
