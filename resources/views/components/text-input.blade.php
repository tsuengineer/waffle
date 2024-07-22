@props(['disabled' => false])

<input {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge([
    'class' => 'border-gray-700 focus:border-indigo-300 focus:ring-indigo-300 rounded-md shadow-sm bg-gray-900 text-white'
]) !!}>
