<?php

use Illuminate\Support\Facades\Route;
use Modules\Admin\Http\Controllers\AdminController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::prefix('admin')->middleware(['custom'])->group(function () {

    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
        Route::post('/add', [AdminController::class, 'store']);
        Route::get('/add/{id?}', [AdminController::class, 'add']);
        Route::post('/add/{id?}', [AdminController::class, 'editStore']);
        Route::get('/delete/{id}', [AdminController::class, 'delete'])->name('admin.customer.delete');
        Route::get('/trash', [AdminController::class, 'trash']);
        Route::get('/restore/{id}', [AdminController::class, 'restore']);
        Route::get('/deleteForced/{id}', [AdminController::class, 'deleteForced'])->name('admin.customer.deleteForced');
        Route::get('/excel', [AdminController::class, 'export'])->name('excel.export');
        Route::post('/excelImport', [AdminController::class, 'import'])->name('excel.import');
        Route::get('/logout', [AdminController::class, 'logout']);
});