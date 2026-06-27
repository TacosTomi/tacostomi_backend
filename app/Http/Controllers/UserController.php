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
            abort(403, 'Alto ahi Chiavo! esta funcion es solo para Admins vrgs');
        }
        $usuarios = User::all(); 

        return view('usuarios', compact('usuarios'));
    }
}