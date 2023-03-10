<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

// Route::resource('users', UserController::class);

Route::middleware(['auth'])->name('users.')->group(function(){
    Route::get('/users', [UserController::class, 'index'])->name('index')->withoutMiddleware(['auth']);
    Route::get('/users/{user}', [UserController::class, 'show'])->name('show')->where('user', '[0-9]+');;
    Route::post('/users', [UserController::class, 'store'])->name('store');
    Route::patch('/users/{user}', [UserController::class, 'update'])->name('update')->where('user', '[0-9]+');
    Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('delete')->where('user', '[0-9]+');
});

