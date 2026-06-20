<?php

namespace App\Http\Controllers;

use App\Models\Role; // Importamos el modelo Role
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function index()
    {
        $roles = Role::all();
        
        return response()->json($roles);
    }
}


