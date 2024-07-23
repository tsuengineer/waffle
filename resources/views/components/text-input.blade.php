@props(['disabled' => false])

<input {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge([
    'class' => 'border-zinc-700 focus:border-indigo-300 focus:ring-indigo-300 rounded-md shadow-sm bg-zinc-900 text-white'
]) !!}>
