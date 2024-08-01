@extends('layouts.app')
@include('layouts.header')
@section('title'){{ config('app.name') }}@endsection

@section('content')
    <div class="pt-4 pb-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="pb-8">
                {{ Breadcrumbs::render('top.index') }}
            </div>

            <div class="mb-8 py-4 bg-zinc-900 overflow-hidden border border-zinc-800 sm:rounded">
                <div class="sm:pt-4 sm:pr-4 pt-8 px-4">
                    <h1 class="mb-2 text-xl text-zinc-200 font-bold">オセロ棋譜共有サイトへようこそ</h1>
                    <p class="text-zinc-400">
                        このサイトは、オセロの棋譜を投稿・共有するためのプラットフォームです。 オセロの戦略や戦術を深めましょう。
                    </p>
                    <p class="text-orange-500">
                        ※現在α版(開発初期段階にある試作段階)です。機能が不完全だったり、バグが含まれている可能性があります。
                    </p>
                </div>
            </div>

            <div class="mb-8 py-4 bg-zinc-900 overflow-hidden border border-zinc-800 sm:rounded">
                <div class="sm:grid sm:grid-cols-2 lg:grid-cols-3 gap-4 p-4">
                    <div class="p-4 mb-4 sm:mb-0 bg-zinc-800 rounded-lg text-zinc-200">
                        <h2 class="text-lg font-bold">新着棋譜</h2>
                        <ul class="mt-2">
                            <!-- 新着棋譜のリストを表示 -->
                            @foreach ($latestPosts ?? [] as $post)
                                <li class="mb-2 flex items-center">
                                    @if ($post->user?->avatars?->path)
                                        <img class="w-8 h-8 rounded-full my-auto sm:ml-0 ml-4" src="{{ asset('storage/' . config('image.avatar_path') . '/' . user_directory_path($post->user->id) . '/' . $post->user?->avatars?->path) }}" alt="アバター" />
                                    @else
                                        <img class="w-8 h-8 border rounded-full my-auto sm:ml-0 ml-4" src="{{ asset('images/default_user.png') }}" alt="アバター" />
                                    @endif
                                    <div class="ml-4">
                                        <a href="{{ route('posts.show', $post->ulid) }}" class="text-blue-400 hover:underline">{{ $post->title }}</a>
                                        <p class="text-zinc-400 text-xs">{{ $post->created_at->format('Y年n月j日') }}</p>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>

                    <div class="p-4 mb-4 sm:mb-0 bg-zinc-800 rounded-lg text-zinc-200">
                        <h2 class="text-lg font-bold">ランダムの棋譜</h2>
                        <ul class="mt-2">
                            <!-- ランダムの棋譜のリストを表示 -->
                            @foreach ($randomPosts ?? [] as $post)
                                <li class="mb-2 flex items-center">
                                    @if ($post->user?->avatars?->path)
                                        <img class="w-8 h-8 rounded-full my-auto sm:ml-0 ml-4" src="{{ asset('storage/' . config('image.avatar_path') . '/' . user_directory_path($post->user->id) . '/' . $post->user?->avatars?->path) }}" alt="アバター" />
                                    @else
                                        <img class="w-8 h-8 border rounded-full my-auto sm:ml-0 ml-4" src="{{ asset('images/default_user.png') }}" alt="アバター" />
                                    @endif
                                    <div class="ml-4">
                                        <a href="{{ route('posts.show', $post->ulid) }}" class="text-blue-400 hover:underline">{{ $post->title }}</a>
                                        <p class="text-zinc-400 text-xs">{{ $post->created_at->format('Y年n月j日') }}</p>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>

                    <div class="p-4 bg-zinc-800 rounded-lg text-zinc-200">
                        <h2 class="text-lg font-bold">新着のユーザー</h2>
                        <ul class="mt-2">
                            <!-- 新着のユーザーのリストを表示 -->
                            @foreach ($latestUsers ?? [] as $user)
                                <li class="mb-2 flex items-center">
                                    @if ($user?->avatars?->path)
                                        <img class="w-8 h-8 rounded-full my-auto sm:ml-0 ml-4" src="{{ asset('storage/' . config('image.avatar_path') . '/' . user_directory_path($user->id) . '/' . $user->avatars->path) }}" alt="アバター" />
                                    @else
                                        <img class="w-8 h-8 border rounded-full my-auto sm:ml-0 ml-4" src="{{ asset('images/default_user.png') }}" alt="アバター" />
                                    @endif
                                    <div class="ml-4">
                                        <a href="{{ route('users.show', $user->slug) }}" class="text-blue-400 hover:underline">{{ $user->name }}</a>
                                        <p class="text-zinc-400 text-sm">投稿数: {{ count($user->posts) }}</p>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>

            <div class="mb-8 py-4 bg-zinc-900 overflow-hidden border border-zinc-800 sm:rounded">
                <div class="p-4">
                    <h2 class="text-lg font-bold text-zinc-200">オセロの戦略と戦術について</h2>
                    <p class="text-zinc-400 mt-2">
                        オセロの基本的な戦略や高度な戦術について学びましょう。
                        以下のセクションでは、初心者から上級者まで役立つ情報を提供しています。
                    </p>
                    <ul class="list-disc list-inside mt-4 text-zinc-400">
                        <li><a href="#" class="text-blue-400 hover:underline">基本的な戦略</a></li>
                        <li><a href="#" class="text-blue-400 hover:underline">中盤の戦術</a></li>
                        <li><a href="#" class="text-blue-400 hover:underline">終盤の攻略法</a></li>
                        <li><a href="#" class="text-blue-400 hover:underline">実力者同士の試合の分析</a></li>
                    </ul>
                </div>
            </div>

            <div class="mb-8 py-4 bg-zinc-900 overflow-hidden border border-zinc-800 sm:rounded">
                <div class="p-4">
                    <h2 class="text-lg font-bold text-zinc-200">お問い合わせ</h2>
                    <p class="text-zinc-400 mt-2">
                        サイトに関する質問やフィードバックがありましたら、お気軽にお問い合わせください。
                    </p>
                    <p>
                        <a href="https://x.com/board_waffle" class="text-blue-400 hover:underline">
                            𝕏(@board_waffle)
                        </a>
                    </p>
                </div>
            </div>
        </div>
    </div>
@endsection
@include('layouts.footer')
