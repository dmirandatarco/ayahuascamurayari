<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PasajeroRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        if($this->tipoform=="crear"){
            $tipo='required|max:255|unique:pasajeros';
        }else{
            $tipo='required|max:255|unique:pasajeros,nombre,'.$this->id_pasajero;
        }
        return [
            'nombre' => $tipo,
            'tipo_documento' => 'nullable|max:15',
            'num_documento' => 'nullable|max:20',
            'celular' => 'nullable|max:30',
            'email' => 'nullable|email|max:150',
            'pais_id' => 'required|exists:pais,id',
        ];
    }
}
