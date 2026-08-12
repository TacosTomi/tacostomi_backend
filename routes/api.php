<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\RoleController; 
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PlatilloController;
use App\Http\Controllers\Repositories\PedidoRepository;
use App\Http\Controllers\PedidosController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/categorias', [CategoriaController::class, 'index']);

//Route::get('/roles', [RoleController::class, 'index']);

Route::post('/login', [AuthController::class, 'login']);


Route::get('/platillos', [PlatilloController::class, 'indexApi']);

Route::get('/pedidos', [PedidosController::class, 'indexApi']);
Route::post('/crearPedido', [PedidosController::class, 'createApi']);
Route::get('/pedidos/cliente/{clienteId}', [PedidosController::class, 'obtenerPedidosPorCliente']);
Route::get('/pedidos/{id}', [PedidosController::class, 'show']);
Route::put('/pedidos/{id}', [PedidosController::class, 'update']);
Route::patch('/pedidos/{id}/estado', [PedidosController::class, 'updateEstado']);
Route::delete('/pedidos/{id}', [PedidosController::class, 'destroy']);


Route::middleware('auth:sanctum')->group(function() 
    {
        Route::get('/roles', [RoleController::class, 'index']);
        Route::post('/crearUsuario', [AuthController::class, 'registration']);
    });

Route::middleware('auth:sanctum')->group(function() 
    {
        Route::get('/roles', [RoleController::class, 'index']);
        Route::post('/crearUsuario', [AuthController::class, 'registrationApi']);
    });    



