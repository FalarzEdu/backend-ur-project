<?php

use App\Controllers\AuthController;
use App\Controllers\UserController;
use App\Controllers\AdminController;
use Core\Router\Route;

/* User authentication ################################### */
Route::get(uri: '/login', action: [AuthController::class, 'new'])->name(name: 'login');
Route::post(uri: '/login', action: [AuthController::class,'authenticate'])->name(name: 'login');

Route::middleware(middleware: 'auth:user')->group(callback: function (): void {
    Route::get(uri: '/home', action: [UserController::class, 'index'])->name(name: 'users.home');
});

Route::middleware(middleware: 'auth:admin')->group(callback: function (): void {
    Route::get(uri: '/dashboard', action: [AdminController::class, 'index'])-> name(name: 'admins.home');
});

Route::middleware(middleware: 'auth')->group(callback: function (): void {
    Route::get(uri: '/logout', action: [AuthController::class, 'destroy'])->name(name: 'logout');
});
