<?php

use App\Controllers\AuthController;
use App\Controllers\UserController;
use Core\Router\Route;

// Authentication
Route::get('/', [AuthController::class, 'new'])->name('users.login');
Route::post('/', [AuthController::class, 'authenticate'])->name('users.login');

Route::middleware('auth:user')->group(function () {
    Route::get('/home', [UserController::class, 'new'])->name('users.home');
});
