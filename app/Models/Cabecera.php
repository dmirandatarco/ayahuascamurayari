<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Cabecera extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'user_id',
        'video',
        'language_id',
        'tipo',
    ];

    protected function video(): Attribute
    {
        return new Attribute(
            get: function($value){
                return env('URL_WEB').'/storage/img/cabecera/'.$value;
            }
        );
    }

    public function images()
    {
        return $this->morphMany(Image::class, 'imageable');
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
    public function language()
    {
        return $this->belongsTo('App\Models\Language');
    }

    public function traducciones(){
        return $this->belongsToMany('App\Models\Cabecera','translate','id_model','id_model_traducido')->wherePivot('table','cabeceras');
    }

    public function traduccionesinversas(){
        return $this->belongsToMany('App\Models\Cabecera','translate','id_model_traducido','id_model')->wherePivot('table','cabeceras');
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
