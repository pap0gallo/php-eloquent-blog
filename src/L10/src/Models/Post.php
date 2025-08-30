<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\User;
use App\Models\PostLike;

class Post extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'body'];

    public function creator()
    {
        return $this->belongsTo(User::class, 'creator_id');
    }

    public function likes()
    {
        return $this->hasMany(PostLike::class);
    }

    // BEGIN (write your solution here)
    public function scopePublished($query)
    {
        return $query->where('state', 'published');
    }

    public function scopeLikedWithLimit($query, $limit)
    {
        return $query->orderByDesc('likes_count')->take($limit);
    }
    // END
}
