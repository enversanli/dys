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

Route::post('register', [\App\Http\Controllers\Auth\RegisterController::class, 'store'])->name('register');
Route::get('verify', [\App\Http\Controllers\Auth\RegisterController::class, 'verify'])->name('register.verify');
Route::view('register', 'auth.register');
Route::view('reset-password', 'auth.passwords.reset');
Route::post('reset-password', [\App\Http\Controllers\Auth\ForgotPasswordController::class, 'resetPassword'])->name('password.reset');
Route::view('forgot-password', 'auth.passwords.forgot')->name('auth.forgot-password');
Route::post('forgot-password', [\App\Http\Controllers\Auth\ForgotPasswordController::class, 'update'])->name('password.update');

Route::view('login', 'auth.login')->name('auth.login');
Route::post('login', [\App\Http\Controllers\Auth\LoginController::class, 'login'])->name('login');

Route::get('logout', [\App\Http\Controllers\Auth\LoginController::class, 'logout'])->name('logout');

Route::middleware('auth')->group(function () {
    // Home Page
    Route::get('dashboard', [\App\Http\Controllers\Panel\PanelController::class, 'index'])->name('dashboard');


    // Student Class
    Route::controller(\App\Http\Controllers\Panel\StudentClassController::class)->group(function () {
        Route::post('classes', 'store');
        Route::get('classes/list', 'index');
        Route::view('/classes/create', 'panel.studentClasses.store');
        Route::get('classes/{id}', 'show');
        Route::put('classes/{id}', 'update');
        Route::delete('classes/{id}', 'destroy');
        Route::view('classes', 'panel.studentClasses.index');
        Route::view('classes/{id}/detail', 'panel.studentClasses.show');
    });
    // end Student Class

    // Student
    Route::controller(\App\Http\Controllers\Panel\StudentController::class)->group(function (){

        Route::view('users', 'panel.users.index');
        Route::view('users/{id}/detail', 'panel.users.show');
        Route::post('users', 'store')->name('user.store');
        Route::get('users/list', 'index')->name('user.list');
        Route::delete('users/{user}', 'destroy')->name('user.destroy');
    });
    // end Student

    // Users
    Route::controller(\App\Http\Controllers\Panel\UserController::class)->group(function (){
        Route::get('me', 'me');
        Route::view('users/list', 'panel.users.index');
        Route::view('users/create', 'panel.users.store');
        Route::view('users/{id}/detail', 'panel.users.show');
        Route::get('users/{user}', 'show');
        Route::put('users/{user}', 'update');
        Route::get('users', 'index')->name('users.list');
        Route::post('users', 'store');
        Route::delete('users/{user}', 'destroy');
        Route::view('ogrenci-kayit', 'web.auth.user-register');

    });
    // end Users

});

Route::get('user-roles', [\App\Http\Controllers\Panel\UserRoleController::class, 'index']);


