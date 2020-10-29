<?php

use App\Http\Controllers\FrontController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UnitPayController;
use App\Http\Controllers\VKController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/login', [VKController::class, 'login'])->name('login');
Route::get('/logout', [VKController::class, 'logout'])->name('logout');

Route::get('/unitpay/check', [UnitPayController::class, 'check']);

Route::group(['middleware' => 'auth'], function() {
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
    Route::post('/profile/update', [ProfileController::class, 'update'])->name('profile-update');
});

Route::group(['prefix' => 'front', 'middleware' => 'auth'], function() {
    Route::post('/toggle', [FrontController::class, 'toggle'])->name('front-toggle');
    Route::post('/search/users/unconfirmed', [FrontController::class, 'searchUnconfirmedUsers']);
});