<?php

use App\Helpers\ApiResponseSchema;
use App\Http\Controllers\API\AttendanceController;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\API\VilationController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});

// Auth Module
Route::controller(AuthController::class)->group(function () {
    Route::prefix('auth')->group(function() {
        Route::post('register', 'register');
        Route::post('login', 'login');
    });
    Route::middleware('auth:sanctum')->prefix('user')->group(function() {
        Route::get('/', 'userDetails');
        Route::post('update-account', 'update');
        Route::get('logout', 'logout');
    });
});


// Routes Accesible by only admin
Route::middleware(['auth:sanctum', 'admin'])->prefix('admin')->group(function() {
    //==================================== User Module
    Route::controller(UserController::class)->prefix('users')->group(function() {
        // get all users in the system
        Route::get('/', 'index');
        // get details of specific user
        Route::get('/{user_id}', 'show');
        // promote new user to admin
        Route::post('/promote/{user_id}', 'promote');
        // demote new user to admin
        Route::post('/demote/{user_id}', 'demote');
    });

    //==================================== Attendance Module
    Route::controller(AttendanceController::class)->prefix('attendance')->group(function() {
        // All attenaces records
        Route::get('/', 'allAttendance');
        // Display all attendance record based status and date
        Route::get('/status/{status}', 'index');
        // get the all history attendance for specific user 
        Route::get('/user/{user_id}', 'getUserAttendance');
        // manually store new attendance
        Route::post('/store/{user_id}', 'store');
    });

    //==================================== Violation Module
    Route::controller(VilationController::class)->prefix('violations')->group(function() {
        Route::get('/', 'index');
        Route::get('/user/{user_id}', 'getUserViolations');
        Route::post('/store', 'store');
        Route::get('/delete/{violation_id}', 'destroy');
    });
});


// // Regular user routes
// Route::middleware(['auth:sanctum', 'role:' . UserRole::USER->value])->group(function () {
//     Route::get('/user/profile', [UserController::class, 'profile']);
//     Route::post('/user/update', [UserController::class, 'update']);
// });
