<?php

namespace App\actions;

use App\Models\Post;
use App\Models\User;
use Illuminate\Support\Collection;

class Posts
{
    public static function index(User $user, int $limit): Collection
    {
        // BEGIN (write your solution here)
        $posts = Post::with('likes')->orderBy('id')->take($limit)->get();
        $postIds = $posts->pluck('id');
        $likedPostIds = $user->postLikes->whereIn('post_id', $postIds)->pluck('post_id');

        return $posts->map(function ($post) use ($likedPostIds) {
            return ['post' => $post->makeHidden('likes')->toArray(),
                'liked' => $likedPostIds->contains($post->id)];
        });
        // END
    }
}
