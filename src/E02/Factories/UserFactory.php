<?php

namespace Database\Factories;

use Faker\Factory as FakerFactory;
use Illuminate\Database\Eloquent\Factories\Factory;

class UserFactory extends Factory
{
    public function definition()
    {
        $faker = FakerFactory::create();

        return [
            'username' => $faker->unique()->userName,
            'birthday' => $faker->date(),
            'email_confirmed' => $faker->boolean(),
            'email' => $faker->unique()->safeEmail(),
            'gender' => $faker->randomElement(['male', 'female']),
            'password_digest' => password_hash('password', PASSWORD_BCRYPT),
            'first_name' => $faker->firstName(),
            'last_name' => $faker->lastName(),
        ];
    }
}
