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
        Route::view('students/create', 'panel.students.store');
        Route::get('students/{id}', 'show');
        Route::put('students/{id}', 'update');
        Route::view('students', 'panel.students.index');
        Route::view('students/{id}/detail', 'panel.students.show');
        Route::post('students', 'store')->name('student.store');
        Route::get('students/list', 'index')->name('student.list');
        Route::delete('students/{user}', 'destroy')->name('student.destroy');
    });
    // end Student

    // Users
    Route::controller(\App\Http\Controllers\Panel\UserController::class)->group(function (){
        Route::get('users', 'index');
    });
    // end Users

});


