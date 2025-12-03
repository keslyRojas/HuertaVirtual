<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\GardenController;

Route::get('/', function () {
    return view('welcome');
});

// Rutas de autenticación
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

// Ruta del huerto 
Route::get('/garden', function () {
    return view('garden.garden');

Route::post('/garden/plant', [GardenController::class, 'plant'])
->name('garden.plant');
Route::post('/garden/water', [GardenController::class, 'water'])
->name('garden.water');
Route::post('/garden/harvest', [GardenController::class, 'harvest'])
->name('garden.harvest');
Route::get('/garden/status/{plot_id}', [GardenController::class, 'status'])
->name('garden.status');

});
