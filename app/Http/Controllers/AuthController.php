<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{

    // -------- validation -----------

     public function loginWeb(Request $request)
    {
        $request->validate([
            'correo' => 'required|email', 
            'password' => 'required'
        ]);

        
        $user = User::where('correo', $request->correo)->first();

        if(!$user || !Hash::check($request->password, $user->password_hash))
        {
            return back()->withErrors(['error' => 'Credenciales incorrectas alv chiavo']);
        }

        Auth::login($user);
        $request->session()->regenerate(); // para seguridad

        return redirect('/admin');
    }


    // -------- creation of user ----------

    public function registration(Request $request)
    {
        if($request->user()->rol_id !== 1)
        {
            return back()->withErrors(['error' => 'Alto ahi chiavo. Solo admins pueden registrar']);
        }

        
        $request->validate([
            'nombre' => 'required|string',
            'correo' => 'required|email|unique:usuarios,correo',
            'password' => 'required|min:6',
            'rol_id' => 'required|integer'
        ]);

        User::create([
            'nombre' => $request->nombre,
            'correo' => $request->correo,
            'password_hash' => Hash::make($request->password),
            'rol_id' => $request->rol_id,
            'foto_perfil' => null
        ]);

        return redirect('/admin'); 
    }
   
}
