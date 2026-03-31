<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Alumno extends Authenticatable
{
    use Notifiable;

    protected $table = 'alumnos';

    protected $fillable = [
        'nombre',
        'apellido_paterno',
        'apellido_materno',
        'numero_cuenta',
        'rol',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];
}
