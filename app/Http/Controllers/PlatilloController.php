<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Platillo;
use App\Models\Categoria;

class PlatilloController extends Controller
{


    public function create()
    {
        if(auth()->user()->rol_id !== 1) {
            abort(403, 'Alto ahi chiavo! esta funcion es solo para Admins Vrgs');
        }

        $categorias = Categoria::all();

        return view('crear_platillo', compact('categorias'));
    }


    public function store(Request $request)
    {
        if(auth()->user()->rol_id !== 1) {
            abort(403, 'Alto ahi chiavo! esta funcion es solo para Admins Vrgs');
        }

        $request->validate([
            'nombre' => 'required|string',       
            'descripcion' => 'required|string',
            'precio'=> 'required|numeric',       //mieric es para numeros cond ecimlaes
            'activo'=> 'required|boolean',      
            'categoria_id'=> 'required|integer'
        ]);

        Platillo::create([
            'nombre' => $request->nombre,
            'descripcion' => $request->descripcion,
            'precio'=> $request->precio,
            'activo'=> $request->activo,
            'categoria_id'=> $request->categoria_id
        ]);

        return redirect('/admin');
    }

    public function verPlatillos(Request $request)
    {
        $categorias = Categoria::all();

        $query = Platillo::with('categoria');

        if ($request->filled('categoria_id')) 
        {
            $query->where('categoria_id', $request->categoria_id);
        }

        if ($request->filled('precio_max')) 
        {
            $query->where('precio', '<=', $request->precio_max);
        }

        $platillos = $query->get();

        return view('ver_platillos', compact('platillos', 'categorias'));
    }
}
