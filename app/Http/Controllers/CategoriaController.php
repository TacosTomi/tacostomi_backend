<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use Illuminate\Http\Request;

class CategoriaController extends Controller
{
    // Esta es la función 'index' que Laravel está buscando
    public function index()
    {
        $categorias = Categoria::all();
        
        return response()->json($categorias);
    }
}

