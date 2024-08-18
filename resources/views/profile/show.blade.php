@extends('layouts.app')
@include('layouts.header')
@section('title')マイページ｜{{ config('app.name') }}@endsection

@section('content')
    <div class="pt-4 pb-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-8">
                {{ Breadcrumbs::render('profile.show') }}
            </div>

            @if (session('success'))
                <x-text.aside type="info" class="mb-4 mx-2">
                    {{ session('success') }}
                </x-text.aside>
            @endif

            @if (session('error'))
                <x-text.aside type="error" class="mb-4 mx-2">
                    {{ session('error') }}
                </x-text.aside>
            @endif

            <div class="mb-8 py-4 bg-zinc-900 overflow-hidden border border-zinc-800 sm:rounded">
                <div class="sm:flex sm:grid sm:grid-cols-10">
                    <div class="sm:col-span-3 lg:col-span-2">
                        <div class="flex sm:justify-around justify-between pt-4 px-2">
                            @if ($user?->avatars?->path)
                                <img class="w-20 h-20 rounded-full m-auto" src="{{ asset('storage/' . config('image.avatar_path') . '/' . user_directory_path($user->id) . '/' . $user->avatars->path) }}" alt="アバター" />
                            @else
                                <img class="w-20 h-20 border rounded-full my-auto sm:ml-0 ml-4" src="{{ asset('images/default_user.png') }}" alt="アバター" />
                            @endif

                            @if ($user->id === Auth::user()?->id)
                                <div>
                                    <x-secondary-button class="hidden sm:block">
                                        <a href="{{ route('profile.edit') }}">編集</a>
                                    </x-secondary-button>
                                    <x-secondary-button class="block sm:hidden sm:mr-0 mr-2">
                                        <a href="{{ route('profile.edit') }}">プロフィールを編集</a>
                                    </x-secondary-button>
                                </div>
                            @endif
                        </div>

                        <div class="flex flex-col pl-4 py-4">
                            <div class="mb-1 text-lg font-semibold">
                                {!! $user->name !!}
                                @if (!empty($user->x_account))
                                    <span style="color: #1DA1F2;">
                                        <a href="https://twitter.com/{{ $user->x_account }}" target="_blank">
                                            <i class="fa-brands fa-twitter"></i>
                                        </a>
                                    </span>
                                @endif
                                @if (!empty($user->instagram_account))
                                    <span class="ml-1 px-1 text-white insta_button" style="background: linear-gradient(#5478f2 0%, #f23f79 60%, orange 100%);">
                                        <a href="https://www.instagram.com/{{ $user->instagram_account }}" target="_blank">
                                            <i class="fa-brands fa-instagram"></i>
                                        </a>
                                    </span>
                                @endif
                            </div>
                            <div class="text-sm text-zinc-400">&#x40;{!! $user->slug !!}</div>
                        </div>
                    </div>

                    <div class="sm:col-span-7 lg:col-span-8 sm:pt-4 sm:pr-4 pt-8 px-4">
                        <h2 class="mb-2 ml-2 text-sm text-zinc-200 font-bold">自己紹介</h2>
                        <div class="flex flex-col">
                            <div class="p-4 bg-zinc-950 rounded-lg">
                                @if($user->profile){!! nl2br(e($user->profile)) !!}@else<span class="text-zinc-400">未設定</span>@endif
                            </div>
                        </div>

                        <div class="flex flex-col py-4">
                            <div class="ml-2 text-sm text-zinc-400">
                                <i class="fa fa-calendar" aria-hidden="true"></i>
                                {!! $user->created_at->format('Y年n月j日') !!}から利用しています
                            </div>
                        </div>

                        <div class="flex my-2 py-4 bg-zinc-950 rounded-lg">
                            <div class="flex items-center">
                                <div class="pl-4 text-zinc-400 text-sm">投稿数:</div>
                                <div class="pl-2 font-semibold text-zinc-400">{!! count($user->posts) !!}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            @if (count($posts) !== 0)
                <h2 class="py-2 font-bold">投稿した棋譜</h2>
                <div class="bg-zinc-900 overflow-hidden border border-zinc-800 sm:rounded">
                    <div>
                        <div class="text-zinc-600">
                            <ul>
                                @foreach ($posts as $post)
                                    <li class="p-4 text-zinc-200 border-b border-zinc-800 flex justify-between items-center">
                                        <div>
                                            <div class="flex mb-2">
                                                <a href="{{ route('users.show', ['userSlug' => $post->user->slug]) }}" class="pr-2">
                                                    <div>
                                                        @if ($post->user?->avatars?->path)
                                                            <img class="w-8 h-8 rounded-full m-auto" src="{{ asset('storage/' . config('image.avatar_path') . '/' . user_directory_path($user->id) . '/' . $user->avatars->path) }}" alt="アバター" />
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
                                                @if (!empty($post->tags))
                                                    <div class="flex my-2">
                                                        @foreach ($post->tags as $tag)
                                                            <div class="mr-1 px-2 rounded bg-zinc-700 text-zinc-400 text-sm">
                                                                {{ $tag->name }}
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="flex">
                                            <div class="flex flex-col mx-1 w-12">
                                                <x-secondary-button
                                                    class="m-1 w-full text-center"
                                                    onclick="event.preventDefault(); document.getElementById('sort-up-form-{{ $post->ulid }}').submit();"
                                                >
                                                    ↑
                                                </x-secondary-button>
                                                <form id="sort-up-form-{{ $post->ulid }}"
                                                      action="{{ route('posts.move_up', ['ulid' => $post->ulid]) }}"
                                                      method="POST" style="display: none;">
                                                    @csrf
                                                    @method('PUT')
                                                </form>

                                                <x-secondary-button
                                                    class="m-1 w-full text-center"
                                                    onclick="event.preventDefault(); document.getElementById('sort-down-form-{{ $post->ulid }}').submit();"
                                                >
                                                    ↓
                                                </x-secondary-button>
                                                <form id="sort-down-form-{{ $post->ulid }}"
                                                      action="{{ route('posts.move_down', ['ulid' => $post->ulid]) }}"
                                                      method="POST" style="display: none;">
                                                    @csrf
                                                    @method('PUT')
                                                </form>
                                            </div>

                                            <div class="flex flex-col sm:flex-row mx-1 sm:w-36 w-16">
                                                <x-secondary-button class="m-1 w-full text-center">
                                                    <a href="{{ route('posts.edit', ['ulid' => $post->ulid]) }}">
                                                        編集
                                                    </a>
                                                </x-secondary-button>
                                                <form id="delete-form-{{ $post->ulid }}" action="{{ route('posts.destroy', ['ulid' => $post->ulid]) }}" method="POST" style="display: none;">
                                                    @csrf
                                                    @method('DELETE')
                                                </form>
                                                <x-danger-button class="m-1 w-full text-center delete-button" data-id="{{ $post->ulid }}">
                                                    削除
                                                </x-danger-button>
                                            </div>
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
            @endif
        </div>
    </div>
@endsection
@include('layouts.footer')

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const deleteButtons = document.querySelectorAll('.delete-button');

            deleteButtons.forEach(function(button) {
                button.addEventListener('click', function() {
                    const ulid = this.getAttribute('data-id');
                    const form = document.getElementById(`delete-form-${ulid}`);

                    if (form && confirm('本当に削除しますか？')) {
                        form.submit();
                    }
                });
            });
        });
    </script>
@endpush
