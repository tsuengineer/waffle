<?php

use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('top.index');

Route::get('/users', function () {
    return view('welcome');
})->name('users.index');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/posts', [PostController::class, 'index'])->name('posts.index');
Route::get('/posts/{ulid}', [PostController::class, 'show'])->name('posts.show');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/posts/upload', [PostController::class, 'create'])->name('posts.create');
    Route::post('/posts/upload', [PostController::class, 'store'])->name('posts.store');
    Route::get('/posts/{ulid}/edit', [PostController::class, 'edit'])->name('posts.edit');
    Route::put('/posts/{ulid}', [PostController::class, 'update'])->name('posts.update');
    Route::delete('/posts/{ulid}', [PostController::class, 'destroy'])->name('posts.destroy');
});

require __DIR__.'/auth.php';
