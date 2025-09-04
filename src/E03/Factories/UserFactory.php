<?php

namespace Database\Factories;

use App\Models\User;
use Faker\Factory as FakerFactory;
use Illuminate\Database\Eloquent\Factories\Factory;

class UserFactory extends Factory
{
    protected $model = User::class;

    public function definition()
    {
        $faker = FakerFactory::create();

        return [
            'name' => $faker->name(),
            'email' => $faker->unique()->safeEmail(),
            'password_hash' => password_hash('password', PASSWORD_BCRYPT),
        ];
    }
}
