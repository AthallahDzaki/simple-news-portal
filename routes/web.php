<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MainController;
use App\Http\Controllers\NewsController;
use Illuminate\Support\Facades\Route;

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

Route::get('/', [MainController::class, 'index']);
Route::prefix('/admin')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('admin.dashboard');
    Route::get('/berita', function () {
        echo "Selamat datang di halaman kelola berita";
    });
    Route::resource('/kategori', CategoryController::class);
    Route::controller(NewsController::class)->prefix('news')->group(function () {
        Route::get('/', 'index')->name('news.index');
        Route::get('/create', 'create')->name('news.create');
        Route::post('/store', 'store')->name('news.store');
        Route::post('/upload-image', 'uploadImage')->name('news.uploadImage');
        Route::put('/update/{id}', 'update')->name('news.update');
        Route::get('/edit/{id}', 'edit')->name('news.edit');
        Route::delete('/destroy/{id}', 'destroy')->name('news.destroy');
    });
});
