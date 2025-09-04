<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Course\CourseReview;
use App\Models\Course\CourseMember;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Course extends Model
{
    use HasFactory;

    // BEGIN (write your solution here)
    public function members(): HasMany
    {
        return $this->hasMany(CourseMember::class, 'course_id');
    }
    public function reviews(): HasMany
    {
        return $this->hasMany(CourseReview::class, 'course_id');
    }
    // END
}
