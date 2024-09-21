@props(['tags'])

@if (!empty($tags))
    <ul class="flex flex-wrap my-2">
        @foreach ($tags as $tag)
            <li class="mr-1 my-1 rounded bg-zinc-700 text-zinc-400 text-sm whitespace-nowrap">
                <a href="{{ route('search.index', ['tag' => $tag->name]) }}" class="px-2">
                    {{ $tag->name }}
                </a>
            </li>
        @endforeach
    </ul>
@endif
