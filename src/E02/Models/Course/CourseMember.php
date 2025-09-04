<?php

namespace App\Models\Course;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\User;
use App\Models\Course;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CourseMember extends Model
{
    use HasFactory;

    // BEGIN (write your solution here)
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class, 'course_id');
    }

    public function courseReviews(): HasMany
    {
        return $this->hasMany(CourseReview::class, 'course_member_id');
    }
    // END
}
