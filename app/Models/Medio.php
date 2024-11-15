<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Medio extends Model
{
    use HasFactory;
    protected $fillable = [
        'nombre',
        'numero',
        'descripcion',
        'moneda_id',
    ];

    protected function nombre(): Attribute
    {
        return new Attribute(
            set: function($value){
                return mb_strtoupper($value);
            }
        );
    }

    public function moneda()
    {
        return $this->belongsTo('App\Models\Moneda');
    }
}
