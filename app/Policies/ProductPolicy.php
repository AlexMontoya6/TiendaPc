<?php

namespace App\Policies;

use App\Models\Product;
use App\Models\User;

class ProductPolicy
{

    public function create(User $user)
    {
        return $user->hasPermissionTo('crear productos');
    }

    public function update(User $user, Product $product)
    {
        return $user->hasPermissionTo('editar productos');
    }

    public function delete(User $user, Product $product)
    {
        return $user->hasPermissionTo('eliminar productos');
    }
}
