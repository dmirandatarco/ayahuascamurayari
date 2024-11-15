<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reserva extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'proveedor_id',
        'pasajero_id',
        'fecha',
        'tipo',
        'privado',
        'confirmado',
        'observacion',
    ];

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }


    public function detalles()
    {
        return  $this->hasMany('App\Models\Detalle');
    }

    public function sumadetalles()
    {
        return  $this->hasMany('App\Models\Detalle')->sum('detalles.precio');
    }

    public function totales()
    {
        return  $this->hasMany('App\Models\Total')->orderBy('moneda_id','asc');
    }

    public function pagos()
    {
        return  $this->hasMany('App\Models\Pago');
    }

    public function servicios() {
        return $this->belongsToMany('App\Models\Servicio')->withPivot('cantidad','precio_venta','precio_operacion','descripcion');
    }

    public function pasajero() {
        return $this->belongsTo('App\Models\Pasajero');

    }

    public function pasajeros() {
        return $this->belongsToMany('App\Models\Pasajero');

    }

    public function pdf()
    {
        return $this->hasOne('App\Models\Documento');
    }

    public function proveedor()
    {
        return $this->belongsTo('App\Models\Proveedor');
    }

}



