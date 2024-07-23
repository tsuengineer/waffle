@props(['active'])

@php
    $classes = ($active ?? false)
                ? 'inline-flex items-center px-1 pt-1 border-b-2 border-indigo-600 text-sm font-medium leading-5 text-indigo-300 focus:outline-none focus:border-indigo-400 transition duration-150 ease-in-out'
                : 'inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm font-medium leading-5 text-zinc-300 hover:text-zinc-100 hover:border-zinc-500 focus:outline-none focus:text-zinc-100 focus:border-zinc-500 transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
