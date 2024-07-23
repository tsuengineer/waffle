<nav class="p-4 text-sm font-medium bg-zinc-900 border border-zinc-800" aria-label="breadcrumb">
    <ol class="list-none p-0 inline-flex">
        @foreach ($breadcrumbs as $breadcrumb)
            <li class="flex items-center">
                @if (!is_null($breadcrumb->url) && !$loop->last)
                    <a href="{{ $breadcrumb->url }}" class="text-zinc-300 hover:text-zinc-500 font-bold">
                        {{ $breadcrumb->title }}
                    </a>
                    <i class="fa-solid fa-angle-right text-zinc-500 mx-2"></i>
                @elseif($loop->first)
                    <span class="text-zinc-200">
                        {{ $breadcrumb->title }}
                    </span>
                @else
                    <span class="text-zinc-200">
                        {{ $breadcrumb->title }}
                    </span>
                @endif
            </li>
        @endforeach
    </ol>
</nav>
