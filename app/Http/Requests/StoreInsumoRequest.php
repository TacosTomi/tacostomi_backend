<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreInsumoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->rol_id === 1;
    }

    public function rules(): array
    {
        return [
            'nombre' => 'required|string|max:255|unique:insumos,nombre',
            'unidad_medida' => 'required|string|max:50',
            'stock_minimo' => 'required|numeric|min:0',
            'stock_inicial' => 'nullable|numeric|min:0',
            'proveedor_id' => 'nullable|integer',
        ];
    }
}
