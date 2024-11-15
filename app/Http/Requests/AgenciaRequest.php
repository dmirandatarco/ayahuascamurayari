<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AgenciaRequest extends FormRequest
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
            $tipo='required|max:200|unique:agencias';
        }else{
            $tipo='required|max:200|unique:agencias,nombre,'.$this->id_agencia;
        }
        return [
            'nombre' => $tipo,
            'tipo_documento' => 'nullable|max:15',
            'num_documento' => 'nullable|max:20',
            'celular' => 'nullable|max:20',
            'email' => 'nullable|email|max:150',
        ];
    }
}
