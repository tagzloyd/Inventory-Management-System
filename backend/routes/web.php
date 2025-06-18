<?php

use App\Http\Controllers\AuthController;
use App\Models\User;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });

// This is the correct route for users
Route::get('/web/users', function() {
    $users = User::all();
    return view('welcome', ['users' => $users]);
});
Route::get('/', [AuthController::class, 'index'])->name('users.index');
Route::get('/users/create', [AuthController::class, 'create'])->name('users.create');
Route::post('/users', [AuthController::class, 'store'])->name('users.store');
Route::get('/users/{user}/edit', [AuthController::class, 'edit'])->name('users.edit');
Route::put('/users/{user}', [AuthController::class, 'update'])->name('users.update');
Route::delete('/users/{user}', [AuthController::class, 'destroy'])->name('users.destroy');