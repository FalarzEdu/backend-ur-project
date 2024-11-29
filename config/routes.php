<?php

use App\Controllers\AuthController;
use App\Controllers\UserController;
use Core\Router\Route;

// Authentication
Route::get('/login', [AuthController::class, 'new'])->name('users.login');
Route::post('/login', [AuthController::class, 'new'])->name('users.login');

Route::get('/homeAdmin', [UserController::class, 'index'])->name('admins.home');
Route::get('/logout', [AuthController::class, 'destroy'])->name('users.logout');