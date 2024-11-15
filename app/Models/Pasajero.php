<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Pasajero extends Model
{
    use HasFactory;
    static $rules = [
        'nombre' => 'required|max:255|unique:pasajeros',
        'tipo_documento' => 'nullable|max:15',
        'num_documento' => 'nullable|max:20',
        'celular' => 'nullable|max:30',
        'email' => 'nullable|email|max:150',
        'pais_id' => 'required|exists:pais,id',
    ];
    protected $fillable = [
        'nombre',
        'tipo_documento',
        'num_documento',
        'celular',
        'email',
        'pais_id',
    ];

    public function pais()
    {
        return $this->belongsTo('App\Models\Pais');
    }

    protected function nombre(): Attribute
    {
        return new Attribute(
            set: function($value){
                return mb_strtoupper($value);
            }
        );
    }
}
