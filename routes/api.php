<?php

use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\BlogController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

//Actual API routes of my project
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
// Route::middleware('auth:api')->group(function(){
// });
