<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthenticationController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/register', [AuthenticationController::class, 'showRegister'])
    ->name('register');

Route::post('/register', [AuthenticationController::class, 'register'])
    ->name('register.submit');

Route::get('/login', [AuthenticationController::class, 'showLogin'])
    ->name('login');

Route::post('/login', [AuthenticationController::class, 'login'])
    ->name('login.submit');

Route::post('/logout', [AuthenticationController::class, 'logout'])
    ->name('logout');

Route::get('/game', function () {
    return view('game.game');
});
