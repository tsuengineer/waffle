@extends('layouts.app')
@include('layouts.header')
@section('title')204｜{{ config('app.name') }}@endsection

@section('content')
    <div name="header">
        <h2 class="font-semibold text-xl text-zinc-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </div>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-zinc-900">
                    {{ __("You're logged in!") }}
                </div>
            </div>
        </div>
    </div>
@endsection
@include('layouts.footer')
