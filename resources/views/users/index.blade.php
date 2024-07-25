@extends('layouts.app')
@include('layouts.header')
@section('title')ユーザー一覧｜{{ config('app.name') }}@endsection

@section('content')
    <div class="pt-4 pb-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-8">
                {{ Breadcrumbs::render('user.index') }}
            </div>

            <h2 class="py-2 font-bold">ユーザ一覧</h2>
            <div class="rounded border-l border-t border-r border-zinc-800 bg-zinc-900">
                <ul>
                    @foreach ($users as $user)
                        <li class="p-4 border-b border-zinc-800 text-zinc-200">
                            <div class="flex mb-2">
                                <a href="{{ route('users.show', ['userSlug' => $user->slug]) }}" class="pr-2">
                                    <div>
                                        @if ($user?->avatars?->path)
                                            <img class="w-8 h-8 rounded-full my-auto sm:ml-0 ml-4" src="{{ asset('storage/' . config('image.avatar_path') . '/' . user_directory_path($user->id) . '/' . $user->avatars->path) }}" alt="アバター" />
                                        @else
                                            <img class="w-8 h-8 border rounded-full my-auto sm:ml-0 ml-4" src="{{ asset('images/default_user.png') }}" alt="アバター" />
                                        @endif
                                    </div>
                                </a>
                                <div>
                                    <p>
                                        <a href="{{ route('users.show', ['userSlug' => $user->slug]) }}" class="text-sm">
                                            &#x40;{{ $user->slug }}<span>({{ $user->name }})</span>
                                        </a>
                                    </p>
                                    <span class="text-xs text-zinc-400">
                                        <time>{{ $user->created_at }}</time>
                                    </span>
                                </div>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
@endsection
@include('layouts.footer')
