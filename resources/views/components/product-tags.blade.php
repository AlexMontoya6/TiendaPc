@if ($tags->isNotEmpty())
    <div class="flex gap-2">
        @foreach ($tags as $tag)
            <span class="px-2 py-1 text-sm font-semibold rounded border flex items-center justify-between gap-1"
                style="background-color: {{ $tag->background_color }};
                       color: {{ $tag->text_color }};
                       border-color: {{ $tag->border_color }};">
                {{ $tag->name }}
                <span class="ml-1 flex-shrink-0">{!! $tag->icon_svg !!}</span>
            </span>
        @endforeach
    </div>
@endif
