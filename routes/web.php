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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::prefix('posts')->group(function () {
    Route::get('/', [App\Http\Controllers\PostController::class, 'index'])->name('posts');
    Route::get('/{id}', [App\Http\Controllers\PostController::class, 'show'])->name('posts-show');
    Route::post('/', [App\Http\Controllers\PostController::class, 'store'])->name('posts-store');
    Route::delete('/{id}', [App\Http\Controllers\PostController::class, 'delete'])->name('posts-delete');
    Route::patch('/{id}', [App\Http\Controllers\PostController::class, 'update'])->name('posts-update');
});
