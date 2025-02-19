@if ($paginator->hasPages())
    <nav role="navigation" aria-label="Pagination Navigation" class="flex justify-center mt-4">
        <ul class="flex items-center gap-1 text-sm">
            {{-- Anterior --}}
            @if ($paginator->onFirstPage())
                <li class="px-3 py-1.5 text-gray-400 bg-gray-100 rounded-md cursor-not-allowed">
                    ←
                </li>
            @else
                <li>
                    <a href="{{ $paginator->previousPageUrl() }}" rel="prev"
                        class="px-3 py-1.5 text-gray-700 rounded-md hover:bg-purple-200 transition">
                        ←
                    </a>
                </li>
            @endif

            {{-- Números de Página --}}
            @foreach ($elements as $element)
                @if (is_string($element))
                    <li class="px-3 py-1.5 text-gray-500">{{ $element }}</li>
                @endif

                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li class="px-3 py-1.5 text-white bg-purple-600 rounded-md font-semibold">
                                {{ $page }}
                            </li>
                        @else
                            <li>
                                <a href="{{ $url }}"
                                    class="px-3 py-1.5 text-gray-700 rounded-md hover:bg-purple-200 transition">
                                    {{ $page }}
                                </a>
                            </li>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Siguiente --}}
            @if ($paginator->hasMorePages())
                <li>
                    <a href="{{ $paginator->nextPageUrl() }}" rel="next"
                        class="px-3 py-1.5 text-gray-700 rounded-md hover:bg-purple-200 transition">
                        →
                    </a>
                </li>
            @else
                <li class="px-3 py-1.5 text-gray-400 bg-gray-100 rounded-md cursor-not-allowed">
                    →
                </li>
            @endif
        </ul>
    </nav>
@endif
