<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Override;

class StorePedidoRequest extends FormRequest
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


    protected function prepareForValidation()
    {
        $this->merge([
            'fecha_hora' => $this->fecha_hora ?? now()->toDateTimeString()
        ]);
    }

    public function rules(): array
    {
         return [
            'mesa_id' => 'required|integer',       
            'cliente_id' => 'required|integer',
            'mesero_id'=> 'required|integer',    
            'estado'=> 'required|string',    
            'total'=> 'required|numeric',
            'fecha_hora' => 'required|date'
    
        ];
       
    }


    

}
