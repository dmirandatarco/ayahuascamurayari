<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Liquidacion extends Model
{
    use HasFactory;

    protected $fillable = [
        'fecha',
        'tipo',
        'user_id',
        'proveedor_id',
        'acuenta',
        'monto',
        'observacion',
    ];

    public function proveedor()
    {
        return $this->belongsTo('App\Models\Proveedor');
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function detallesliquidacion(){
        return $this->hasMany('App\Models\DetalleLiquidacion');
    }
}
