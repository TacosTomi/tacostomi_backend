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
        if(auth()->user()->rol_id != 1)
        {
            abort(403, 'Alto ahi Chiavo! esta funcion es solo para Admins vrgs');
        }
        
        return view('admin_home');
    });

    Route::get('/logout', [AuthController::class, 'logoutWeb']);


    Route::get('/crearUsuario', function ()                                                     // vista para agregar usuarios
    {
        return view('registrarUsuario'); 
    });

    //Route::get('/roles', [RoleController::class, 'index']);                                   //Test
    Route::post('/crearUsuario', [AuthController::class, 'registration']);                      // crear usuarios
    Route::get('/usuarios', [UserController::class, 'index']);                                  // muestra usuarios
    Route::get('/editarUsuario/{id}', [UserController::class, 'vistaModificarUsuario']);        // muestra front de editar usuario
    Route::post('/editarUsuario/{id}', [UserController::class, 'modificarUsuario']);            // edita usuario
    Route::delete('/eliminarUsuario/{id}', [UserController::class, 'eliminarUsuario']);         // elimina usuario

    Route::get('/crearPlatillo', [PlatilloController::class, 'create']);                        // crear platillos
    Route::post('/crearPlatillo', [PlatilloController::class, 'store']);                        // almacena el platillo creado en la db
    Route::get('/platillosAdmin', [PlatilloController::class, 'verPlatillosAdmin']);            // menu vista administrador
    Route::get('/editarPlatillo/{id}', [PlatilloController::class, 'vistaModificarPlatillo']);  // edita platillo desde menu vista admin
    Route::post('editarPlatillo/{id}', [PlatilloController::class, 'modifcarPlatillos']);       // sube a db platillo editado desde menu vista admin
    Route::delete('eliminarPlatillo/{id}', [PlatilloController::class, 'eliminarPlatillo']);    // elimina platillo desde menu admin

    Route::get('/mapaAdmin', [MesaController::class, 'mapaAdmin']);                             // ver las mesas desde mapa
    Route::post('/guardarCoordenadas', [MesaController::class, 'guardarCoordenadas']);          // almacena las coordenadas de mesas
    Route::get('/descargarExcelMapa', [MesaController::class, 'descargarExcelMapa']);           // descarga mapa en excel fromato

    Route::get('/crearMesa', [MesaController::class, 'createMesa']);                            // crea una mesa
    Route::post('/crearMesa', [MesaController::class, 'storeMesa']);                            // sube a db mesa creada
    Route::get('/verMesas', [MesaController::class, 'verMesas']);                               // muestra mesas con meseros asignados
    Route::delete('/eliminarMesa/{id}', [MesaController::class, 'eliminarMesa']);               // elimina mesa con meseros asignados
    Route::get('/editarMesa/{id}', [MesaController::class, 'editarMesa']);                      // edita 
    Route::post('/editarMesa/{id}', [MesaController::class, 'asignarMesero']);    
        

    ###################################### FIN RUTAS DE ADMIN ######################################






    ###################################### RUTAS DE MESERO ######################################

    Route::get('/mesasHome', [App\Http\Controllers\MesaController::class, 'mapaMesero'])->middleware('auth');


    ###################################### FIN RUTAS DE MESERO ##################################






    ###################################### RUTAS DE COCINA ######################################


    Route::get('/cocina', function()
    {
        return view('cocina');
    });

    ###################################### FIN RUTAS DE COCINA ##################################


});


