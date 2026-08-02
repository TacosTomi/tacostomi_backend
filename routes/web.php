<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\PlatilloController;
use App\Http\Controllers\MesaController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\HomeController;


route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/login', function (){return view('login');})->name('login');

Route::post('/login', [AuthController::class, 'loginWeb']);

//Route::get('/categories', [CategoriaController::class, 'index']);

Route::get('/platillos', [PlatilloController::class, 'verPlatillos']);


Route::middleware('auth')->group(function () //needed to be logged in para access estas rutas below
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

    Route::get('/roles', [RoleController::class, 'index']);
    Route::post('/crearUsuario', [AuthController::class, 'registration']);
    Route::get('/crearPlatillo', [PlatilloController::class, 'create']);
    Route::post('/crearPlatillo', [PlatilloController::class, 'store']);
    Route::get('/usuarios', [UserController::class, 'index']);

    Route::get('/platillosAdmin', [PlatilloController::class, 'verPlatillosAdmin']);
    Route::get('/editarPlatillo/{id}', [PlatilloController::class, 'vistaModificarPlatillo']);
    Route::post('editarPlatillo/{id}', [PlatilloController::class, 'modifcarPlatillos']);
    Route::delete('eliminarPlatillo/{id}', [PlatilloController::class, 'eliminarPlatillo']);

    Route::get('/crearMesa', [MesaController::class, 'createMesa']);
    Route::post('/crearMesa', [MesaController::class, 'storeMesa']);
    Route::get('/verMesas', [MesaController::class, 'verMesas']);
    Route::delete('/eliminarMesa/{id}', [MesaController::class, 'eliminarMesa']);
    Route::get('/editarMesa/{id}', [MesaController::class, 'editarMesa']);
    Route::post('/editarMesa/{id}', [MesaController::class, 'asignarMesero']);    
        

    ###################################### FIN RUTAS DE ADMIN ######################################


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


