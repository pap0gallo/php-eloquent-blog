<?php

namespace Database\Factories\Course;

use App\Models\Course;
use App\Models\Course\CourseMember;
use Faker\Factory as FakerFactory;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;

class CourseReviewFactory extends Factory
{
    public function definition()
    {
        $faker = FakerFactory::create();

        return [
            'course_member_id' => CourseMember::factory(),
            'course_id' => Course::factory(),
            'user_id' => User::factory(),
            'spent_minutes' => $faker->numberBetween(1, 120),
            'rating' => $faker->numberBetween(1, 5),
            'body' => $faker->paragraph(),
        ];
    }
}
