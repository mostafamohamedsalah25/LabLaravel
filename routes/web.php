<?php

use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});


Route::patch('/posts/{post}/restore', [PostController::class, 'restore'])->name('posts.restore');
Route::resource('posts', PostController::class);

