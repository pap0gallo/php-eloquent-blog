<?php

namespace App\Models\Course;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Course;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CourseReview extends Model
{
    use HasFactory;

    // BEGIN (write your solution here)
    public function member(): BelongsTo
    {
        return $this->belongsTo(CourseMember::class, 'course_member_id');
    }

    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class, 'course_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    // END
}
