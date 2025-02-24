<?php

use App\Livewire\Components\Admin\Products\TagSelector;
use App\Models\Tag;
use Livewire\Livewire;

it('carga correctamente las etiquetas disponibles', function () {
    $tags = Tag::factory()->count(3)->sequence(
        ['name' => 'Tag1'],
        ['name' => 'Tag2'],
        ['name' => 'Tag3']
    )->createQuietly(); // Usamos `createQuietly()` para evitar restricciones únicas

    Livewire::test(TagSelector::class)
        ->assertSee('Tag1')
        ->assertSee('Tag2')
        ->assertSee('Tag3');
});
