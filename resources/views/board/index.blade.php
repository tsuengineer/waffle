@extends('layouts.app')
@include('layouts.header')
@section('title')棋譜ビューワー｜{{ config('app.name') }}@endsection

@section('content')
    <div class="pt-4 pb-12">
        <div x-data="{ showPreviewBoard: true }" class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-8">
                {{ Breadcrumbs::render('board.index') }}
            </div>

            {{-- トグルボタン --}}
            <label class="relative inline-flex items-center cursor-pointer mt-4">
                <input type="checkbox" x-model="showPreviewBoard" class="sr-only">
                <div x-bind:class="showPreviewBoard ? 'bg-gray-700' : 'bg-green-400'" class="w-11 h-6 rounded-full peer-focus:outline-none">
                    <div x-bind:class="showPreviewBoard ? 'translate-x-0' : 'translate-x-full'" class="absolute top-[2px] left-[2px] bg-white border-gray-300 border rounded-full h-5 w-5 transition-transform"></div>
                </div>
                <span class="ml-3 text-sm font-medium text-gray-300">作成モード</span>
            </label>

            <div class="md:flex md:space-x-4">
                <div id="board-area" class="w-full md:w-2/3">
                    <div class="mb-8">
                        <div>
                            <div x-show="!showPreviewBoard">
                                <x-edit-board initTurn="black"></x-edit-board>
                            </div>

                            <div x-show="showPreviewBoard">
                                <x-board initTurn="black" kifu="{{ request('kifu') }}" start="{{ request('start_move') ?? 0 }}" blackUserName="{{ request('black_user_name') }}" whiteUserName="{{ request('white_user_name') }}"></x-board>
                            </div>
                        </div>
                    </div>
                </div>

                <div id="board-relative-area" class="mt-8 md:mt-0 w-full md:w-1/3">
                    <div class="border border-zinc-800 bg-zinc-900 shadow-sm sm:rounded-lg">
                        <div x-show="!showPreviewBoard">
                            <div class="flex py-2 mb-4 bg-zinc-800">
                                <div class="pl-2 pr-4">
                                    共有する棋譜を作成
                                </div>
                            </div>

                            <div class="px-2 mb-8">
                                {{-- 棋譜を入力するテキストボックス --}}
                                <div class="mb-4">
                                    <label for="kifu" class="block text-sm font-medium text-zinc-300">棋譜</label>
                                    <input type="text" name="kifu" id="kifu" class="mt-1 block w-full rounded-md bg-zinc-800 border-zinc-700 text-zinc-300" value="{{ request('kifu') }}">
                                </div>

                                {{-- 開始手数を入力するテキストボックス --}}
                                <div class="mb-4">
                                    <label for="start_move" class="block text-sm font-medium text-zinc-300">開始手数 (0-60)</label>
                                    <input type="number" name="start_move" id="start_move" class="mt-1 block w-full rounded-md bg-zinc-800 border-zinc-700 text-zinc-300" min="0" max="60" value="{{ request('start_move') }}">
                                </div>

                                {{-- 黒番のユーザー名を入力するテキストボックス --}}
                                <div class="mb-4">
                                    <label for="black_user_name" class="block text-sm font-medium text-zinc-300">黒番のユーザー名</label>
                                    <input type="text" name="black_user_name" id="black_user_name" class="mt-1 block w-full rounded-md bg-zinc-800 border-zinc-700 text-zinc-300" value="{{ request('black_user_name') }}">
                                </div>

                                {{-- 白番のユーザー名を入力するテキストボックス --}}
                                <div class="mb-4">
                                    <label for="white_user_name" class="block text-sm font-medium text-zinc-300">白番のユーザー名</label>
                                    <input type="text" name="white_user_name" id="white_user_name" class="mt-1 block w-full rounded-md bg-zinc-800 border-zinc-700 text-zinc-300" value="{{ request('white_user_name') }}">
                                </div>

                                {{-- URL生成ボタン --}}
                                <div class="flex justify-between space-x-4">
                                    <button onclick="handleUrlGeneration()" class="w-full px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2">
                                        URL生成
                                    </button>

                                    {{-- クリアボタン --}}
                                    <button onclick="clearFields()" class="w-full px-4 py-2 ml-4 bg-zinc-600 text-white rounded-md hover:bg-zinc-700 focus:outline-none focus:ring-2 focus:ring-zinc-500 focus:ring-offset-2">
                                        クリア
                                    </button>
                                </div>
                                <p id="copyMessage" class="hidden mt-2 text-sm text-green-400 break-all"></p>
                                <a
                                    id="shareLink"
                                    class="flex items-center justify-center w-full py-2 my-4 mr-1 rounded shadow text-sm text-white bg-blue-500 hover:bg-blue-400"
                                    target="_blank"
                                    onclick="handleXShare()"
                                    href="#"
                                >
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" fill="#fff" class="w-4 h-4 mr-2">
                                        <path d="M389.2 48h70.6L305.6 224.2 487 464H345L233.7 318.6 106.5 464H35.8L200.7 275.5 26.8 48H172.4L272.9 180.9 389.2 48zM364.4 421.8h39.1L151.1 88h-42L364.4 421.8z"/>
                                    </svg>
                                    共有する
                                </a>
                            </div>
                        </div>

                        <div x-show="showPreviewBoard">
                            <div class="flex py-2 mb-4 bg-zinc-800">
                                <div class="pl-2 pr-4">
                                    共有する棋譜を作成
                                </div>
                            </div>

                            <div class="pl-2 mb-8 text-sm">
                                「作成モード」ONにすると表示されます
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@include('layouts.footer')

@push('scripts')
    <script>
        const appUrl = "{{ config('app.url') }}";

        function generateUrl() {
            const kifu = document.getElementById('kifu').value;
            const startMove = document.getElementById('start_move').value;
            const blackUserName = document.getElementById('black_user_name').value;
            const whiteUserName = document.getElementById('white_user_name').value;
            return `${appUrl}/board?kifu=${kifu}&start_move=${startMove}&black_user_name=${blackUserName}&white_user_name=${whiteUserName}`;
        }

        function generateUrl() {
            const kifu = encodeURIComponent(document.getElementById('kifu').value);
            const startMove = encodeURIComponent(document.getElementById('start_move').value);
            const blackUserName = encodeURIComponent(document.getElementById('black_user_name').value);
            const whiteUserName = encodeURIComponent(document.getElementById('white_user_name').value);
            return `${appUrl}/board?kifu=${kifu}&start_move=${startMove}&black_user_name=${blackUserName}&white_user_name=${whiteUserName}`;
        }

        function handleUrlGeneration() {
            const url = generateUrl();
            const hashtags = 'オセロ,わっふる';
            copyToClipboard(url);
            const shareLink = document.getElementById('shareLink');
            shareLink.href = `https://x.com/intent/tweet?${new URLSearchParams({ text: "棋譜を共有しました:\n" + url + "\n", hashtags: hashtags })}`;
        }

        function handleXShare() {
            const url = generateUrl();
            const hashtags = 'オセロ,わっふる';
            const shareLink = document.getElementById('shareLink');
            shareLink.href = `https://x.com/intent/tweet?${new URLSearchParams({ text: "棋譜を共有しました:\n" + url + "\n", hashtags: hashtags })}`;
            window.open(shareLink.href, '_blank');
        }

        function clearFields() {
            document.getElementById('kifu').value = '';
            document.getElementById('start_move').value = '';
            document.getElementById('black_user_name').value = '';
            document.getElementById('white_user_name').value = '';
        }
    </script>
@endpush
