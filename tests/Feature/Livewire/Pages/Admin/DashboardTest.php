<?php

use App\Livewire\Pages\Admin\Dashboard;
use Livewire\Livewire;

it('se renderiza correctamente', function () {
    Livewire::test(Dashboard::class)
        ->assertStatus(200);
});
