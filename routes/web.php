<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;


Route::get('/login', function () {
    return view('login'); 
})->name('login');

Route::post('/login', [AuthController::class, 'loginWeb']);

Route::middleware('auth')->group(function () {
    
    Route::get('/admin', function () {
        return "<h1>Panel de Administrador</h1><p>Bienvenido " . auth()->user()->nombre . "!</p>";
    });

    Route::get('/crearUsuario', function () {
        return view('registrarUsuario'); 
    });

    Route::post('/crearUsuario', [AuthController::class, 'registration']);
    
});
