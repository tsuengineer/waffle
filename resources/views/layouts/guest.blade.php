@extends('layouts.app')
@include('layouts.header')
@section('title')@yield('title-guest')｜{{ config('app.name') }}@endsection

@section('content')
    <body class="font-sans text-zinc-100 antialiased">
    <div class="flex flex-col sm:justify-center items-center pt-6 sm:pt-0 pb-12">
        <div class="w-full sm:max-w-md mt-6 px-6 py-4 border border-zinc-700 shadow-md overflow-hidden sm:rounded-lg">
            {{ $slot }}
        </div>
    </div>
    </body>
@endsection
@include('layouts.footer')
