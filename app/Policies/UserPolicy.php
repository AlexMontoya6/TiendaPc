<?php

namespace App\Policies;

use App\Models\User;

class UserPolicy
{
    /**
     * Determina si el usuario puede ver la lista de usuarios.
     */
    public function viewAny(User $user)
    {
        return $user->hasPermissionTo('ver usuarios');
    }

    /**
     * Determina si el usuario puede ver un usuario específico.
     */
    public function view(User $user, User $targetUser)
    {
        return $user->hasPermissionTo('ver usuarios');
    }

    /**
     * Determina si el usuario puede crear usuarios.
     */
    public function create(User $user)
    {
        return $user->hasPermissionTo('crear usuarios');
    }

    /**
     * Determina si el usuario puede editar otro usuario.
     */
    public function update(User $user, User $targetUser)
    {
        return $user->hasPermissionTo('editar usuarios');
    }

    /**
     * Determina si el usuario puede eliminar otro usuario.
     */
    public function delete(User $user, User $targetUser)
    {
        return $user->hasPermissionTo('eliminar usuarios');
    }
}
