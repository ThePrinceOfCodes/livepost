<?php

use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Route;

// Route::resource('posts', postController::class);

Route::name('posts.')->group(function(){
    Route::get('/posts', [postController::class, 'index'])->name('index')->withoutMiddleware(['auth']);
    Route::get('/posts/{post}', [postController::class, 'show'])->name('show')->where('post', '[0-9]+');
    Route::post('/posts', [postController::class, 'store'])->name('store');
    Route::patch('/posts/{post}', [postController::class, 'update'])->name('update')->where('post', '[0-9]+');
    Route::delete('/posts/{post}', [postController::class, 'destroy'])->name('delete')->where('post', '[0-9]+');
});

