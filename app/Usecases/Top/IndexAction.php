<?php

namespace App\Usecases\Top;

use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Response;

class IndexAction
{
    public function __invoke(): Response|array
    {
        $latestUsers = User::with('avatars')->latest()->limit(3)->get();
        $latestPosts = Post::with('user', 'user.avatars', 'tags', 'comments')->latest()->limit(3)->get();
        $randomPosts = Post::with('user', 'user.avatars', 'tags', 'comments')->inRandomOrder()->limit(3)->get();

        return compact('latestUsers', 'latestPosts', 'randomPosts');
    }
}
