<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Mesa;
use App\Models\User;
use App\Http\Controllers\UserController;



class MesaController extends Controller
{
    public function createMesa()
    {
        if(auth()->user()->rol_id !== 1) 
        {
            abort(403, 'Alto ahi chiavo! esta funcion es solo para Admins Vrgs');
        }

        $meseros = User::where('rol_id', 3)->get(); 
        return view('crear_mesa', compact('meseros'));
    }

    public function storeMesa(Request $require)
    {
        if(auth()->user()->rol_id !== 1) 
        {
            abort(403, 'Alto ahi chiavo! esta funcion es solo para Admins Vrgs');
        }

        $require->validate([
            'numero_mesa' => 'required|integer|unique:mesas,numero_mesa',
            'estado' => 'required|string|in:disponible,ocupada,reservada',
            'mesero_id' => 'nullable|integer|exists:usuarios,id',
        ]);

        Mesa::create([
            'numero_mesa' => $require->numero_mesa,
            'estado' => $require->estado,
            'mesero_id' => $require->mesero_id,
        ]);


        return redirect('/admin')->with('success', 'Mesa creada exitosamente.');
    }


    public function verMesas()
    {
        $mesas = Mesa::with('mesero')->orderBy('numero_mesa', 'asc')->get(); 
        return view('ver_mesas', compact('mesas')); 
    }

    public function eliminarMesa($id)
    {
        if(auth()->user()->rol_id !== 1) 
        {
            abort(403, 'Alto ahi chiavo! esta funcion es solo para Admins Vrgs');
        }

        $mesa = Mesa::findOrFail($id);
        $mesa->delete();

        return redirect('/verMesas')->with('success', 'Mesa eliminada exitosamente.');
    }

    public function asignarMesero(Request $request, $id)
    {
        if(auth()->user()->rol_id !== 1) 
        {
            abort(403, 'Alto ahi chiavo! esta funcion es solo para Admins Vrgs');
        }

        $request->validate([
            'mesero_id' => 'required|integer|exists:usuarios,id',
            'estado' => 'required|string|in:disponible,ocupada,reservada',
        ]);

        $mesa = Mesa::findOrFail($id);
        $mesa->mesero_id = $request->mesero_id;
        $mesa ->estado = $request->estado;
        $mesa->save();

        return redirect('/verMesas')->with('success', 'Mesero asignado exitosamente.');
    }  

    public function editarMesa($id)
    {
        if(auth()->user()->rol_id !== 1) 
        {
            abort(403, 'Alto ahi chiavo! esta funcion es solo para Admins Vrgs');
        }

        $mesa = Mesa::findOrFail($id);
        $meseros = User::where('rol_id', 3)->get(); 
        
        return view('editar_mesa', compact('mesa', 'meseros'));
    }
}
