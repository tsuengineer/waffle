<?php

namespace App\Usecases\Post;

use App\Models\Post;

class ShowAction
{
    public function __invoke(string $ulid): array
    {
        $post = Post::with('user', 'user.avatars', 'tags')
            ->where('ulid', $ulid)
            ->first();

        return [
            'post' => $post,
        ];
    }
}
