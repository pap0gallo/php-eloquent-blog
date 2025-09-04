<?php

namespace Database\Factories\Course;

use App\Models\Course;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;

class CourseMemberFactory extends Factory
{
    public function definition()
    {
        return [
            'user_id' => User::factory(),
            'course_id' => Course::factory(),
        ];
    }
}
