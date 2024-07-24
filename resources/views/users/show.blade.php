@extends('layouts.common')
@include('layouts.header')
@section('title')
    {{ $user->name }} さん｜{{ config('app.name') }}
@endsection

@if ($user?->avatars?->path)
@section('ogPath'){{ 'storage/' . config('image.avatar_path') . '/' . user_directory_path($user->id) . '/' . $user->avatars->path }}@endsection
@endif

@section('content')
    <div class="pt-4 pb-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="px-2 pb-8">
                {{ Breadcrumbs::render('profile.show', $user->slug) }}
            </div>

            <div class="flex items-center justify-end">
                <a
                    class="py-1 px-4 m-2 rounded-lg shadow text-xs sm:text-sm text-white bg-blue-500 hover:bg-blue-400"
                    href="https://twitter.com/intent/tweet?text={{ $user->name }}&amp;url=https://localhost/users/{{ $user->slug }}&amp;hashtags=わっふる"
                    rel="nofollow noopener"
                    target="_blank">
                    <i class="fa-brands fa-twitter pr-2"></i>ツイート
                </a>
            </div>
            <div class="mb-8 border shadow-sm sm:rounded-lg">
                <x-profile.summary-panel :user="$user" :favoriteCount="$favoriteCount"></x-profile.summary-panel>
            </div>

            <h1 class="px-2 font-bold">投稿した棋譜</h1>
            <ul class="flex grid lg:grid-cols-8 sm:grid-cols-5 grid-cols-4">
                @foreach ($posts as $post)
                    <li class="p-1">
                        <a href="/posts/{{ $post->ulid }}">
                            <img
                                class="shadow-md w-auto h-auto rounded-lg"
                                src="{{ asset('storage/' . config('image.post_path') . '/' . user_directory_path($user->id) . '/thumbnail/' . $post->ulid . '.webp') }}" />
                        </a>
                    </li>
                @endforeach
            </ul>
            {{ $posts->links() }}
        </div>
    </div>
@endsection
@include('layouts.footer')
