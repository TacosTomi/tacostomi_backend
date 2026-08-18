<?php

namespace App\Exports;

use App\Models\Mesa;
use Illuminate\Support\Collection; 
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class MesasExport implements FromCollection, WithHeadings, WithMapping
{
    public function collection(): Collection 
    {
        return Mesa::with('mesero')->orderBy('numero_mesa', 'asc')->get();
    }

    public function headings(): array
    {
        return ['ID', 'Número de Mesa', 'Estado', 'Mesero Asignado', 'Posición X', 'Posición Y'];
    }

    public function map($mesa): array
    {
        return [
            $mesa->id,
            $mesa->numero_mesa,
            strtoupper($mesa->estado),
            $mesa->mesero ? $mesa->mesero->nombre : 'Sin asignar',
            $mesa->pos_x,
            $mesa->pos_y,
        ];
    }
}