<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pedidos extends Model
{
    protected $table = 'pedidos';
    public $timestamps = false;


    protected $fillable = [
        'mesa_id',
        'cliente_id',
        'mesero_id',
        'estado',
        'total',
        'fecha_hora'
    ];

    public function mesa()
    {
        return $this->belongsTo(Mesa::class, 'mesa_id');
    }

    public function cliente()
    {
        return $this->belongsTo(User::class, 'cliente_id');
    }


    public function mesero()
    {
        return $this->belongsTo(User::class, 'mesero_id');
    }


    
}

