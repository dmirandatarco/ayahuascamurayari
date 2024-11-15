<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Documento extends Model
{
    use HasFactory;

    protected $fillable = [
        'reserva_id',
        'rutapdf',
    ];

    public $timestamps = false;

    public function user()
    {
        return $this->belongsTo('App\Models\Reserva');
    }

}
