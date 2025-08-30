<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Post;

class PostLike extends Model
{
    public function creator()
    {
        return $this->belongsTo(User::class, 'creator_id');
    }

    public function post()
    {
        return $this->belongsTo(Post::class);
    }
}
