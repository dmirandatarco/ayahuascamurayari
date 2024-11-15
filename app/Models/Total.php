<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Total extends Model
{
    use HasFactory;

    protected $fillable = [
        'reserva_id',
        'moneda_id',
        'acuenta',
        'saldo',
        'total',
    ];

    public function reserva()
    {
        return $this->belongsTo('App\Models\Reserva');
    }

    public function moneda() {
        return $this->belongsTo('App\Models\Moneda');
    }
}
