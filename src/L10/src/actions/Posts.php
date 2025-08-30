<?php

namespace App\actions;

use App\Models\User;
use Illuminate\Support\Collection;

class Posts
{
    public static function index(User $user, int $limit): Collection
    {
        // BEGIN (write your solution here)
        return $user->posts()->published()->likedWithLimit($limit)->get();
        // END
    }
}
