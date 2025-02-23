<?php

namespace App\Livewire\Partials;

use Livewire\Component;

class AdminSidebar extends Component
{
    public $collapsed = false; // Por defecto, está expandido

    public function toggleSidebar()
    {
        $this->collapsed = ! $this->collapsed;
    }

    public function render()
    {
        return view('livewire.partials.admin-sidebar', [
            'collapsed' => $this->collapsed,
        ]);
    }
}
