<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Modules\User\Http\Controllers\Api\UserController;
use Modules\User\Http\Controllers\Api\BlogController;
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

Route::post('/login', [UserController::class, 'login']);
Route::post('/register', [UserController::class, 'register']);


Route::middleware('auth:api')->group(function () {
    Route::post('/user/show/{id}', [UserController::class, 'show']);//get
    Route::delete('/user/delete/{id}', [UserController::class, 'destroy']);
    Route::post('/create-blog', [BlogController::class, 'createBlog']);
    Route::post('user/update/{id}', [UserController::class, 'update']);
    Route::post('change-password/{id}', [UserController::class, 'changePassword']);
    Route::get('/logout',[UserController::class,'logout']);
    Route::get('/',[UserController::class,'index']);//get
    Route::get('/user', [UserController::class, 'index']);
});