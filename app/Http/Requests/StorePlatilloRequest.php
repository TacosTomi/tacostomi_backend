<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StorePlatilloRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'nombre' => 'required|string',       
            'descripcion' => 'required|string',
            'precio'=> 'required|numeric',    
            'activo'=> 'required|boolean',    
            'categoria_id'=> 'required|integer',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048'
    
        ];
    }

      public function messages()
    {
    return [
        'image.image' => 'Requerimientos de imágenes no encontrados: El archivo debe ser una imagen válida.',
        'image.mimes' => 'Requerimientos de imágenes no encontrados: Solo se aceptan formatos jpeg, png, jpg o webp.',
        'image.max'   => 'Requerimientos de imágenes no encontrados: La imagen es muy pesada (máximo 2MB).',
    ];
    }

}
