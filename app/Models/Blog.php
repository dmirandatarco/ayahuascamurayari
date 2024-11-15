<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    use HasFactory;

    protected $fillable = 
    [
        'imagenprincipal',
        'titulo',
        'slug',
        'fecha',
        'user_id',
        'descripcioncorta',
        'descripcionlarga',
        'language_id',
        'nosotros',
    ];

    protected function imagenprincipal(): Attribute
    {
        return new Attribute(
            get: function($value){
                return env('URL_WEB').'/storage/img/blog/'.$value;
            }
        );
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function images()
    {
        return $this->morphMany(Image::class, 'imageable');
    }

    public function language()
    {
        return $this->belongsTo('App\Models\Language');
    }

    public function traducciones(){
        return $this->belongsToMany('App\Models\Blog','translate','id_model','id_model_traducido')->wherePivot('table','blogs');
    }

    public function traduccionesinversas(){
        return $this->belongsToMany('App\Models\Blog','translate','id_model_traducido','id_model')->wherePivot('table','blogs');
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
