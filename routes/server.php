<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Server\AuthController;
use App\Http\Controllers\Server\Player\BalanceController;

Route::group(['prefix' => 'auth'], function() {
    Route::get('/pre-login', [AuthController::class, 'preLogin']);
    Route::get('/register', [AuthController::class, 'register']);
    Route::get('/login', [AuthController::class, 'login']);
});

Route::group(['prefix' => 'player/{name}'], function() {
    Route::get('/balance', [BalanceController::class, 'get']);
    Route::get('/balance/increase', [BalanceController::class, 'increase']);
    Route::get('/balance/reduce', [BalanceController::class, 'reduce']);
});