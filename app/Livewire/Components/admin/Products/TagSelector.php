<?php

namespace App\Livewire\Components\Admin\Products;

use Livewire\Component;
use App\Models\Tag;

class TagSelector extends Component
{
    public $tags = [];
    public $selectedTags = []; // 🔥 Contendrá las etiquetas seleccionadas en formato array

    public function mount()
    {
        $this->tags = Tag::all();
    }

    public function toggleTag($tagId)
    {
        if (isset($this->selectedTags[$tagId])) {
            unset($this->selectedTags[$tagId]);
        } else {
            $this->selectedTags[$tagId] = [
                'id' => $tagId,
                'is_active' => true,
                'ttl' => null,
            ];
        }
        $this->updateSelectedTags();
    }

    public function toggleActive($tagId)
    {
        if (isset($this->selectedTags[$tagId])) {
            $this->selectedTags[$tagId]['is_active'] = !$this->selectedTags[$tagId]['is_active'];
        }
        $this->updateSelectedTags();
    }

    public function setTTL($tagId, $value)
    {
        if (isset($this->selectedTags[$tagId])) {
            $this->selectedTags[$tagId]['ttl'] = $value;
        }
        $this->updateSelectedTags();
    }

    private function updateSelectedTags()
    {
        $this->selectedTags = array_values($this->selectedTags); // 🔥 Convertimos a array limpio para evitar errores
    }

    public function render()
    {
        return view('livewire.admin.products.tag-selector', [
            'tags' => $this->tags,
            'selectedTags' => $this->selectedTags
        ]);
    }
}
