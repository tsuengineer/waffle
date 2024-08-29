<?php

use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TopController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\XotController;
use Illuminate\Support\Facades\Route;

Route::get('/', [TopController::class, 'index'])->name('top.index');

Route::get('/users', [UserController::class, 'index'])->name('users.index');
Route::get('/users/{userSlug}', [UserController::class, 'show'])->name('users.show');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/dashboard', [ProfileController::class, 'show'])->name('dashboard');

    Route::get('/posts/create', [PostController::class, 'create'])->name('posts.create');
    Route::post('/posts', [PostController::class, 'store'])->name('posts.store');
    Route::get('/posts/{ulid}/edit', [PostController::class, 'edit'])->name('posts.edit');
    Route::put('/posts/{ulid}', [PostController::class, 'update'])->name('posts.update');
    Route::delete('/posts/{ulid}', [PostController::class, 'destroy'])->name('posts.destroy');
    Route::put('/posts/{ulid}/move-up', [PostController::class, 'moveUp'])->name('posts.move_up');
    Route::put('/posts/{ulid}/move-down', [PostController::class, 'moveDown'])->name('posts.move_down');

});

Route::get('/posts', [PostController::class, 'index'])->name('posts.index');
Route::get('/posts/{ulid}', [PostController::class, 'show'])->name('posts.show');

// オセロ盤
Route::get('/board', fn() => view('board.index'))->name('board.index');

// XOT
Route::get('/xot/random', [XotController::class, 'random'])->name('xot.random');

// リンク集
Route::get('/links', fn() => view('static.links'))->name('static.links');

// オセロ講座
Route::get('/basic-strategy', fn() => view('static.basic-strategy'))->name('static.basic-strategy');

// エラー
Route::get('errors', fn() => view('errors.index'))->name('errors.index');

Route::get('/board/test', fn() => view('board.test'))->name('board.test');

require __DIR__.'/auth.php';
