<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Operar extends Model
{
    use HasFactory;
    public $timestamps = false;
    
    protected $fillable = [
        'fecha',
        'cantidad',
        'observacion',
        'precio',
        'tour_id',
        'user_id',
        'monto_dar',
        'tipo',
    ];    

    public function tour()
    {
        return $this->belongsTo('App\Models\Tour');
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function proveedors(){
        return $this->belongsToMany('App\Models\Proveedor')->withPivot('monto');
    }

    public function detallesoperar(){
        return $this->hasMany('App\Models\DetalleOperar');
    }

}
