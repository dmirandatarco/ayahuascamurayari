<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class Tour extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'descripcion',
        'resumen',
        'imagenprincipal',
        'imagenmapa',
        'tamaño_grupo',
        'slug',
        'duracion',
        'unidad',
        'inicio',
        'incluye',
        'noincluye',
        'recomendaciones',
        'precio',
        'video',
        'precio_confidencial',
        'categoria_id',
        'entrada_id',
        'language_id',
        'voucher',
        'web',
        'destacado',
        'orden',
    ];

    // public function getRouteKeyName()
    // {
    //     return 'slug';
    // }

    protected function nombre(): Attribute
    {
        return new Attribute(
            set: function($value){
                return mb_strtoupper($value);
            }
        );
    }

    protected function imagenprincipal(): Attribute
    {
        return new Attribute(
            get: function($value){
                return env('URL_WEB').'/storage/img/tours/'.$value;
            }
        );
    }

    public function categoria()
    {
        return $this->belongsTo('App\Models\Categoria');
    }

    public function images()
    {
        return $this->morphMany(Image::class, 'imageable');
    }

    public function ubicaciones() {
        return $this->belongsToMany('App\Models\Ubicacion');
    }

    public function servicios() {
        return $this->belongsToMany('App\Models\Servicio')->where('tipo_id','!=',1)->where('tipo_id','!=',2)->where('tipo_id','!=',6)->where('tipo_id','!=',7);
    }

    public function serviciosentradas() {
        return $this->belongsToMany('App\Models\Servicio')->where('tipo_id','=',7);
    }

    public function operar()
    {
        return $this->belongsTo('App\Models\Operar');
    }

    public function entrada()
    {
        return $this->belongsTo('App\Models\Servicio','entrada_id','id');
    }

    public function itinerarios()
    {
        return $this->hasMany('App\Models\Itinerario');
    }


    public function language()
    {
        return $this->belongsTo('App\Models\Language');
    }

    public function traducciones(){
        return $this->belongsToMany('App\Models\Tour','translate','id_model','id_model_traducido')->wherePivot('table','tours');
    }

    public function traduccionesinversas(){
        return $this->belongsToMany('App\Models\Tour','translate','id_model_traducido','id_model')->wherePivot('table','tours');
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

    // para la web

    public function comentarios()
    {
        return $this->morphMany(Comentario::class, 'comentable')->where('estado',1);
    }

    public function ranking()
    {
        return $this->morphMany(Comentario::class, 'comentable')
        ->select( DB::raw( 'AVG( comentarios.calificacion ) as promedio' ),DB::raw( 'COUNT( comentarios.calificacion ) as total' ) )
        ->get();
    }

}
