<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Course\CourseMember as CourseMember;
use App\Models\Course\CourseReview;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Model
{
    use HasFactory;

    // BEGIN (write your solution here)
    public function topics(): HasMany
    {
        return $this->hasMany(Topic::class, 'user_id');
    }
    public function courseMembers(): HasMany
    {
        return $this->HasMany(CourseMember::class, 'user_id');
    }
    public function courseReviews(): HasMany
    {
        return $this->hasMany(CourseReview::class, 'user_id');
    }
    // END
}
