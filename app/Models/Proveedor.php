<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Proveedor extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'celular',
        'direccion',
        'precio',
        'servicio_id',
    ];

    protected function nombre(): Attribute
    {
        return new Attribute(
            set: function($value){
                return mb_strtoupper($value);
            }
        );
    }

    public function servicio()
    {
        return $this->belongsTo('App\Models\Tipo');
    }
    public function operars(){
        return $this->belongsToMany('App\Models\Operar');
    }
    
}
