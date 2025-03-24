<?php

use App\Enums\UserRole;
use App\Http\Controllers\API\ActivityLogController;
use App\Http\Controllers\API\AttendanceController;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\ComplaintRepliesController;
use App\Http\Controllers\API\CompliantController;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\API\VilationController;
use App\Http\Controllers\API\TrainedImageController;
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

// Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
//     return $request->user();
// });

// ============== Auth Module
Route::controller(AuthController::class)->group(function () {
    // Handle Only admin can register new user , regular user can't register new account 
    Route::post('admin/register-user', 'register')->middleware(['auth:sanctum', 'admin']);
    // this route for all users admin or reqgular can signin
    Route::post('auth/login', 'login');

    Route::middleware('auth:sanctum')->prefix('user')->group(function () {
        Route::post('update-account', 'update');
        Route::get('logout', 'logout');
    });
});


// Routes Accesible by only admin
Route::middleware(['auth:sanctum', 'admin'])->prefix('admin')->group(function () {
    //==================================== User Module
    Route::controller(UserController::class)->prefix('users')->group(function () {
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
    Route::controller(AttendanceController::class)->prefix('attendance')->group(function () {
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
    Route::controller(VilationController::class)->prefix('violations')->group(function () {
        Route::get('/', 'index');
        Route::get('/user/{user_id}', 'getUserViolations');
        Route::post('/store', 'store');
        Route::get('/delete/{violation_id}', 'destroy');
    });

    //==================================== ActivityLog Module
    Route::controller(ActivityLogController::class)->prefix('activity-log')->group(function () {
        Route::get('/', 'index');
        Route::get('/user/{user_id}', 'getActivLogForUser');
        Route::get('/delete/{activityLogID}', 'destrot');
    });

    //==================================== Compiants Module
    Route::controller(CompliantController::class)->prefix('compliant')->group(function () {
        // get all compiants
        Route::get('/', 'index');
        // Update a complaint (e.g., change status)
        Route::post('edit/{id}', 'update');
        // Get single complaint for users
        Route::get('/{id}', 'desplayCompliant');
        // Admin Replies to Compliant
        // Route::post('reply/{compliant_id}', 'store')
    });

    //==================================== Compiants Module
    Route::controller(ComplaintRepliesController::class)->prefix('compliant-reply')->group(function () {
        // Admin Replies to specific Compliant
        Route::post('/{compliant_id}', 'store');
        // Delete Reply
        Route::get('/delete/{compliant_id}', 'destroy');
    });
});
// 10|GaTCDwP4uWTNcUXTYJ3Pubx3SKiUHvw4OxeTqK1Wc285ac7b~~ regular user token
// 12|np2uorauE0UAQpuo7rEYFVvGwSZ1TvjDJ7v690cS53a56475~~ admin user token

// Regular user routes
Route::middleware(['auth:sanctum', 'role:' . UserRole::USER->value])->prefix('user')->group(function () {
    Route::get('/', [AuthController::class, 'userDetails']);

    //==================================== Trained Images Module
    Route::controller(TrainedImageController::class)->prefix('trained-images')->group(function () {
        Route::post('store', 'store');
        Route::get('index', 'index');
        Route::get('delete/{img_id}', 'destroy');
    });

    //==================================== Compliants Module
    Route::controller(CompliantController::class)->prefix('compliant')->group(function () {
        // submit new complaints
        Route::post('/', 'store');
        // display your complaints history
        Route::get('/my-complaints', 'displayMyComplaints');
    });
});

// //==================================== Compiants Module Routes For Both Admin And users
// Route::controller(CompliantController::class)->prefix('compliant')->group(function () {
//     // Get a single complaint with replies
    
// });