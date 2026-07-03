<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Mesa extends Model
{
    protected $table = 'mesas';
    public $timestamps = false;

    protected $fillable = [
        'numero_mesa',
        'estado',
        'mesero_id',
    ];

    public function mesero()
    {
        return $this->belongsTo(User::class, 'mesero_id');
    }

}
