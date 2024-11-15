<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'language_id',
        'tipo',
    ];   

    public function detalles()
    {
        return $this->hasMany(MenuDetalle::class);
    }

    public function language()
    {
        return $this->belongsTo('App\Models\Language');
    }

    public function traducciones(){
        return $this->belongsToMany('App\Models\Menu','translate','id_model','id_model_traducido')->wherePivot('table','menus');
    }

    public function traduccionesinversas(){
        return $this->belongsToMany('App\Models\Menu','translate','id_model_traducido','id_model')->wherePivot('table','menus');
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
