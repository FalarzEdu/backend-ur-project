<?php

use App\Controllers\AuthController;
use App\Controllers\UserController;
use Core\Router\Route;

// Authentication
Route::get('/login', [AuthController::class, 'new'])->name('users.login');
Route::post('/login', [AuthController::class, 'authenticate'])->name('users.login');

// User home
Route::get('/', [UserController::class, 'new'])->name('users.home');
