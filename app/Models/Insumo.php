<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Insumo extends Model
{
    protected $table = 'insumos';
    public $timestamps = false;

    protected $fillable = [
        'nombre',
        'unidad_medida',
        'stock_actual',
        'stock_minimo',
        'proveedor_id',
    ];

    protected function casts(): array
    {
        return [
            'stock_actual' => 'decimal:3',
            'stock_minimo' => 'decimal:3',
        ];
    }

    public function platillos(): BelongsToMany
    {
        return $this->belongsToMany(Platillo::class, 'platillo_insumos', 'insumo_id', 'platillo_id')
            ->withPivot('cantidad_necesaria');
    }

    public function scopeBajoMinimo($query)
    {
        return $query->whereColumn('stock_actual', '<=', 'stock_minimo');
    }

    public function estaAgotado(): bool
    {
        return (float) $this->stock_actual <= 0;
    }

    public function estaBajoMinimo(): bool
    {
        return (float) $this->stock_actual <= (float) $this->stock_minimo;
    }

    public function estadoStock(): string
    {
        if ($this->estaAgotado()) {
            return 'agotado';
        }

        if ($this->estaBajoMinimo()) {
            return 'bajo';
        }

        return 'ok';
    }
}
