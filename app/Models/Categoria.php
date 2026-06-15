<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    // 1. Le decimos a Laravel el nombre exacto de tu tabla en AWS
    protected $table = 'categorias';

    // 2. Si tu tabla de Postgres NO tiene columnas llamadas 'created_at' y 'updated_at',
    // debes poner esto en false para que Laravel no intente buscarlas y marque error.
    public $timestamps = false; 
}