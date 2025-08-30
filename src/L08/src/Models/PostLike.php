<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Post;

// BEGIN (write your solution here)
class PostLike extends Model
{
    protected $fillable = ['creator_id', 'post_id'];

    public function creator()
    {
        return $this->belongsTo(User::class);
    }

    public function post()
    {
        return $this->belongsTo(Post::class);
    }
}
// END
