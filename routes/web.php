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
    Route::get('dashboard', [\App\Http\Controllers\Panel\PanelController::class, 'index'])->name('dashboard');


    // Student Class
    Route::controller(\App\Http\Controllers\Panel\StudentClassController::class)->group(function () {
        Route::view('/classes/create-class', 'panel.studentClasses.store');
        Route::view('classes', 'panel.studentClasses.index');
        Route::get('classes-list', 'index');
        Route::post('classes', 'store');
    });
    // end Student Class

    Route::controller(\App\Http\Controllers\Panel\StudentController::class)->group(function (){
        Route::view('students', 'panel.students.index');
        Route::get('student-list', 'index');
    });

});

