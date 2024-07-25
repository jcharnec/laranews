<?php

namespace App\Policies;

use App\Models\Noticia;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class NoticiaPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Noticia  $noticia
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, Noticia $noticia)
    {
        return true;
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        // Solo permite crear noticias a los usuarios con el rol de 'redactor' y con correo verificado
        return $user->hasRole(['redactor', 'administrador']) && $user->hasVerifiedEmail();
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Noticia  $noticia
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, Noticia $noticia)
    {
        // Permitir la actualización si el usuario es propietario o tiene el rol de administrador y tiene correo verificado
        return $user->isOwner($noticia) && $user->hasVerifiedEmail();
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Noticia  $noticia
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, Noticia $noticia)
    {
        // Permitir la eliminación si el usuario es propietario o tiene el rol de administrador o editor y tiene correo verificado
        return ($user->isOwner($noticia) 
            || $user->hasRole(['editor'])) && $user->hasVerifiedEmail();
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Noticia  $noticia
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, Noticia $noticia)
    {
        // Permitir la restauración si el usuario es propietario o tiene el rol de administrador o editor y tiene correo verificado
        return ($user->isOwner($noticia) 
            || $user->hasRole(['administrador', 'editor'])) && $user->hasVerifiedEmail();
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Noticia  $noticia
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, Noticia $noticia)
    {
        // Permitir la eliminación permanente si el usuario tiene el rol de administrador y tiene correo verificado
        return $user->hasRole('administrador') && $user->hasVerifiedEmail();
    }
}
