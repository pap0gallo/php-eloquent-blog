<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\User;
use App\Models\Post;

class PostLike extends Model
{
    use HasFactory;

    public function creator()
    {
        return $this->belongsTo(User::class);
    }

    public function post()
    {        return $this->belongsTo(Post::class);
    }
}
