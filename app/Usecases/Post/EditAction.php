<?php

namespace App\Usecases\Post;

use App\Models\Post;

class EditAction
{
    public function __invoke(string $ulid): array
    {
        $post = Post::with('user', 'user.avatars', 'tags', 'comments')
            ->where('ulid', $ulid)
            ->first();

        $comments = '';
        foreach ($post->comments as $comment) {
            $comments .= "{$comment->moves}:{$comment->text}\n";
        }

        return [
            'post' => $post,
            'comments' => trim($comments),
        ];
    }
}
