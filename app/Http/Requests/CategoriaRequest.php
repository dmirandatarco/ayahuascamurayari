<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CategoriaRequest extends FormRequest
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
            $tipo='required|max:150|unique:categorias,nombre,NULL,id,language_id,'.$this->language_id;
            $imagen='required';
        }elseif($this->tipoform=="editar"){
            $tipo='required|max:150|unique:categorias,nombre,'.$this->id_categoria.',id,language_id,'.$this->language_id;
            $imagen='nullable';
        }
        else{
            $tipo='required|max:150|unique:categorias,nombre,NULL,id,language_id,'.$this->language_id;
            $imagen='nullable';
        }
        return [
            'nombre' => $tipo,
            'slug' => 'nullable|max:200',
            'descripcion' => 'nullable',
            'imagen' => $imagen,
        ];
    }
}
