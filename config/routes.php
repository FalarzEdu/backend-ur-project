<?php

use App\Controllers\AuthController;
use App\Controllers\UserController;
use App\Controllers\AdminController;
use App\Controllers\FeedbacksController;
use Core\Router\Route;

/* User authentication ################################### */
Route::get(uri: '/login', action: [AuthController::class, 'new'])->name(name: 'all.login');
Route::post(uri: '/login', action: [AuthController::class,'authenticate'])->name(name: 'authenticate.login');

/* User protected routes ################################# */
Route::middleware(middleware: 'auth:user')->group(callback: function (): void {
    /* GET */
    Route::get(uri: '/home', action: [UserController::class, 'index'])->name(name: 'users.home');
    Route::get(uri: '/feedbacks/create', action: [FeedbacksController::class, 'new'])->name(name: 'user.feedbacks.new');

    /* POST */
    Route::post(uri: '/feedbacks/user/create', action: [FeedbacksController::class, 'create'])->name(name: 'user.feedbacks.create');

    /* DELETE */
    Route::delete(uri: '/feedbacks/delete/{id}', action: [FeedbacksController::class,'destroy'])->name('user.feedbacks.delete');
});

/* Admin protected routes ################################ */
Route::middleware(middleware: 'auth:admin')->group(callback: function (): void {
    /* GET */
    Route::get(uri: '/dashboard', action: [AdminController::class, 'index'])-> name(name: 'admins.home');
});

/* Every one protected routes ############################ */
Route::middleware(middleware: 'auth')->group(callback: function (): void {
    /* GET */
    Route::get(uri: '/logout', action: [AuthController::class, 'destroy'])->name(name: 'logout');
    Route::get(uri: '/feedbacks', action: [FeedbacksController::class,'index'])->name(name: 'feedbacks');
});
