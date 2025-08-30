<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Post;
use App\Models\PostLike;

class User extends Model
{
    use HasFactory;

    protected $fillable = ['email', 'first_name', 'last_name'];

    public function posts()
    {
        return $this->hasMany(Post::class, 'creator_id');
    }

    public function postLikes()
    {
        return $this->hasMany(PostLike::class, 'creator_id');
    }
}
