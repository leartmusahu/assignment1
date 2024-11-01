<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\InstructorController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\ThreadController;
use App\Http\Controllers\EnrollmentController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/




// Public routes
Route::post('/register', [UserController::class, 'register']);
Route::post('/login', [UserController::class, 'login'])->name('api.login');

// Protected routes
Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('admins', AdminController::class);
    Route::apiResource('threads', ThreadController::class);

    // Instructor-related routes
    Route::middleware('role:instructor')->group(function () {
        Route::post('instructors', [InstructorController::class, 'store']);
        Route::post('/instructor/courses', [InstructorController::class, 'store']); // Create course
    });

    // Course-related routes
    Route::apiResource('users', UserController::class);
    Route::apiResource('courses', CourseController::class);
    Route::post('/courses/{course}/enroll', [CourseController::class, 'enroll']); // Enroll in a course
});

    Route::post('/enroll', [EnrollmentController::class, 'enroll']);

    Route::post('/threads', [ThreadController::class, 'create']);
    Route::delete('/threads/{id}', [ThreadController::class, 'delete']);
    Route::post('/replies', [ThreadController::class, 'reply']);
    Route::delete('/replies/{id}', [ThreadController::class, 'deleteReply']);


    Route::delete('/courses/{id}', 'CourseController@destroy')->middleware('auth:api', 'isAdmin');
