<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MenuDetalle extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'menu_id',
        'categoria_id',
        'nombre',
        'url',
    ]; 

    public function categoria()
    {
        return $this->belongsTo(Categoria::class);
    }
}
