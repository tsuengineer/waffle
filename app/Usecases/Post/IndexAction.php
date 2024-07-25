<?php

namespace App\Usecases\Post;

use App\Models\Post;
use Illuminate\Http\Response;

class IndexAction
{
    public function __invoke(): Response|array
    {
        $posts = Post::with('user', 'user.avatars')->latest()->paginate(100);

        return compact('posts');
    }
}
