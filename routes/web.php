<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', [\App\Http\Controllers\FrontPageController::class, 'index'])->name('home');

Auth::routes();

Route::group(['prefix' => 'frontend', 'as' => 'frontend.', 'namespace' => 'Frontend', 'middleware' => ['auth']], function () {
    //Home
    Route::get('/home', [\App\Http\Controllers\Frontend\HomeController::class, 'index'])->name('frontend.home');
    Route::get('/create', [\App\Http\Controllers\Frontend\MoviesController::class, 'create'])->name('create');
    Route::post('/create-movie', [\App\Http\Controllers\Frontend\MoviesController::class, 'store'])->name('store');
});


