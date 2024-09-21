@extends('layouts.app')
@include('layouts.header')
@section('title')検索｜{{ config('app.name') }}@endsection

@section('content')
    <div class="pt-4 pb-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-8">
                {{ Breadcrumbs::render('search.index') }}
            </div>

            <div class="max-w-7xl mx-auto">
                <div class="my-2 p-2 bg-zinc-800 rounded-lg">
                    <h1 class="px-2 font-bold">検索条件</h1>
                    <form class="p-2" action="{{ route('search.index') }}" method="GET">
                        <div class="flex flex-col pb-2">
                            <label class="">キーワード:</label>
                            <x-text-input class=" p-1 border rounded-md" type="text" name="keyword" value="{{ $searchData['keyword'] ?? '' }}"></x-text-input>
                        </div>
                        <div class="flex flex-col pb-2">
                            <label>タグ:</label>
                            <x-text-input class="p-1 border rounded-md" type="text" name="tag" value="{{ $searchData['tag'] ?? '' }}"></x-text-input>
                        </div>
                        <div class="flex flex-col pb-2">
                            <label class="">表示順:</label>
                            <select class="p-1 border border-zinc-700 bg-zinc-900 focus:border-amber-500 focus:ring-amber-500 rounded-md" name="order">
                                <option value="desc" {{ ($searchData['order'] ?? '') !== 'asc' ? 'selected' : '' }}>新しい順</option>
                                <option value="asc" {{ ($searchData['order'] ?? '') === 'asc' ? 'selected' : '' }}>古い順</option>
                            </select>
                        </div>
                        <div class="pt-2">
                            <x-primary-button type="submit">
                                検索
                            </x-primary-button>
                        </div>
                    </form>
                </div>

                @if (count($posts) !== 0)
                    <div class="flex justify-center py-4">
                        {{ $posts->appends(['keyword' => $searchData['keyword'], 'tag' => $searchData['tag'], 'order' => $searchData['order']])->onEachSide(1)->links() }}
                    </div>
                    <div class="text-zinc-600">
                        <ul>
                            @foreach($posts as $post)
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
                    </div>
                    <div class="flex justify-center py-4">
                        {{ $posts->appends(['keyword' => $searchData['keyword'], 'tag' => $searchData['tag'], 'order' => $searchData['order']])->onEachSide(1)->links() }}
                    </div>
                @else
                    <p class="p-2">検索結果が0件でした。<br>キーワードを変えて検索してみてください。</p>
                    <div class="p-2">
                        <h1 class="mb-2 font-bold">検索</h1>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection

@include('layouts.footer')
