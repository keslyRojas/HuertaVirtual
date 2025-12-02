<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', function () {
    return view('authentication.login');
});

Route::post('/registrar', function (Illuminate\Http\Request $request) {

    return $request->all(); 

});


Route::get('/game', function () {
    return view('game.game');
});
