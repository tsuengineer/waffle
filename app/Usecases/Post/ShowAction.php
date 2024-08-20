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
                'recommendedPosts' => [],
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

        // おすすめの投稿を取得
        $recommendedPosts = Post::query()
            ->whereHas('tags', function ($query) use ($post) {
                $query->whereIn('name', $post->tags->pluck('name'));
            })
            ->where('id', '!=', $post->id)
            ->inRandomOrder()
            ->take(5)
            ->get();

        return compact('post', 'prevPost', 'nextPost', 'recommendedPosts');
    }
}
