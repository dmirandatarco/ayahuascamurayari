<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Casts\Attribute;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

    static $rules = [
        'nombre' => 'required|max:50',
        'apellido' => 'required|max:150',
        'tipo_documento' => 'nullable|max:20',
        'num_documento' => 'nullable|max:20',
        'celular' => 'nullable|max:20',
        'email' => 'nullable|email|max:150',
        'cumpleaños' => 'nullable|date',
        'usuario' => 'required|max:191|unique:users',
        'password' => 'required|max:191',
        'imagen' => 'nullable|max:300',
        'idrol' => 'required|exists:roles,id'
    ];

    protected $fillable = [
        'nombre',
        'apellido',
        'tipo_documento',
        'num_documento',
        'celular',
        'email',
        'email',
        'usuario',
        'password',
        'imagen',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
    ];

    protected function nombre(): Attribute
    {
        return new Attribute(
            set: function($value){
                return mb_strtoupper($value);
            }
        );
    }

    protected function apellido(): Attribute
    {
        return new Attribute(
            set: function($value){
                return mb_strtoupper($value);
            }
        );
    }

    protected function cumpleaños(): Attribute
    {
        return new Attribute(
            get: fn($value)=> date("d-m-Y",strtotime($value)),
        );
    }
    
    public function reservas()
    {
        return $this->hasMany(Reserva::class);
    }

    public function paquetes()
    {
        return $this->hasMany(Paquete::class);
    }

}
