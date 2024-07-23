<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;
use App\Models\Noticia;
use App\Models\Role;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'population',
        'postal_code',
        'birthdate',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // método que recupera todas las motos relacionadas con el usuario
    // como la relación es 1 a N, usaremos el método hasMany()
    public function bikes()
    {
        return $this->hasMany(Noticia::class);
    }

    //recupera los roles del usuario
    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }

    //recupera los roles que no tiene el usuario
    public function remainingRoles(){
        $actualRoles = $this->roles;
        $allRoles = Role::all();

        //retorna todo los roles menos los que ya tiene el usuario
        return $allRoles->diff($actualRoles);
    }
    
    //método que indica si un usuario tiene un rol concreto
    //a partir del nombre del rol o array de roles (se aplica un OR)
    public function hasRole($roleNames):bool{
        //si solamente viene un rol, lo mete en un array
        if (!is_array($roleNames))
            $roleNames = [$roleNames];
        //recorre la lista de roles buscando...
        foreach ($this->roles as $role) {
            if(in_array($role->role, $roleNames))
                return true;
        }
        return false;
    }

    //método para saber si un usuario es propietario de una moto
    public function isOwner(Noticia $bike):bool{
        return $this->id == $bike->user_id;
    }
}
