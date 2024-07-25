<?php

namespace App\Usecases\User;

use App\Models\User;
use Illuminate\Http\Response;

class IndexAction
{
    public function __invoke(): Response|array
    {
        $users = User::with('avatars')->latest()->get();

        return [
            'users' => $users,
        ];
    }
}
