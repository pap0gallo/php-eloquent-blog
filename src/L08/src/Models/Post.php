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
        return $this->belongsTo(User::class);
    }

    // BEGIN (write your solution here)
    public function likes()
    {
        return $this->hasMany(PostLike::class, 'post_id');
    }
    // END
}
