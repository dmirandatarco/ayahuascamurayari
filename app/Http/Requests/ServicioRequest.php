<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ServicioRequest extends FormRequest
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
            $tipo='required|max:80|unique:servicios';
        }else{
            $tipo='required|max:80|unique:servicios,nombre,'.$this->id_servicio;
        }
        return [
            'nombre' => $tipo,
            'tipo_id' => 'required|exists:tipos,id'
        ];
    }
}
