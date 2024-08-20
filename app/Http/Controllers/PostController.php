<?php

namespace App\Http\Controllers;

use App\Http\Requests\Post\DestroyRequest;
use App\Http\Requests\Post\EditRequest;
use App\Http\Requests\Post\MoveDownRequest;
use App\Http\Requests\Post\MoveUpRequest;
use App\Http\Requests\Post\StoreRequest;
use App\Http\Requests\Post\UpdateRequest;
use App\Usecases\Post\DestroyAction;
use App\Usecases\Post\EditAction;
use App\Usecases\Post\IndexAction;
use App\Usecases\Post\MoveDownAction;
use App\Usecases\Post\MoveUpAction;
use App\Usecases\Post\ShowAction;
use App\Usecases\Post\StoreAction;
use App\Usecases\Post\UpdateAction;
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
            'post' => $data['post'],
            'prevPost' => $data['prevPost'],
            'nextPost' => $data['nextPost'],
            'recommendedPosts' => $data['recommendedPosts'],
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

    public function edit(EditRequest $request, EditAction $action): Response
    {
        $ulid = $request->validated('ulid');
        $data = $action($ulid);

        if (empty($data['post'])) {
            return response()->view('errors.404');
        }

        if ($data['post']->user_id !== auth()->user()->id) {
            return response()->view('errors.403');
        }

        return response()->view('posts.edit', [
            'post' => $data['post'],
            'comments' => $data['comments'],
        ]);
    }

    public function update(UpdateRequest $request, UpdateAction $action): RedirectResponse
    {
        $result = $action($request);

        if ($result->isSuccess()) {
            return redirect()->action([ProfileController::class, 'show'])->with('success', '棋譜情報の編集が成功しました。');
        } else {
            return back()->withErrors($result->getErrors())->withInput();
        }
    }

    public function destroy(DestroyRequest $request, DestroyAction $action): RedirectResponse
    {
        $result = $action($request);

        if ($result->isSuccess()) {
            return redirect()->action([ProfileController::class, 'show'])->with('success', '棋譜の削除が成功しました。');
        } else {
            return redirect()->action([ProfileController::class, 'show'])->with('error', '棋譜の削除に失敗しました。');
        }
    }

    public function moveUp(MoveUpRequest $request, MoveUpAction $action): RedirectResponse
    {
        $result = $action($request);

        if ($result->isSuccess()) {
            return redirect()->action([ProfileController::class, 'show'])->with('success', '棋譜順序の更新が成功しました。');
        } else {
            return redirect()->action([ProfileController::class, 'show'])->with('error', '棋譜順序の更新に失敗しました。');
        }
    }

    public function moveDown(MoveDownRequest $request, MoveDownAction $action): RedirectResponse
    {
        $result = $action($request);

        if ($result->isSuccess()) {
            return redirect()->action([ProfileController::class, 'show'])->with('success', '棋譜順序の更新が成功しました。');
        } else {
            return redirect()->action([ProfileController::class, 'show'])->with('error', '棋譜順序の更新に失敗しました。');
        }
    }
}
