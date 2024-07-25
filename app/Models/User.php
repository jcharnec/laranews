<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable, SoftDeletes;

    protected $fillable = [
        'name', 'email', 'password', 'imagen'
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function noticias()
    {
        return $this->hasMany(Noticia::class);
    }

    public function comentarios()
    {
        return $this->hasMany(Comentario::class);
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }

    public function remainingRoles()
    {
        $actualRoles = $this->roles;
        $allRoles = Role::all();

        return $allRoles->diff($actualRoles);
    }

    public function hasRole($roleNames): bool
    {
        if (!is_array($roleNames)) {
            $roleNames = [$roleNames];
        }

        foreach ($this->roles as $role) {
            if (in_array($role->role, $roleNames)) {
                return true;
            }
        }

        return false;
    }

    public function isOwner(Noticia $noticia): bool
    {
        return $this->id == $noticia->user_id;
    }
}
