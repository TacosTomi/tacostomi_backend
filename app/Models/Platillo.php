<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Platillo extends Model
{
    protected $table = 'platillos';
    public $timestamps = false;


    protected $fillable = [
        'nombre',
        'descripcion',
        'precio',
        'imagen_url',
        'activo',
        'categoria_id',
    ];

    public function categoria()
    {
        return $this->belongsTo(Categoria::class, 'categoria_id');
    }

    public function insumos()
    {
        return $this->belongsToMany(Insumo::class, 'platillo_insumos', 'platillo_id', 'insumo_id')
            ->withPivot('cantidad_necesaria');
    }

}
