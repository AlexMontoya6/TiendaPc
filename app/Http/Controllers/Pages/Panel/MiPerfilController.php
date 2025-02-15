<?php

namespace App\Http\Controllers\Pages\Panel;

use Laravel\Jetstream\Http\Controllers\Livewire\UserProfileController; // Heredamos el controlador de Jetstream
use Illuminate\Http\Request;

class MiPerfilController extends UserProfileController
{
    /**
     * Sobreescribimos el método `show` para personalizar la vista del perfil
     */
    public function show(Request $request) // Asegurar que el parámetro es compatible
    {
        return view('pages.panel.mi-perfil', [
            'request' => $request,
            'user' => $request->user(),
        ]);
    }
}
