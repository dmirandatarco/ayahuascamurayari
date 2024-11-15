<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Nosotro extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'language_id',
        'image_principal',
        'image_secundaria',
        'titulo',
        'subtitulo',
        'descripcion',
        'descripcion1',
        'descripcion2',
        'descripcion3',
        'num_viajes',
        'num_clientes',
        'num_miembros',
        'num_reconocimientos',
        'estado',
    ];

    protected function imagePrincipal(): Attribute
    {
        return new Attribute(
            get: function($value){
                return url('/storage/img/nosotros/'.$value);
            }
        );
    }

    protected function imageSecundaria(): Attribute
    {
        return new Attribute(
            get: function($value){
                return url('/storage/img/nosotros/'.$value);
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
        return $this->belongsToMany('App\Models\Nosotro','translate','id_model','id_model_traducido')->wherePivot('table','nosotros');
    }

    public function traduccionesinversas(){
        return $this->belongsToMany('App\Models\Nosotro','translate','id_model_traducido','id_model')->wherePivot('table','nosotros');
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


