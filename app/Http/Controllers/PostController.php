<?php

namespace App\Http\Controllers;

use App\Http\Requests\Post\StoreRequest;
use App\Usecases\Post\IndexAction;
use App\Usecases\Post\ShowAction;
use App\Usecases\Post\StoreAction;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;

class PostController extends Controller
{
    public function show(ShowAction $action): Response
    {
        $data = $action(request()->ulid);

        if (!$data) {
            return response()->view('errors.404');
        }

        return response()->view('posts.show', [
            'post' => $data['post']
        ]);
    }

    public function index(IndexAction $action): Response
    {
        $data = $action();

        if (!$data) {
            return response()->view('errors.404');
        }

        return response()->view('posts.index', [
            'posts' => $data['posts']
        ]);
    }

    public function create(): Response
    {
        return response()->view('posts.create');
    }

    public function store(StoreRequest $request, StoreAction $action): RedirectResponse
    {
        $result = $action($request);

        if ($result->isSuccess()) {
            return redirect()->action([ProfileController::class, 'show'])->with('success', '棋譜の投稿が成功しました。');
        } else {
            return back()->withErrors($result->getErrors())->withInput();
        }
    }
}
