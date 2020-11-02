<?php

use App\Http\Controllers\Admin\Server\LoginAttemptsController;
use App\Http\Controllers\Admin\StatsController;
use App\Http\Controllers\Admin\UsersController;
use Illuminate\Support\Facades\Route;

Route::get('/', [StatsController::class, 'index'])->name('admin-stats');

Route::match(['GET', 'POST'], '/users', [UsersController::class, 'index'])->name('admin-users');
Route::match(['GET', 'POST'], '/users/{id}', [UsersController::class, 'edit'])->name('admin-users-edit');
Route::match(['GET', 'POST'], '/server/login-attempts', [LoginAttemptsController::class, 'index'])->name('admin-server-login-attempts');