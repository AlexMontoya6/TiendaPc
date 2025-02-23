<?php

namespace App\Policies;

use App\Models\Product;
use App\Models\User;

class ProductPolicy
{
    /**
     * Determina si el usuario puede ver la lista de productos.
     */
    public function viewAny(User $user)
    {
        return $user->hasPermissionTo('ver productos');
    }

    /**
     * Determina si el usuario puede ver un producto específico.
     */
    public function view(User $user, Product $product)
    {
        return $user->hasPermissionTo('ver productos');
    }

    /**
     * Determina si el usuario puede crear productos.
     */
    public function create(User $user)
    {
        return $user->hasPermissionTo('crear productos');
    }

    /**
     * Determina si el usuario puede editar un producto.
     */
    public function update(User $user, Product $product)
    {
        return $user->hasPermissionTo('editar productos');
    }

    /**
     * Determina si el usuario puede eliminar un producto.
     */
    public function delete(User $user, Product $product)
    {
        return $user->hasPermissionTo('eliminar productos');
    }
}
