@props(['active'])

@php
    $classes = ($active ?? false)
                ? 'block w-full ps-3 pe-4 py-2 border-l-4 border-indigo-600 text-start text-base font-medium text-indigo-300 bg-indigo-900 focus:outline-none focus:text-indigo-400 focus:bg-indigo-800 focus:border-indigo-400 transition duration-150 ease-in-out'
                : 'block w-full ps-3 pe-4 py-2 border-l-4 border-transparent text-start text-base font-medium text-zinc-300 hover:text-zinc-100 hover:bg-zinc-700 hover:border-zinc-500 focus:outline-none focus:text-zinc-100 focus:bg-zinc-700 focus:border-zinc-500 transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
