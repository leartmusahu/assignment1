<?php

use App\Http\Controllers\CourseController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\InstructorController;



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
    return view('index'); // This will be your homepage view
})->name('home');

Route::get('/login', function () {
    return view('auth.login'); // Ensure you're returning the correct view
})->name('login');

Route::post('/login', [UserController::class, 'login']);
Route::get('/register', function () {
    return view('auth.register'); // Ensure this is your registration page view
})->name('register');

Route::post('/register', [UserController::class, 'register']);
Route::post('/logout', [UserController::class, 'logout'])->name('logout');


Route::get('/courses/create', [CourseController::class, 'create'])->name('courses.create');
Route::post('/courses', [CourseController::class, 'store'])->name('courses.store');




Route::post('/instructors', [InstructorController::class, 'register']);




require __DIR__.'/auth.php';
