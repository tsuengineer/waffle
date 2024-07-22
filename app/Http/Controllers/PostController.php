<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Usecases\Post\ShowAction;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;

class PostController extends Controller
{
    public function show(ShowAction $action): Response
    {
        $data = $action(request()->ulid);

        if (!$data) {
            return response()->view('errors.404');
        }

        return response()->view('posts.show', $data);
    }

    public function create(): View
    {

    }

    public function store()
    {

    }

    public function edit()
    {

    }

    public function update(): RedirectResponse
    {

    }

    public function destroy()
    {

    }
}
