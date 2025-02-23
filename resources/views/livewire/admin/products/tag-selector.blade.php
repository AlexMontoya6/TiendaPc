<div>
    {{-- Input oculto para enviar las etiquetas seleccionadas en el formulario en un solo campo --}}
    <input type="hidden" name="tags" value="{{ json_encode($selectedTags) }}">

    {{-- Mostrar todas las etiquetas disponibles --}}
    <div class="flex gap-2">
        @foreach ($tags as $tag)
            <button type="button"
                class="px-2 py-1 text-sm font-semibold rounded border flex items-center justify-between gap-1
                        {{ isset($selectedTags[$tag->id]) ? '' : 'opacity-50' }}"
                style="background-color: {{ $tag->background_color }};
                       color: {{ $tag->text_color }};
                       border-color: {{ $tag->border_color }};"
                wire:click="toggleTag({{ $tag->id }})">
                {{ $tag->name }}
                <span class="ml-1 flex-shrink-0">{!! $tag->icon_svg !!}</span>
            </button>
        @endforeach
    </div>

    {{-- Opciones de etiquetas seleccionadas --}}
    @if (!empty($selectedTags))
        <div class="mt-4">
            <h3 class="font-semibold">Opciones de etiquetas seleccionadas:</h3>
            <div class="space-y-2">
                @foreach ($selectedTags as $tagId => $options)
                    <div class="flex items-center gap-4 border p-2 rounded-lg shadow-sm">

                        {{-- 🔥 Nueva forma de mostrar el nombre de la etiqueta evitando errores --}}
                        <span class="font-medium">
                            {{ optional(\App\Models\Tag::find($tagId))->name ?? 'Etiqueta no encontrada' }}
                        </span>

                        {{-- Toggle de Activación --}}
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" class="sr-only peer" wire:click="toggleActive({{ $tagId }})"
                                {{ $options['is_active'] ? 'checked' : '' }}>

                            {{-- Fondo del switch --}}
                            <div class="w-14 h-7 rounded-full transition-all duration-300 relative flex items-center"
                                style="background-color: {{ $options['is_active'] ? '#22c55e' : '#9ca3af' }};">

                                <span class="absolute text-xs font-bold text-white transition-all duration-300"
                                    style="left: {{ $options['is_active'] ? '8px' : '2px' }}; opacity: {{ $options['is_active'] ? '1' : '0' }};">
                                    ON
                                </span>
                                <span class="absolute text-xs font-bold text-white transition-all duration-300"
                                    style="right: 2px; opacity: {{ $options['is_active'] ? '0' : '1' }};">
                                    OFF
                                </span>

                                <div class="absolute top-0.5 w-6 h-6 bg-white rounded-full shadow-md transition-all duration-300"
                                    style="left: {{ $options['is_active'] ? 'calc(100% - 1.75rem)' : '0.5rem' }};">
                                </div>
                            </div>
                        </label>

                        {{-- Campo de Fecha TTL --}}
                        @if ($options['is_active'])
                            <input type="date" class="border p-1 rounded"
                                wire:model.defer="selectedTags.{{ $tagId }}.ttl"
                                wire:change="setTTL({{ $tagId }}, $event.target.value)">
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
    @endif
</div>
