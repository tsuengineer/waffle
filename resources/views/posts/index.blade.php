@extends('layouts.app')
@include('layouts.header')
@section('title')棋譜一覧｜{{ config('app.name') }}@endsection

@section('content')
    <div class="pt-4 pb-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-8">
                {{ Breadcrumbs::render('post.show') }}
            </div>

            <h2 class="py-2 font-bold">棋譜一覧</h2>
            <div class="bg-zinc-900 overflow-hidden border border-zinc-800 sm:rounded">
                <div>
                    <div class="text-zinc-600">
                        <ul>
                            @foreach ($posts as $post)
                                <li class="p-4 text-zinc-200 border-b border-zinc-800">
                                    <div class="flex mb-2">
                                        <a href="{{ route('users.show', ['userSlug' => $post->user->slug]) }}" class="pr-2">
                                            <div>
                                                @if ($post->user?->avatars?->path)
                                                    <img class="w-8 h-8 rounded-full m-auto" src="{{ asset('storage/' . config('image.avatar_path') . '/' . user_directory_path($post->user->id) . '/' . $post->user->avatars->path) }}" alt="アバター" />
                                                @else
                                                    <img class="w-8 h-8 border rounded-full my-auto sm:ml-0 ml-4" src="{{ asset('images/default_user.png') }}" alt="アバター" />
                                                @endif
                                            </div>
                                        </a>
                                        <div>
                                            <p>
                                                <a href="{{ route('users.show', ['userSlug' => $post->user->slug]) }}" class="text-sm">
                                                    &#x40;{{ $post->user->slug }}<span>({{ $post->user->name }})</span>
                                                </a>
                                            </p>
                                            <span class="text-xs text-zinc-400">
                                                    <time>{{ $post->user->created_at->format('Y年n月j日') }}</time>
                                                </span>
                                        </div>
                                    </div>
                                    <h2 class="text-lg py-2 font-bold">
                                        <a href="/posts/{{ $post->ulid }}">
                                            {{ $post->title }}
                                        </a>
                                    </h2>
                                    <div>
                                        <x-navigation.tags :tags="$post->tags"></x-navigation.tags>
                                    </div>
                                </li>
                            @endforeach
                        </ul>

                        <div class="flex justify-center py-4">
                            {{ $posts->appends(['page' => request()->query('page')])->onEachSide(1)->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@include('layouts.footer')
