<?php

namespace App\Http\Controllers;

use App\Usecases\Xot\RandomAction;
use Illuminate\Http\Response;

class XotController extends Controller
{
    public function random(RandomAction $action): Response
    {
        $data = $action();

        if (!$data) {
            return response()->view('errors.404');
        }

        return response()->view('posts.show', [
            'post' => $data['post'],
        ]);
    }
}
