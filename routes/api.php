<?php

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Route::resource('users', UserController::class);

Route::get('/users', function (Request $request){

});

Route::get('/users/{user}', function (Request $request,User $user){

});

Route::post('/users', function (Request $request){

});

Route::patch('/users', function (Request $request){

});

Route::delete('/users/{user}', function (User $user){

});

Route::get('/users/{id}', function ($id){
    
});