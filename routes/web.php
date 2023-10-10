<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\CustomerController;
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
Route::get('/customer', [CustomerController::class, 'index']);
Route::post('/customer', [CustomerController::class, 'store']);
Route::get('/customer/view', [CustomerController::class, 'view']);
Route::get('/customer/delete/{id}', [CustomerController::class, 'delete'])->name('customer.delete');
Route::get('/customer/forced-delete/{id}', [CustomerController::class, 'forcedDelete'])->name('customer.force-delete');
Route::get('/customer/restore/{id}', [CustomerController::class, 'restore'])->name('customer.restore');
Route::get('/customer/update/{id}', [CustomerController::class, 'update'])->name('customer.update');
Route::post('/customer/update/{id}', [CustomerController::class, 'realUpdate'])->name('customer.update');
Route::get('/customer/trash', [CustomerController::class, 'trash']);

//actual URLS of my project

Route::middleware(['custom'])->group(function () {

    Route::get('/dashboard', [AdminController::class, 'dashboard']);
        Route::post('/add', [AdminController::class, 'store']);
        Route::get('/add/{id?}', [AdminController::class, 'add']);
        Route::post('/add/{id?}', [AdminController::class, 'editStore']);
        // Route::get('/edit/{id}', [AdminController::class, 'edit']);
        // Route::post('/edit/{id}', [AdminController::class, 'editStore']);
        Route::get('/delete/{id}', [AdminController::class, 'delete'])->name('customer.delete');
        Route::get('/trash', [AdminController::class, 'trash']);
        Route::get('/restore/{id}', [AdminController::class, 'restore']);
        Route::get('/deleteForced/{id}', [AdminController::class, 'deleteForced'])->name('customer.deleteForced');
        Route::get('/excel', [AdminController::class, 'export'])->name('excel.export');
        Route::post('/excelImport', [AdminController::class, 'import'])->name('excel.import');
        Route::get('/logout', [AdminController::class, 'logout']);
        Route::get('/admin/dashboard/ajax', [AdminController::class, 'adminAjaxTable']);
        Route::get('/admin/trash/ajax', [AdminController::class, 'trashAjaxTable']);
});
Route::get('/', [AdminController::class, 'index'])->name('login');
Route::post('/', [AdminController::class, 'login']);
Route::get('/register', [AdminController::class, 'register']);
Route::post('/register', [AdminController::class, 'registerStore']);
// Route::get('/dashboard',[AdminController::class,'dashboard'])->middleware('auth');
// Route::post('/add',[AdminController::class,'store']);
// Route::get('/add',[AdminController::class,'add']);
// Route::get('/edit/{id}',[AdminController::class,'edit']);
// Route::post('/edit/{id}',[AdminController::class,'editStore']);
// Route::get('/delete/{id}',[AdminController::class,'delete'])->name('customer.delete');
// Route::get('/trash',[AdminController::class,'trash']);
// Route::get('/restore/{id}',[AdminController::class,'restore']);
// Route::get('/deleteForced/{id}',[AdminController::class,'deleteForced'])->name('customer.deleteForced');
// Route::get('/excel',[AdminController::class,'export'])->name('excel.export');
// Route::get('/logout',[AdminController::class,'logout']);