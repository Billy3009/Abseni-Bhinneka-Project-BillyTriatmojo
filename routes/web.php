<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;

Route::redirect('/', '/login');

// Login
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.process');

// Register
Route::get('/register', function () {
    return view('auth.register');
})->name('register');

Route::post('/register', [AuthController::class, 'register'])
    ->name('register.store');

// Route yang harus login
Route::middleware('auth')->group(function () {

    Route::get('/dashboard', [AdminController::class,'dashboard'])
        ->name('dashboard');

    Route::get('/users', [AdminController::class,'users'])
        ->name('users');

    Route::post('/users/{id}/approve', [AdminController::class,'approve'])
        ->name('users.approve');

    Route::post('/users/{id}/reject', [AdminController::class,'reject'])
        ->name('users.reject');

});