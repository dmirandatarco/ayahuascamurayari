<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BlogRequest extends FormRequest
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
        if(request()->routeIs('blog.store')){
            $tipo='required|max:300|unique:blogs,titulo,NULL,id,language_id,'.$this->language_id;
            $imagen='required';
        }else{
            $tipo='required|max:300|unique:blogs,titulo,'.$this->blog->id.',id,language_id,'.$this->language_id;
            $imagen='nullable';
        }
        return [
            'titulo' => $tipo,
            'descripcioncorta' => 'required',
            'descripcionlarga' => 'required',
            'imagenprincipal' => $imagen,
        ];
    }
}
