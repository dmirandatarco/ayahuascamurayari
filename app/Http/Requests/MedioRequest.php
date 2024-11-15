<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MedioRequest extends FormRequest
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
        if ($this->tipoform=="editar") {
            $tipo = 'required|max:150|unique:proveedors,nombre,'.$this->id_hotel.',id,servicio_id,'.$this->servicio_id;
        } else {
            $tipo = 'required|max:150|unique:proveedors,nombre,NULL,id,servicio_id,'.$this->servicio_id;
        }

        if($this->tipoform=="crear"){
            $tipo='required|max:150|unique:medios,nombre,NULL,id,moneda_id,'.$this->moneda_id;
        }else{
            $tipo='required|max:150|unique:medios,nombre,'.$this->id_medio.',id,moneda_id,'.$this->moneda_id;
        }
        return [
            'nombre' => $tipo,
            'numero' => 'nullable|max:20',
            'descripcion' => 'nullable|max:250',
            'moneda_id' => 'required|exists:monedas,id',
        ];
    }
}
