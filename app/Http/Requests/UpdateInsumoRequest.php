<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateInsumoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->rol_id === 1;
    }

    public function rules(): array
    {
        $id = $this->route('id');

        return [
            'nombre' => 'required|string|max:255|unique:insumos,nombre,'.$id,
            'unidad_medida' => 'required|string|max:50',
            'stock_minimo' => 'required|numeric|min:0',
            'proveedor_id' => 'nullable|integer',
        ];
    }
}
