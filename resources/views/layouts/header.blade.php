@section('header')
    <nav x-data="{ open: false }" class="text-white border-b border-zinc-700">
        <!-- Primary Navigation Menu -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex w-full">
                    <!-- Logo -->
                    <div class="shrink-0 flex items-center">
                        <a href="{{ route('top.index') }}" class="flex items-center">
                            <p class="pl-2 font-bold">棋譜Viewer(α版)</p>
                        </a>
                    </div>

                    <!-- Search -->
                    <div class="w-full hidden sm:flex sm:-my-px ml-6">
                        <!-- Add search component if needed -->
                    </div>
                </div>

                <!-- Settings Dropdown -->
                <div class="hidden sm:flex sm:items-center sm:ml-6">
                    @auth
                        <div class="pr-2 whitespace-nowrap">
                            <a href="{{ route('posts.create') }}">
                                <x-primary-button>
                                    棋譜を投稿
                                </x-primary-button>
                            </a>
                        </div>
                        <x-dropdown align="right">
                            <x-slot name="trigger">
                                <button class="inline-flex items-center px-3 py-2 w-16 border border-transparent text-sm leading-4 rounded-md text-zinc-500 hover:text-zinc-300 focus:outline-none transition ease-in-out duration-150">
                                    @if(Auth::user()->avatars?->path)
                                        <img class="w-9 h-9 rounded-full my-auto" src="{{ asset('storage/' . config('image.avatar_path') . '/' . user_directory_path(Auth::user()->id) . '/' . Auth::user()->avatars->path) }}" alt="アバター" />
                                    @else
                                        <div class="w-8 h-8 rounded-full my-auto">
                                            <img class="w-8 h-8 rounded-full m-auto" src="{{ asset('images/default_user.png') }}" alt="アバター" />
                                        </div>
                                    @endif
                                </button>
                            </x-slot>

                            <x-slot name="content">
                                <x-dropdown-link :href="route('users.index')" :active="request()->routeIs('dashboard')">
                                    マイページ
                                </x-dropdown-link>
                                <x-dropdown-link :href="route('profile.edit')">
                                    プロフィール編集
                                </x-dropdown-link>

                                <!-- Authentication -->
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf

                                    <x-dropdown-link :href="route('logout')"
                                                     onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                        ログアウト
                                    </x-dropdown-link>
                                </form>
                            </x-slot>
                        </x-dropdown>
                    @else
                        <div class="w-36">
                            <a href="{{ route('login') }}" class="text-sm text-zinc-300 underline">ログイン</a>

                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="ml-4 text-sm text-zinc-300 underline">新規登録</a>
                            @endif
                        </div>
                    @endauth
                </div>

                <!-- Hamburger -->
                <div class="-mr-2 flex items-center">
                    <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-zinc-400 hover:text-zinc-500 hover:bg-zinc-700 focus:outline-none focus:bg-zinc-700 focus:text-zinc-500 transition duration-150 ease-in-out" aria-label="ハンバーガーメニュー">
                        <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                            <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                            <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Responsive Navigation Menu -->
        <div class="hidden" :class="{'block': open, 'hidden': ! open}">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 pt-2 pb-3 space-y-1 bg-zinc-800">
                @auth
                    <x-responsive-nav-link :href="route('top.index')" :active="request()->routeIs('top.index')">
                        トップ
                    </x-responsive-nav-link>
                    <x-responsive-nav-link class="block sm:hidden" :href="route('posts.create')" :active="request()->routeIs('posts.create')">
                        棋譜を投稿
                    </x-responsive-nav-link>
                @else
                    <x-responsive-nav-link :href="route('top.index')" :active="request()->routeIs('top.index')">
                        トップ
                    </x-responsive-nav-link>
                @endauth
            </div>

            <!-- Responsive Settings Options -->
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 pt-4 pb-1 border-t border-zinc-700 bg-zinc-800">
                @auth
                    <div class="mt-1 space-y-1">
                        <x-responsive-nav-link :href="route('users.index')" :active="request()->routeIs('users.index')">
                            マイページ
                        </x-responsive-nav-link>
                        <x-responsive-nav-link :href="route('profile.edit')" :active="request()->routeIs('profile.edit')">
                            プロフィール編集
                        </x-responsive-nav-link>

                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <x-responsive-nav-link :href="route('logout')"
                                                   onclick="event.preventDefault();
                                            this.closest('form').submit();">
                                ログアウト
                            </x-responsive-nav-link>
                        </form>
                    </div>
                @else
                    <div class="mt-1 space-y-1">
                        <x-responsive-nav-link :href="route('login')" :active="request()->routeIs('login')">
                            ログイン
                        </x-responsive-nav-link>
                        <x-responsive-nav-link :href="route('register')" :active="request()->routeIs('register')">
                            新規登録
                        </x-responsive-nav-link>
                    </div>
                @endauth
            </div>
        </div>
    </nav>
@endsection
