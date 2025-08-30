<?php

namespace App\actions;

use App\Models\User;
use App\Models\Post;
use App\Models\PostLike;

class Posts
{
    public static function create($user, $params): Post
    {
        // BEGIN (write your solution here)
        $post = $user->posts()->create($params);
        return $post;
        // END
    }

    public static function createLike(User $user, Post $post): PostLike
    {
        // BEGIN (write your solution here)
        $postLike = $post->likes()->make();
        $postLike->creator()->associate($user);
        $postLike->save();

        return $postLike;
        // END
    }
}
