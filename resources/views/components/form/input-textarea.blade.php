@props(['disabled' => false, 'value'])

<textarea {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => 'text-zinc-200 bg-zinc-900 border-zinc-800 focus:border-amber-500 focus:ring-amber-500 rounded-md shadow-sm resize-y']) !!} >{{$value}}</textarea>
