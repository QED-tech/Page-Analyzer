<?php

use App\Http\Controllers\UrlCheckController;
use App\Http\Controllers\UrlController;
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

/* <--- URLS ---->  */
Route::resource('urls', UrlController::class)->only([
    'store', 'show', 'index'
]);
Route::get('/', [UrlController::class, 'create'])->name('home');
Route::resource('urls/{id}/checks', UrlCheckController::class)->only([
    'store'
]);
