<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    // Campos permitidos para asignación masiva
    protected $fillable = [
        'identificacion',
        'nombre',
        'rol',
        'direccion',   // <--- NUEVO CAMPO
        'telefono',    // <--- NUEVO CAMPO
        'password',
    ];

    // Campos que se ocultan al serializar (ej. en JSON)
    protected $hidden = [
        'password',
        'remember_token',
    ];

    // Casts
    protected function casts(): array
    {
        return [
            'password' => 'hashed', // Laravel 10+ permite usar esto para hashear automáticamente
        ];
    }

    // Puedes agregar métodos adicionales si tenés roles, permisos, etc.
}
