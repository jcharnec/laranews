<?php

// app/Models/User.php
namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

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

    // ✅ Relación correcta con noticias
    public function noticias()
    {
        return $this->hasMany(Noticia::class);
    }

    // Roles (igual que ya tenías)
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
        $roleNames = is_array($roleNames) ? $roleNames : [$roleNames];
        foreach ($this->roles as $role) {
            if (in_array($role->role, $roleNames)) return true;
        }
        return false;
    }

    // ✅ Si quieres mantener este helper, renómbralo
    public function isOwnerOf(Noticia $noticia): bool
    {
        return $this->id === $noticia->user_id;
    }
}
