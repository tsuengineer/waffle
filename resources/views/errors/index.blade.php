@extends('layouts.app')
@include('layouts.header')
@section('title')エラーページ｜{{ config('app.name') }}@endsection

@section('content')
    <div class="pt-4 pb-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-8">
                {{ Breadcrumbs::render('error.index') }}
            </div>
            <div class="mb-8">
                @yield('message')
            </div>

            <x-primary-button>
                <a href="{{ empty($url) ? route('top.index') : $url }}">
                    戻る
                </a>
            </x-primary-button>
        </div>
    </div>
@endsection
@include('layouts.footer')
