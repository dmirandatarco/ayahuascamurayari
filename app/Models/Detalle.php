<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Detalle extends Model
{
    use HasFactory;
    protected $fillable = [
        'reserva_id',
        'tour_id',
        'hotel_id',
        'moneda_id',
        'fecha_viaje',
        'cantidad',
        'ingreso',
        'precio',
        'observacion',
    ];

    public function reserva()
    {
        return $this->belongsTo('App\Models\Reserva');
    }

    public function tour()
    {
        return $this->belongsTo('App\Models\Tour');
    }

    public function hotel()
    {
        return $this->belongsTo('App\Models\Proveedor','hotel_id','id');
    }

    public function moneda()
    {
        return $this->belongsTo('App\Models\Moneda');
    }
    public function operars(){
        return $this->belongsToMany('App\Models\Operar');
    }

}
