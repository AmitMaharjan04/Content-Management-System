<?php

// use App\Http\Controllers\AdminController;
use App\Http\Controllers\CustomerController;
use Modules\Admin\Http\Controllers\AdminController;
use GuzzleHttp\Middleware;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

// from the youtube video
// Route::get('/customer', [CustomerController::class, 'index']);
// Route::post('/customer', [CustomerController::class, 'store']);
// Route::get('/customer/view', [CustomerController::class, 'view']);
// Route::get('/customer/delete/{id}', [CustomerController::class, 'delete'])->name('customer.delete');
// Route::get('/customer/forced-delete/{id}', [CustomerController::class, 'forcedDelete'])->name('customer.force-delete');
// Route::get('/customer/restore/{id}', [CustomerController::class, 'restore'])->name('customer.restore');
// Route::get('/customer/update/{id}', [CustomerController::class, 'update'])->name('customer.update');
// Route::post('/customer/update/{id}', [CustomerController::class, 'realUpdate'])->name('customer.update');
// Route::get('/customer/trash', [CustomerController::class, 'trash']);

//actual URLS of my project

Route::get('/', [AdminController::class, 'index'])->name('login');
Route::post('/', [AdminController::class, 'login'])->name('admin.login');
Route::get('/register', [AdminController::class, 'register']);
Route::post('/register', [AdminController::class, 'registerStore']);