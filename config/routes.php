<?php

use App\Controllers\AuthController;
use Core\Router\Route;

// Authentication
Route::get('/login', [AuthController::class, 'new'])->name('users.login');
Route::post('/login', [AuthController::class, 'new'])->name('users.login');
