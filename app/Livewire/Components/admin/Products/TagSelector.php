<?php

namespace App\Livewire\Components\Admin\Products;

use Livewire\Component;
use App\Models\Tag;

class TagSelector extends Component
{
    public $tags = [];
    public $selectedTags = []; // 🔥 Contendrá las etiquetas seleccionadas en formato array

    public function mount($product = null)
    {
        $this->tags = Tag::all();

        // Si se está editando un producto, cargamos sus etiquetas
        if ($product) {
            foreach ($product->tags as $tag) {
                $this->selectedTags[$tag->id] = [
                    'id' => $tag->id,
                    'is_active' => $tag->pivot->is_active,
                    'ttl' => $tag->pivot->ttl,
                ];
            }
        }
    }


    public function toggleTag($tagId)
    {
        // 🔥 Verificamos que la etiqueta exista antes de modificarla
        $tag = Tag::find($tagId);
        if (!$tag) return;

        // ✅ Si la etiqueta ya está en el array, la eliminamos
        if (array_key_exists($tagId, $this->selectedTags)) {
            unset($this->selectedTags[$tagId]);
        } else {
            // ✅ Si no está en el array, la agregamos correctamente
            $this->selectedTags[$tagId] = [
                'id' => $tagId,
                'is_active' => true,
                'ttl' => null,
            ];
        }

        // 🔥 Actualizamos `selectedTags` limpiando el array
        $this->selectedTags = array_filter($this->selectedTags);
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
