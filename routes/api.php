<?php

use App\Helpers\ApiResponseSchema;
use App\Http\Controllers\API\AuthController;
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
    Route::get('/', function() {
        return ApiResponseSchema::sendResponse(200, 'OK', ['hello']);
    });
});


// // Regular user routes
// Route::middleware(['auth:sanctum', 'role:' . UserRole::USER->value])->group(function () {
//     Route::get('/user/profile', [UserController::class, 'profile']);
//     Route::post('/user/update', [UserController::class, 'update']);
// });
