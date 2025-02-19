<?php

namespace App\Http\Controllers\Panel;

use Laravel\Jetstream\Http\Controllers\Livewire\UserProfileController; // Heredamos el controlador de Jetstream
use Illuminate\Http\Request;

class MiPerfilController extends UserProfileController
{
    /**
     * Sobreescribimos el método `show` de UserProfileController de jetstream para personalizar la vista del perfil
     */
    public function show(Request $request)
    {
        return view('panel.mi-perfil', [
            'request' => $request,
            'user' => $request->user(),
        ]);
    }
}
