<?php

use App\Http\Controllers\CommentController;
use Illuminate\Support\Facades\Route;

// Route::resource('Comments', CommentController::class);

Route::middleware(['auth'])->name('Comments.')->group(function(){
    Route::get('/Comments', [CommentController::class, 'index'])->name('index')->withoutMiddleware(['auth']);
    Route::get('/Comments/{Comment}', [CommentController::class, 'show'])->name('show');
    Route::post('/Comments', [CommentController::class, 'store'])->name('store');
    Route::patch('/Comments/{Comment}', [CommentController::class, 'update'])->name('update');
    Route::delete('/Comments/{Comment}', [CommentController::class, 'destroy'])->name('delete');
});

