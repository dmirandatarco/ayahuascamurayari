<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Language extends Model
{
    use HasFactory;

    protected $fillable = [
        'abreviatura',
        'icono',
    ];

    protected function icono(): Attribute
    {
        return new Attribute(
            get: function($value){
                return env('URL_WEB').'/storage/img/idioma/'.$value;
            }
        );
    }
}
