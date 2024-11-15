<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pago extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'moneda_id',
        'medio_id',
        'reserva_id',
        'fecha',
        'monto',
        'tarjeta',
        'operacion',
        'mensaje',
        'confirmado'
    ];

    public function reserva()
    {
        return $this->belongsTo('App\Models\Reserva');
    }

    public function medio()
    {
        return $this->belongsTo('App\Models\Medio');
    }

    public function moneda()
    {
        return $this->belongsTo('App\Models\Moneda');
    }
}
