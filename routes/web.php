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

Route::post('register', [\App\Http\Controllers\Auth\RegisterController::class, 'create'])->name('register');
Route::view('register', 'auth.register');

Route::view('login', 'auth.login');
Route::post('login', [\App\Http\Controllers\Auth\LoginController::class, 'login'])->name('login');

Route::get('logout', [\App\Http\Controllers\Auth\LoginController::class, 'login'])->name('logout');

Route::middleware('auth')->group(function () {
    // Home Page
    Route::view('home', 'home')->name('home');


});

