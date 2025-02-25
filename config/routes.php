<?php

use App\Controllers\AuthController;
use App\Controllers\UserController;
use App\Controllers\AdminController;
use App\Controllers\FeedbacksController;
use App\Controllers\SnackbarGoodsController;
use App\Controllers\SnackbarGoodsControllerAjax;
use Core\Router\Route;

/* User authentication ################################### */

Route::get(uri: '/login', action: [AuthController::class, 'new'])->name(name: 'all.login');
Route::post(uri: '/login', action: [AuthController::class, 'authenticate'])->name(name: 'authenticate.login');

/* User protected routes ################################# */
Route::middleware(middleware: 'auth:user')->group(callback: function (): void {
    /* GET */
    Route::get(uri: '/home', action: [UserController::class, 'index'])->name(name: 'users.home');
    Route::get(uri: '/feedbacks/create', action: [FeedbacksController::class, 'new'])->name(name: 'user.feedbacks.new');
    Route::get(uri: '/feedbacks/{id}/preview', action: [FeedbacksController::class, 'preview'])->name(name: 'user.feedbacks.preview');

    /* POST */
    Route::post(uri: '/feedbacks/user/create', action: [FeedbacksController::class, 'create'])->name(name: 'user.feedbacks.create');

    /* UPDATE */
    Route::get(uri: '/feedbacks/{id}/edit', action: [FeedbacksController::class, 'edit'])->name(name: 'user.feedbacks.edit');
    Route::put(uri: '/feedbacks/{id}', action: [FeedbacksController::class, 'update'])->name(name: 'user.feedbacks.update');

    /* DELETE */
    Route::delete(uri: '/feedbacks/delete/{id}', action: [FeedbacksController::class, 'destroy'])->name('user.feedbacks.delete');
});

/* Admin protected routes ################################ */
Route::middleware(middleware: 'auth:admin')->group(callback: function (): void {
    /* GET */
    Route::get(uri: '/dashboard', action: [AdminController::class, 'index'])->name(name: 'admins.home');
    Route::get(uri: '/snackbar/create', action: [SnackbarGoodsController::class, 'new'])->name(name: 'admin.snackbar.new');
    Route::get(uri: 'snackbar/edit/{id}', action: [SnackbarGoodsController::class, 'edit'])->name(name: 'admin.snackbar.edit');
    Route::get(uri: '/snackbar/edit/{id}', action: [SnackbarGoodsController::class, 'edit'])->name(name: 'admin.snackbar_good.edit');

    /* POST */
    Route::post(uri: '/snackbar/create', action: [SnackbarGoodsController::class, 'create'])->name(name: 'admin.snackbar_good.create');

    Route::put(uri: '/snackbar/edit/{id}', action: [SnackbarGoodsController::class, 'update'])->name(name: 'admin.snackbar_good.update');

    /* DELETE */
    Route::delete(uri: '/snackbar/delete/{id}', action: [SnackbarGoodsController::class, 'destroy'])->name(name: 'admin.snackbar.destroy');
});

/* Every one protected routes ############################ */
Route::middleware(middleware: 'auth')->group(callback: function (): void {
    /* GET */
    Route::get(uri: '/logout', action: [AuthController::class, 'destroy'])->name(name: 'logout');
    Route::get(uri: '/feedbacks', action: [FeedbacksController::class, 'index'])->name(name: 'feedbacks');
    Route::get(uri: '/snackbar', action: [SnackbarGoodsController::class, 'index'])->name(name: 'snackbar');
    Route::get(uri: '/snackbar/prices', action: [SnackbarGoodsControllerAjax::class, 'prices'])->name(name: '/snackbar.prices');
});
