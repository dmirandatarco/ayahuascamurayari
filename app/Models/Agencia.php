<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Agencia extends Model
{
    use HasFactory;

    static $rules = [
        'nombre' => 'required|max:200|unique:agencias',
        'tipo_documento' => 'nullable|max:15',
        'num_documento' => 'nullable|max:20',
        'celular' => 'nullable|max:20',
        'email' => 'nullable|email|max:150',
    ];
    protected $fillable = [
        'nombre',
        'tipo_documento',
        'num_documento',
        'celular',
        'email',
    ];

    protected function nombre(): Attribute
    {
        return new Attribute(
            set: function($value){
                return mb_strtoupper($value);
            }
        );
    }
}
