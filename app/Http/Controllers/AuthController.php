<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{

    // -------- validation -----------

    public function login(Request $request)
    {
        $request->validate([
            'correo' => 'required|email', 
            'password' => 'required'
        ]);

        $user = User::where('correo', $request->correo)->first();

        if(!$user || !Hash::check($request->password, $user->password_hash))
        {
            return response()->json([
                'message' => 'Wrong password alv chiavo'
            ], 401);
        }

        $token = $user->createToken('token_acceso')->plainTextToken;

        return response()->json([
            'message' => 'Login exitoso',
            'token' => $token,
            'user' => $user
        ]);
    }


    // -------- creation of user ----------

    public function registration(Request $request)
    {

        //rol 1 = admin. 
        if($request->user()->rol_id !== 1)
            {
                return response()->json([
                    'message' => 'Alto ahi chiavo. Solo admins pueden registrar'
                ], 403);
            }

        $request->validate([
            'nombre' => 'requiered|string',
            'correo' => 'requiered|email|unique:usuarios,correo',
            'password' => 'requiered|min:6',
            'rol_id' => 'requiered|integer'
        ]);

        $user = User::create([
            'nombre' => $request->nombre,
            'correo' => $request->correo,
            'password_hash' => Hash::make($request->password),
            'rol_id' => $request->rol_id,
            'foto_perfil' => null
        ]);

        return response()->json([
            'message' => 'Usuario chemo creado exitosamente',
            'token' => $token,
            'user' => $user
        ], 201); 
    }
}
