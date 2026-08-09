<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\RoleController; 
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PlatilloController;
use App\Http\Controllers\Repositories\PedidoRepository;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/categorias', [CategoriaController::class, 'index']);

//Route::get('/roles', [RoleController::class, 'index']);

Route::post('/login', [AuthController::class, 'login']);


Route::get('/platillos', [PlatilloController::class, 'index']);
Route::get('/pedidos', [PedidoRepository::class, 'index']);
Route::post('/crearPedido', [PedidoRepository::class, 'create']);

Route::middleware('auth:sanctum')->group(function() 
    {
        Route::get('/roles', [RoleController::class, 'index']);
        Route::post('/crearUsuario', [AuthController::class, 'registration']);
    });
