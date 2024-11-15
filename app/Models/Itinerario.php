<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Itinerario extends Model
{
    use HasFactory;

    protected $fillable = [
        'titulo',
        'descripcion',
        'tour_id',
    ];

    public function Tour()
    {
        return $this->belongsTo('App\Models\Tour');
    }

    public function traducciones(){
        return $this->belongsToMany('App\Models\Itinerario','translate','id_model','id_model_traducido')->wherePivot('table','itinerarios');
    }

    public function traduccionesinversas(){
        return $this->belongsToMany('App\Models\Itinerario','translate','id_model_traducido','id_model')->wherePivot('table','itinerarios');
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
