<?php

namespace App\Usecases\Post;

use App\Models\Post;

class ShowAction
{
    public function __invoke(string $ulid): array
    {
        // 現在の投稿を取得
        $post = Post::with('user', 'user.avatars', 'tags', 'comments')
            ->where('ulid', $ulid)
            ->first();

        if (!$post) {
            return [
                'post' => null,
                'prevPost' => null,
                'nextPost' => null,
            ];
        }

        $userId = $post->user_id;

        // 前の投稿を取得
        $prevPost = Post::query()->where('user_id', $userId)
            ->where('sort', '<', $post->sort)
            ->orderBy('sort', 'desc')
            ->first();

        // 次の投稿を取得
        $nextPost = Post::query()->where('user_id', $userId)
            ->where('sort', '>', $post->sort)
            ->orderBy('sort', 'asc')
            ->first();

        return compact('post', 'prevPost', 'nextPost');
    }
}
