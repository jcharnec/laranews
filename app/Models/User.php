<?php

// app/Models/User.php
namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

/**
 * @method bool hasRole(string|array $roleNames)
 */
class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'population',
        'postal_code',
        'birthdate',
        // 'imagen', // añade si gestionas avatar en BD
    ];

    protected $hidden = ['password', 'remember_token'];

    protected $casts = ['email_verified_at' => 'datetime'];

    /**
     * Summary of noticias
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function noticias()
    {
        return $this->hasMany(Noticia::class);
    }

    /**
     * Relación con roles.
     * Un usuario puede tener varios roles.
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }

    /**
     * Obtiene los roles restantes que no tiene el usuario.
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function remainingRoles()
    {
        $actualRoles = $this->roles;
        $allRoles = Role::all();
        return $allRoles->diff($actualRoles);
    }

    public function hasRole($roleNames): bool
    {
        $roleNames = is_array($roleNames) ? $roleNames : [$roleNames];
        foreach ($this->roles as $role) {
            if (in_array($role->role, $roleNames)) return true;
        }
        return false;
    }

    /**
     * Verifica si el usuario es el dueño de una noticia.
     * @param Noticia $noticia
     * @return bool
     */
    public function isOwnerOf(Noticia $noticia): bool
    {
        return $this->id === $noticia->user_id;
    }

    public function comentarios()
    {
        return $this->hasMany(\App\Models\Comentario::class);
    }

    /**
     * Obtiene la URL del avatar del usuario.
     * Si no tiene imagen, devuelve null.
     *
     * @return string|null
     */
    public function getAvatarUrlAttribute()
    {
        return $this->imagen
            ? asset('storage/images/users/' . $this->imagen)
            : null;
    }
}
