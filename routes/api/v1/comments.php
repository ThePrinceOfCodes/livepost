<?php

use App\Http\Controllers\CommentController;
use Illuminate\Support\Facades\Route;

// Route::resource('comments', commentController::class);

Route::middleware(['auth'])->name('comments.')->group(function(){
    Route::get('/comments', [commentController::class, 'index'])->name('index')->withoutMiddleware(['auth']);
    Route::get('/comments/{comment}', [commentController::class, 'show'])->name('show')->where('comment', '[0-9]+');
    Route::post('/comments', [commentController::class, 'store'])->name('store');
    Route::patch('/comments/{comment}', [commentController::class, 'update'])->name('update')->where('comment', '[0-9]+');
    Route::delete('/comments/{comment}', [commentController::class, 'destroy'])->name('delete')->where('comment', '[0-9]+');
});

