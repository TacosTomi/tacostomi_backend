<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        if(auth()->user()->rol_id !== 1)
        {
            abort(403, 'Alto ahí Chiavo! Esta función es solo para Admins.');
        }
        $usuarios = User::where('rol_id', '!=', 5)->get(); 

        return view('usuarios', compact('usuarios'));
    }

    public function vistaModificarUsuario($id)
    {
        if(auth()->user()->rol_id !== 1) {
            abort(403, 'Alto ahí chiavo! Esto es solo para admins.');
        }

        $user = User::findOrFail($id);

        return view('editarUsuario', compact('user'));
    }

    public function modificarUsuario(Request $request, $id) 
    {
        if(auth()->user()->rol_id !== 1)
        {
            abort(403, 'Alto ahí chiavo! Esto es solo para admins.');
        }

        $user = User::findOrFail($id); 
        $user->nombre = $request->nombre;
        $user->correo = $request->correo;
        $user->rol_id = $request->rol_id;

        $user->save();
        return redirect('/usuarios');
    }

    public function eliminarUsuario($id)
    {
        if (auth()->user()->rol_id !== 1)
        {
            abort(403, 'Alto ahí chiavo! Esto es solo para admins.');
        }

        $user = User::findOrFail($id);
        $user->delete(); 

        return redirect('/usuarios');
    }
}