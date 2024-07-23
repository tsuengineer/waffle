<?php

namespace App\Usecases\Profile;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IndexAction
{
    public function __invoke(Request $request): array
    {
        $user = User::with('avatars', 'posts')
            ->where('id', Auth::user()->id)
            ->first();

        $posts = $user->posts()
            ->orderBy('created_at', 'desc')
            ->paginate(40, ['*'], 'page');

        return [
            'user' => $user,
            'posts' => $posts,
        ];
    }
}
