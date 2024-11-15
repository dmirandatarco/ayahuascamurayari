<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetalleOperar extends Model
{
    use HasFactory;

    public $timestamps = false;
    
    protected $fillable = [
        'operar_id',
        'detalles_id',
        'horarecojo',
    ];

    public function detalle()
    {
        return $this->belongsTo("App\Models\Detalle",'detalles_id');
    }
}
