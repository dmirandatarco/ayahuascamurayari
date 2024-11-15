<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TourRequest extends FormRequest
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
        if(request()->routeIs('tour.store')){
            $tipo='required|max:300|unique:tours,nombre,NULL,id,language_id,'.$this->language_id;
            $imagen='required';
        }else{
            $tipo='required|max:300|unique:tours,nombre,'.$this->tour->id.',id,language_id,'.$this->language_id;
            $imagen='nullable';
        }
        return [
            'nombre' => $tipo,
            'descripcion' => 'required',
            'resumen' => 'nullable|max:500',
            'imagenprincipal' => $imagen,
            'tamaño_grupo' => 'nullable|numeric',
            'duracion' => 'required|numeric',
            'unidad' => 'required|max:50',
            'inicio' => 'nullable|date_format:H:i',
            'incluye' => 'nullable',
            'noincluye' => 'nullable',
            'recomendaciones' => 'nullable',
            'precio' => 'required|numeric|regex:/^[\d]{0,7}(\.[\d]{1,2})?$/',
            'precio_confidencial' => 'nullable|numeric|regex:/^[\d]{0,7}(\.[\d]{1,2})?$/',
            'categoria_id' => 'required|exists:categorias,id',
            'ubicacion_id' => 'required',
            'entrada_id' => 'nullable',
        ];
    }
}
