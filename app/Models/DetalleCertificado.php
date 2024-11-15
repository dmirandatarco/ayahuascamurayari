<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class DetalleCertificado extends Model
{
    use HasFactory;

    protected $fillable =
    [
        'certificacio_id',
        'url',
        'urlabrir',
    ];

    protected function url(): Attribute
    {
        return new Attribute(
            get: function($value){
                return url('/storage/img/certificados/'.$value);
            }
        );
    }

    protected function urlabrir(): Attribute
    {
        return new Attribute(
            get: function($value){
                return url('/storage/img/certificados/'.$value);
            }
        );
    }
}
