<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Image extends Model
{
    use HasFactory;

    protected $fillable = [
        'url_link',
        'nombre',
    ];

    public function imageable()
    {
        return $this->morphTo();
    }

    public function getNombreAttribute($value)
    {
        $prefix = '';
        if ($this->imageable_type === 'App\Models\Tour') {
            $prefix = 'tours';
        } elseif ($this->imageable_type === 'App\Models\Nosotro') {
            $prefix = 'nosotros';
        }
        elseif ($this->imageable_type === 'App\Models\Categoria') {
            $prefix = 'categorias';
        }elseif ($this->imageable_type === 'App\Models\Ubicacion') {
            $prefix = 'ubicaciones';
        }elseif ($this->imageable_type === 'App\Models\Certificacio') {
            $prefix = 'certificados';
        }
        elseif ($this->imageable_type === 'App\Models\Cabecera') {
            $prefix = 'cabecera';
        }
        elseif ($this->imageable_type === 'App\Models\Blog') {
            $prefix = 'blog';
        }

        return url('/storage/img/' . $prefix . '/' . $value);
    }
}
