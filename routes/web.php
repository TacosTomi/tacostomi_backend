<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\PlatilloController;


Route::get('/login', function () {
    return view('login'); 
})->name('login');

Route::post('/login', [AuthController::class, 'loginWeb']);
Route::get('/categories', [CategoriaController::class, 'index']);
Route::get('/platillos', [PlatilloController::class, 'verPlatillos']);


Route::middleware('auth')->group(function () //everything within needs to be logged in.
{
    
    ###################################### RUTAS DE ADMIN ######################################
    Route::get('/admin', function () 
    {
        return view('admin_home');
    });

    Route::get('/crearUsuario', function () 
    {
        return view('registrarUsuario'); 
    });

    Route::post('/crearUsuario', [AuthController::class, 'registration']);
    Route::get('/crearPlatillo', [PlatilloController::class, 'create']);
    Route::post('/crearPlatillo', [PlatilloController::class, 'store']);
    Route::get('/usuarios', [UserController::class, 'index']);
    Route::get('/editarPlatillo/{id}', [PlatilloController::class, 'vistaModificarPlatillo']);
    Route::post('editarPlatillo/{id}', [PlatilloController::class, 'modifcarPlatillos']);



    ###################################### RUTAS DE ADMIN ######################################


    ###################################### RUTAS DE MESERO ######################################
    Route::get('/mesasHome', function()
    {
        return view('mesero');
    });
    Route::get('/cocina', function()
    {
        return view('cocina');
    });

    Route::get('/logout', [AuthController::class, 'logoutWeb']);
});


