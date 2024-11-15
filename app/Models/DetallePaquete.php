<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetallePaquete extends Model
{
    use HasFactory;
    protected $fillable = [
        'paquete_id',
        'tour_id',
        'dia',
        'fecha',
        'precio',
        'observacion',
    ];

    public function tour()
    {
        return $this->belongsTo('App\Models\Tour');
    }
}
