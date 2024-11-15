<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OperarProveedor extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = "operar_proveedor";
    protected $primaryKey = "id";

    public function proveedor()
    {
        return $this->belongsTo('App\Models\Proveedor');
    }

    public function operar()
    {
        return $this->belongsTo('App\Models\Operar');
    }

    public function servicio()
    {
        return $this->belongsTo('App\Models\Servicio');
    }
}
