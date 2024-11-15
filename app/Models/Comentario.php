<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comentario extends Model
{
    use HasFactory;

    static $rules = [
        'nombre' => 'required|string|max:250',
        'email' => 'required|email',
        'calificacion' => 'required|max:1500',
        'comentario' => 'required',
    ];

    protected $fillable = [
        'nombre',
        'email',
        'calificacion',
        'comentario',
        'fecha',
        'estado',
    ];

    public function comentable()
    {
        return $this->morphTo();
    }

}
