<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreMovimientoInsumoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->rol_id === 1;
    }

    public function rules(): array
    {
        return [
            'tipo' => 'required|string|in:ENTRADA,SALIDA',
            'cantidad' => 'required|numeric|gt:0',
        ];
    }
}
