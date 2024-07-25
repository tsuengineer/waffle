@props(['disabled' => false])

<input {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge([
    'class' => 'border-zinc-700 focus:border-amber-500 focus:ring-amber-500 rounded-md shadow-sm bg-zinc-900 text-white'
]) !!}>
