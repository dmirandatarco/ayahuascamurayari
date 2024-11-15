<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LanguageRequest extends FormRequest
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
            $tipo = 'required|max:4|unique:languages,abreviatura,'.$this->id_idioma;
            $imagen = 'required';
        } else {
            $tipo = 'required|max:4|unique:languages,abreviatura';
            $imagen = 'nullable';
        }
        return [
            'abreviatura' => $tipo,
            'icono' => $imagen,
        ];
    }
}
