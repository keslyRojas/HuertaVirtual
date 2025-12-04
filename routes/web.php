<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\GardenController;
use App\Http\Controllers\InventoryController;


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


Route::get('/garden', [GardenController::class, 'index'])->name('garden');


Route::get('/game', [GardenController::class, 'index'])->name('game');


Route::post('/garden/plant', [GardenController::class, 'plant'])
    ->name('garden.plant');

Route::post('/garden/water', [GardenController::class, 'water'])
    ->name('garden.water');

Route::post('/garden/fertilize', [GardenController::class, 'fertilize'])
    ->name('garden.fertilize');

Route::post('/garden/harvest', [GardenController::class, 'harvest'])
    ->name('garden.harvest');

Route::get('/garden/status/{plot_id}', [GardenController::class, 'status'])
    ->name('garden.status');

// Rutas para el inventario
Route::get('/inventory', [InventoryController::class, 'index'])
    ->name('inventory.index');