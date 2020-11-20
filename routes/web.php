<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\FrontController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SkinController;
use App\Http\Controllers\UnitPayController;
use App\Http\Controllers\VKController;
use Illuminate\Support\Facades\Route;

Route::get('/', function() {
    return view('pages.home');
})->name('home');

Route::get('/login', [AuthController::class, 'index'])->middleware('guest')->name('login');
Route::post('/login', [AuthController::class, 'login'])->middleware('guest')->name('login-post');
Route::get('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

Route::get('/unitpay/check', [UnitPayController::class, 'check']);

Route::group(['middleware' => 'auth'], function() {
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
    Route::get('/deposit', [UnitPayController::class, 'deposit'])->name('deposit');
    Route::post('/change-password', [ProfileController::class, 'changePassword'])->name('change-password');
});


Route::group(['prefix' => 'front', 'middleware' => 'auth'], function() {
    Route::get('/deposit/convert/rub/coins', [UnitPayController::class, 'convertRubToCoins']);
    Route::post('/toggle', [FrontController::class, 'toggle'])->name('front-toggle');
    Route::post('/search/users/unconfirmed', [FrontController::class, 'searchUnconfirmedUsers']);
    Route::post('/skin', [SkinController::class, 'upload'])->name('skin-upload');
});