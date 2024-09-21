@extends('layouts.app')
@include('layouts.header')
@section('title')
    @if (request()->routeIs('xot.random'))
        XOT初期盤面(ランダム)｜{{ config('app.name') }}
    @else
        {{ $post->title }}｜{{ config('app.name') }}
    @endif
@endsection

@section('content')
    <div class="pt-4 pb-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-8">
                @if (request()->routeIs('xot.random'))
                    {{ Breadcrumbs::render('xot.random') }}
                @else
                    {{ Breadcrumbs::render('post.show') }}
                @endif
            </div>

            <div class="md:flex md:space-x-4">
                <div id="board-area" class="w-full md:w-2/3">
                    @if ($post->user_id === Auth::user()?->id ?? '')
                        <x-secondary-button>
                            <a href="{{ route('posts.edit', ['ulid' => $post->ulid]) }}">棋譜情報を編集</a>
                        </x-secondary-button>
                    @endif
                    @if (request()->routeIs('xot.random'))
                        <a href="{{ request()->url() }}">
                            <x-secondary-button>
                                ページを更新
                            </x-secondary-button>
                        </a>
                    @endif
                    <div class="flex justify-between items-center">
                        <div class="font-semibold overflow-hidden truncate text-lg sm:text-2xl w-9/12 md:w-10/12">{{ $post->title }}</div>
                        @if (request()->routeIs('xot.random'))
                            <a
                                class="flex items-center justify-evenly w-24 py-1 my-1 mr-1 rounded shadow text-sm text-white bg-blue-500 hover:bg-blue-400"
                                target="_blank"
                                href="{{ 'https://x.com/intent/tweet?' . http_build_query(['text' => 'XOT初期盤面(ランダム)', 'url' => route('xot.random')]) }}"
                            >
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" fill="#fff" class="w-4 h-4">
                                    <path d="M389.2 48h70.6L305.6 224.2 487 464H345L233.7 318.6 106.5 464H35.8L200.7 275.5 26.8 48H172.4L272.9 180.9 389.2 48zM364.4 421.8h39.1L151.1 88h-42L364.4 421.8z"/>
                                </svg>
                                共有する
                            </a>
                        @else
                            <a
                                class="flex items-center justify-evenly w-24 py-1 my-1 mr-1 rounded shadow text-sm text-white bg-blue-500 hover:bg-blue-400"
                                target="_blank"
                                href="{{ 'https://x.com/intent/tweet?' . http_build_query(['text' => $post->title, 'url' => route('posts.show', ['ulid' => $post->ulid])]) }}"
                            >
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" fill="#fff" class="w-4 h-4">
                                    <path d="M389.2 48h70.6L305.6 224.2 487 464H345L233.7 318.6 106.5 464H35.8L200.7 275.5 26.8 48H172.4L272.9 180.9 389.2 48zM364.4 421.8h39.1L151.1 88h-42L364.4 421.8z"/>
                                </svg>
                                共有する
                            </a>
                        @endif
                    </div>

                    @if (!empty($post->tags))
                        <ul class="flex flex-wrap my-2">
                            @foreach ($post->tags as $tag)
                                <li class="mr-1 my-1 px-2 rounded bg-zinc-700 text-zinc-400 text-sm whitespace-nowrap">
                                    {{ $tag->name }}
                                </li>
                            @endforeach
                        </ul>
                    @endif

                    @if (!empty($post['begin_text']))
                        <div class="my-4 p-2 bg-zinc-900 text-zinc-300 text-sm">
                            {!! nl2br(e($post['begin_text'])) !!}
                        </div>
                    @endif
                    <div class="">
                        <x-board
                            kifu="{{ $post['kifu'] }}"
                            initTurn="{{ $post['init_turn'] }}"
                            start="{{ $post['start_move'] }}"
                            blackUserName="{{ $post['black_user_name'] }}"
                            whiteUserName="{{ $post['white_user_name'] }}"
                            comments="{{ $post->comments }}"
                        ></x-board>
                    </div>
                    @if (!empty($post['end_text']))
                        <div class="my-4 p-2 bg-zinc-900 text-zinc-300 text-sm">
                            {!! nl2br(e($post['end_text'])) !!}
                        </div>
                    @endif
                </div>

                <div id="board-relative-area" class="mt-8 md:mt-0 w-full md:w-1/3">
                    <div class="border border-zinc-800 bg-zinc-900 shadow-sm sm:rounded-lg">
                        <div class="flex py-2 mb-4 bg-zinc-800">
                            <div class="pl-2 pr-4">
                                <a class="flex" href="{{ route('users.show', ['userSlug' => $post->user->slug]) }}">
                                    @if($post->user->avatars?->path)
                                        <img class="w-8 h-8 rounded-full m-auto" src="{{ asset('storage/' . config('image.avatar_path') . '/' . user_directory_path($post->user->id) . '/' . $post->user->avatars->path) }}" alt="アバター" />
                                    @else
                                        <img class="w-8 h-8 rounded-full my-auto border" src="{{ asset('images/default_user.png') }}" alt="アバター"/>
                                    @endif
                                    <div class="flex items-center pl-1 min-w-0">
                                        <div class="overflow-hidden truncate font-bold">{{ $post->user->name }}</div>
                                    </div>
                                </a>
                            </div>

                            <div class="flex items-center text-sm md:text-xs font-bold text-zinc-400 whitespace-nowrap">
                                {{ $post->created_at->format('Y年n月j日') }}
                            </div>
                        </div>

                        {{-- 次と前の棋譜 --}}
                        <div class="flex flex-col py-2 text-zinc-200">
                            @if(!empty($prevPost))
                                <div class="flex py-2 mb-4 bg-zinc-800">
                                    <div class="pl-2 pr-4">
                                        前の棋譜
                                    </div>
                                </div>
                                <div class="pl-2 mb-4">
                                    <a href="{{ route('posts.show', ['ulid' => $prevPost->ulid]) }}" class="text-blue-400 hover:underline">
                                        <span class="truncate pl-1">{{ Str::limit($prevPost->title, 30) }}</span>
                                    </a>
                                </div>
                            @endif

                            @if(!empty($nextPost))
                                <div class="flex py-2 mb-4 bg-zinc-800">
                                    <div class="pl-2 pr-4">
                                        次の棋譜
                                    </div>
                                </div>
                                <div class="pl-2 mb-4">
                                    <a href="{{ route('posts.show', ['ulid' => $nextPost->ulid]) }}" class="text-blue-400 hover:underline">
                                        <span class="truncate pl-1">{{ Str::limit($nextPost->title, 30) }}</span>
                                    </a>
                                </div>
                            @endif
                        </div>

                        @if(!empty($recommendedPosts))
                            <div class="flex py-2 mb-4 bg-zinc-800 text-zinc-200">
                                <div class="pl-2 pr-4">
                                    おすすめの棋譜<span class="pl-2 text-xs">(同じタグを含む棋譜)</span>
                                </div>
                            </div>

                            <div class="pl-2 mb-8">
                                @foreach($recommendedPosts as $recommendedPost)
                                    <div class="mb-2">
                                        <a href="{{ route('posts.show', ['ulid' => $recommendedPost->ulid]) }}" class="text-blue-400 hover:underline">
                                            <span class="truncate pl-1">{{ Str::limit($recommendedPost->title, 30) }}</span>
                                        </a>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@include('layouts.footer')
