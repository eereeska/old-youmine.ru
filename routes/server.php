<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Server\AuthController;

Route::group(['prefix' => 'auth'], function() {
    Route::get('/pre-login', [AuthController::class, 'preLogin']);
});