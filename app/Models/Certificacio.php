<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Certificacio extends Model
{
    use HasFactory;
    protected $fillable =
    [
        'user_id',
        'language_id',
        'titulo',
        'subtitulo',
        'estado',
    ];

    public function detalles()
    {
        return $this->hasMany(DetalleCertificado::class);
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
        return $this->belongsToMany('App\Models\Certificacio','translate','id_model','id_model_traducido')->wherePivot('table','certificacios');
    }

    public function traduccionesinversas(){
        return $this->belongsToMany('App\Models\Certificacio','translate','id_model_traducido','id_model')->wherePivot('table','certificacios');
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
