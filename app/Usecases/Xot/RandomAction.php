<?php

namespace App\Usecases\Xot;

use App\Models\Post;

class RandomAction
{
    public function __invoke(): array
    {
        $post = Post::with('user', 'user.avatars', 'tags', 'comments')
            ->where('user_id', 1)
            ->whereHas('tags', function($query) {
                $query->where('name', 'XOT初期盤面');
            })
            ->inRandomOrder()
            ->firstOrFail();

        return compact('post');
    }
}
