<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use HasFactory, Notifiable;

    // Campos que pueden ser asignados masivamente
    protected $fillable = [
        'name', 'email', 'password','rol',
    ];

    /**
     * Obtener el identificador JWT del usuario.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();  // Retorna el ID del usuario
    }

    /**
     * Obtener los reclamos personalizados para el JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        // Puedes agregar información extra aquí si lo necesitas en tu JWT
        return [];
    }

    /**
     * Hashear la contraseña antes de guardar el usuario en la base de datos.
     */
    public static function boot()
    {
        parent::boot();

        static::creating(function ($user) {
            if (isset($user->password)) {
                $user->password = bcrypt($user->password);
            }
        });
    }
}
