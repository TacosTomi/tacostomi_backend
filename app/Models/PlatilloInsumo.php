<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PlatilloInsumo extends Model
{
    protected $table = 'platillo_insumos';
    public $timestamps = false;
    public $incrementing = false;

    protected $fillable = [
        'platillo_id',
        'insumo_id',
        'cantidad_necesaria',
    ];

    public function platillo(): BelongsTo
    {
        return $this->belongsTo(Platillo::class, 'platillo_id');
    }

    public function insumo(): BelongsTo
    {
        return $this->belongsTo(Insumo::class, 'insumo_id');
    }
}
