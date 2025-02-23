<?php

namespace App\Http\Controllers\Panel;

use Illuminate\Http\Request; // Heredamos el controlador de Jetstream
use Laravel\Jetstream\Http\Controllers\Livewire\UserProfileController;

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
