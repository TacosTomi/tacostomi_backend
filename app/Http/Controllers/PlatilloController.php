<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Platillo;
use App\Models\Categoria;


//for future: create a function that determines iof youre admin or weiatres. Thus, 
//just calling the function instead of just doing the if.



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

    public function vistaModificarPlatillo($id)
    {
        if(auth()->user()->rol_id !==1)
        {
            abort(402, 'Alto ahi chiavo! Esto es solo para admins VRGS');
        }

        $platillo = Platillo::findOrFail($id);
        $categorias = Categoria::all();

        return view('editar_platillo', compact('platillo', 'categorias'));
    }


    public function modifcarPlatillos(Request $request, $id)
    {
        if(auth()->user()->rol_id !==1)
        {
            abort(402, 'Alto ahi chiavo! Esto es solo para admins VRGS');
        }

        $request->validate([
            'nombre' => 'required|string',       
            'descripcion' => 'required|string',
            'precio'=> 'required|numeric',       
            'activo'=> 'required|boolean',      
            'categoria_id'=> 'required|integer'
        ]);

        $platillo = Platillo::findOrFail($id);

        $platillo->nombre = $request->nombre;
        $platillo->descripcion = $request->descripcion;
        $platillo->precio = $request->precio;
        $platillo->activo = $request->activo;
        $platillo->categoria_id = $request->categoria_id;

        //to save updated info in the db 
        $platillo->save();

        return redirect('/admin');
    }
}
