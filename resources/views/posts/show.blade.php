@extends('layouts.app')
@include('layouts.header')
@section('title'){{ $post->title }}｜{{ config('app.name') }}@endsection

@section('content')
    <div class="pt-4 pb-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="px-2 mb-8">
            </div>

            <div class="flex justify-between items-center">
                <div class="font-semibold overflow-hidden truncate text-lg sm:text-2xl w-9/12 md:w-10/12">{{ $post->title }}</div>
                <a class="flex items-center justify-center w-28 py-1 my-1 mr-1 rounded-lg shadow-lg text-sm text-white bg-blue-500 hover:bg-blue-400"
                    <i class="fa-brands fa-twitter pr-2"></i>共有する
                </a>
            </div>

            <div class="border shadow-sm sm:rounded-lg">
                <div class="mt-4">
                    <div class="flex px-2 py-2 mb-4 bg-gray-100">
                        <div class="pl-2 pr-4">
                            <a class="flex" href="/profile/{{ $post->user->slug }}">
                                @if($post->user->avatars?->path)

                                @else
                                    <img class="w-8 h-8 rounded-full my-auto border" src="{{ asset('images/default_user.png') }}" alt="アバター"/>
                                @endif
                                <div class="flex items-center pl-1 min-w-0">
                                    <div class="overflow-hidden truncate font-bold">{{ $post->user->name }}</div>
                                </div>
                            </a>
                        </div>

                        <div class="flex items-center font-bold text-gray-600 whitespace-nowrap">
                            <span class="hidden sm:block">投稿日: </span>{{ $post->created_at->format('Y年n月j日') }}
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
@include('layouts.footer')
