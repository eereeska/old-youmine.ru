<?php

use App\Http\Controllers\Admin\StatsController;
use App\Http\Controllers\Admin\Users\UnconfirmedController;
use Illuminate\Support\Facades\Route;

Route::get('/', [StatsController::class, 'index'])->name('admin-stats');
Route::get('/users/unconfirmed', [UnconfirmedController::class, 'index'])->name('admin-users-unconfirmed');
Route::post('/users/unconfirmed/search', [UnconfirmedController::class, 'search']);