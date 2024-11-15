<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Paquete extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'dia',
        'cantidad',
        'altura',
        'user_id',
        'moneda_id',
        'language_id',
        'total',
        'observacion',
        'titulo2',
        'descripcion',
        'recomendacion',
        'video',
        'mapa',
        'imgprincipal',
        'incluye',
        'noincluye',
        'tipo',
        'estado',
        'slug',
        'language_id',
        'web'
    ];

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function user()
    {
        return $this->belongsTo("App\Models\User");
    }

    public function moneda()
    {
        return $this->belongsTo("App\Models\Moneda");
    }

    public function detalles()
    {
        return  $this->hasMany('App\Models\DetallePaquete');
    }

    public function servicios()
    {
        return $this->belongsToMany('App\Models\Servicio')->withPivot('cantidad','precio');
    }

    public function comentarios()
    {
        return $this->morphMany(Comentario::class, 'comentable')->where('estado',1);
    }

    public function language()
    {
        return $this->belongsTo('App\Models\Language');
    }

    public function traducciones(){
        return $this->belongsToMany('App\Models\Paquete','translate','id_model','id_model_traducido')->wherePivot('table','paquetes');
    }

    public function traduccionesinversas(){
        return $this->belongsToMany('App\Models\Paquete','translate','id_model_traducido','id_model')->wherePivot('table','paquetes');
    }

    public function traduccion($id)
    {
        $traducir= $this->traducciones->firstWhere('language_id', $id);
        $traducir2=$this->traduccionesinversas->firstWhere('language_id', $id);
        if($traducir){
            return $traducir;
        }
        if($traducir2){
            return $traducir2;
        }
        return $this;
    }
}
