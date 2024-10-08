<?php

namespace App\Usecases\User;

use App\Models\User;
use Illuminate\Http\Response;

class ShowAction
{
    public function __invoke($userSlug): Response|array
    {
        $user = User::with('avatars', 'posts')
            ->where('slug', $userSlug)
            ->first();

        if (!$user) {
            abort(404);
        }

        $posts = $user->posts()
            ->orderBy('sort')
            ->paginate(100);

        return [
            'user' => $user,
            'posts' => $posts,
        ];
    }
}
