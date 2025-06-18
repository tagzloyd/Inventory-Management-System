<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

// Public Routes (No Auth Required)
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Protected Routes (Require Sanctum Authentication)
Route::middleware('auth:sanctum')->group(function () {
    // User Data
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    // Dashboard Data
    Route::get('/dashboard', function (Request $request) {
        return $request->user();
    });

    // Logout
    Route::post('/logout', [AuthController::class, 'logout']);
    // User List (Example Protected Resource)
    Route::get('/list', [AuthController::class, 'f_index']);
    Route::put('/users/{id}', [AuthController::class, 'f_update']);
    Route::delete('/users/{id}', [AuthController::class, 'f_destroy']);
});
