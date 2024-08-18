@if ($paginator->hasPages())
    <nav role="navigation" aria-label="Pagination Navigation" class="flex text-sm sm:text-base">
        <div class="flex items-center border border-zinc-700 rounded-l-md px-2 py-1">
            @if ($paginator->onFirstPage())
                <span class="pagination-link disabled">
                    <i class="fa-solid fa-angle-left text-zinc-500"></i>
                </span>
            @else
                <a href="{{ $paginator->previousPageUrl() }}" class="pagination-link">
                    <i class="fa-solid fa-angle-left text-zinc-100"></i>
                </a>
            @endif
        </div>

        <div class="flex items-center">
            @foreach ($elements as $element)
                @if (is_string($element))
                    <span class="pagination-link disabled border border-zinc-700 px-2 py-1">
                        {{ $element }}
                    </span>
                @endif

                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <span class="pagination-link current font-bold text-zinc-200 bg-zinc-800 border border-zinc-700 px-2 py-1">
                                {{ $page }}
                            </span>
                        @else
                            <a href="{{ $url }}" class="pagination-link border border-zinc-700 px-2 py-1">
                                {{ $page }}
                            </a>
                        @endif
                    @endforeach
                @endif
            @endforeach
        </div>

        <div class="flex items-center border border-zinc-700 rounded-r-md px-2 py-1">
            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}" class="pagination-link">
                    <i class="fa-solid fa-angle-right text-zinc-100"></i>
                </a>
            @else
                <span class="pagination-link disabled">
                    <i class="fa-solid fa-angle-right text-zinc-500"></i>
                </span>
            @endif
        </div>
    </nav>
@endif
