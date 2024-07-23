@props(['type'])

@if ($type === 'warning')
    <aside {!! $attributes->merge(['class' => 'flex items-start px-4 py-3 rounded-lg bg-yellow-100 text-gray-600 text-sm leading-loose']) !!}">
        <span class="flex items-center justify-center font-bold w-4 h-4 my-auto rounded-full bg-yellow-400 text-white">!</span>
        <div class="flex-1 ml-2 min-w-0">
            <p>{{ $slot }}</p>
        </div>
    </aside>
@elseif ($type === 'info')
    <aside {!! $attributes->merge(['class' => 'flex items-start px-4 py-3 rounded-lg bg-green-100 text-gray-600 text-sm leading-loose']) !!}">
        <span class="flex items-center justify-center font-bold w-4 h-4 my-auto rounded-full bg-green-400 text-white">!</span>
        <div class="flex-1 ml-2 min-w-0">
            <p>{{ $slot }}</p>
        </div>
    </aside>
@elseif ($type === 'error')
    <aside {!! $attributes->merge(['class' => 'flex items-start px-4 py-3 rounded-lg bg-red-100 text-gray-600 text-sm leading-loose']) !!}">
    <span class="flex items-center justify-center font-bold w-4 h-4 my-auto rounded-full bg-red-400 text-white">!</span>
    <div class="flex-1 ml-2 min-w-0">
        <p>{{ $slot }}</p>
    </div>
    </aside>
@endif
