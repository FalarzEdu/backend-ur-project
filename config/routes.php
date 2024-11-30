<?php

use App\Controllers\AuthController;
use App\Controllers\UserController;
use App\Controllers\AdminController;
use Core\Router\Route;

// Authentication
Route::get('/login', [AuthController::class, 'new'])->name('users.login');
Route::post('/login', [AuthController::class, 'new'])->name('users.login');

Route::get('/', [UserController::class, 'index'])->name('users.home');
Route::get('/logout', [AuthController::class, 'destroy'])->name('users.logout');

Route::get('/homeAdmin', [AdminController::class, 'index'])-> name('admins.home');
