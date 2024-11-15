<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetalleLiquidacion extends Model
{
    use HasFactory;
    protected $fillable = [
        'liquidacion_id',
        'ejecutable_type',
        'ejecutable_id',
        'cantidad',
        'precio'
    ];

    public function ejecutable()
    {
        return $this->morphTo();
    }
}
