@extends('layouts.app')
@include('layouts.header')
@section('title'){{ config('app.name') }}@endsection

@section('content')
    <div class="pt-4 pb-12">
        <div  x-data="{ showPreviewBoard: true }" class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-8">
                {{ Breadcrumbs::render('board.index') }}
            </div>

            {{-- トグルボタン --}}
            <label class="relative inline-flex items-center cursor-pointer mt-4">
                <input type="checkbox" x-model="showPreviewBoard" class="sr-only">
                <div x-bind:class="showPreviewBoard ? 'bg-gray-700' : 'bg-green-400'" class="w-11 h-6 rounded-full peer-focus:outline-none">
                    <div x-bind:class="showPreviewBoard ? 'translate-x-0' : 'translate-x-full'" class="absolute top-[2px] left-[2px] bg-white border-gray-300 border rounded-full h-5 w-5 transition-transform"></div>
                </div>
                <span class="ml-3 text-sm font-medium text-gray-300">編集モード</span>
            </label>

            <div class="md:flex md:space-x-4">
                <div id="board-area" class="w-full md:w-2/3">
                    <div class="mb-8">
                        <div>
                            <div x-show="!showPreviewBoard">
                                <x-edit-board initTurn="black"></x-edit-board>
                            </div>

                            <div x-show="showPreviewBoard">
                                <x-board initTurn="black" kifu="{{ request('kifu') }}"></x-board>
                            </div>
                        </div>
                    </div>
                </div>

                <div id="board-relative-area" class="mt-8 md:mt-0 w-full md:w-1/3">
                    <div class="border border-zinc-800 bg-zinc-900 shadow-sm sm:rounded-lg">
                        <div x-show="!showPreviewBoard">
                            <div class="flex py-2 mb-4 bg-zinc-800">
                                <div class="pl-2 pr-4">
                                    共有する棋譜を編集
                                </div>
                            </div>

                            <div class="pl-2 mb-8">
                                {{-- 棋譜を入力するテキストボックス --}}
                                <div class="mb-4">
                                    <label for="kifu" class="block text-sm font-medium text-zinc-300">棋譜</label>
                                    <input type="text" name="kifu" id="kifu" class="mt-1 block w-full rounded-md bg-zinc-800 border-zinc-700 text-zinc-300" value="{{ request('kifu') }}">
                                </div>

                                {{-- 開始手数を入力するテキストボックス --}}
                                <div class="mb-4">
                                    <label for="start_move" class="block text-sm font-medium text-zinc-300">開始手数 (0-60)</label>
                                    <input type="number" name="start_move" id="start_move" class="mt-1 block w-full rounded-md bg-zinc-800 border-zinc-700 text-zinc-300" min="0" max="60">
                                </div>

                                {{-- 黒番のユーザー名を入力するテキストボックス --}}
                                <div class="mb-4">
                                    <label for="black_user_name" class="block text-sm font-medium text-zinc-300">黒番のユーザー名</label>
                                    <input type="text" name="black_user_name" id="black_user_name" class="mt-1 block w-full rounded-md bg-zinc-800 border-zinc-700 text-zinc-300">
                                </div>

                                {{-- 白番のユーザー名を入力するテキストボックス --}}
                                <div class="mb-4">
                                    <label for="white_user_name" class="block text-sm font-medium text-zinc-300">白番のユーザー名</label>
                                    <input type="text" name="white_user_name" id="white_user_name" class="mt-1 block w-full rounded-md bg-zinc-800 border-zinc-700 text-zinc-300">
                                </div>

                                {{-- URL生成ボタン --}}
                                <button onclick="generateAndCopyUrl()" class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2">
                                    URLをコピー
                                </button>
                                <p id="copyMessage" class="mt-2 text-sm text-green-400" style="display:none;">コピーしました</p>
                            </div>
                        </div>

                        <div x-show="showPreviewBoard">
                            <div class="flex py-2 mb-4 bg-zinc-800">
                                <div class="pl-2 pr-4">
                                    共有する棋譜を編集
                                </div>
                            </div>

                            <div class="pl-2 mb-8 text-sm">
                                「編集モード」ONにすると設定できます
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

        function generateAndCopyUrl() {
            const kifu = document.getElementById('kifu').value;
            const startMove = document.getElementById('start_move').value;
            const url = `${appUrl}/board?kifu=${kifu}&start_move=${startMove}`;

            // URLをクリップボードにコピー
            navigator.clipboard.writeText(url).then(() => {
                // 「コピーしました」というメッセージを表示
                const copyMessage = document.getElementById('copyMessage');
                copyMessage.style.display = 'block';

                // 2秒後にメッセージを非表示にする
                setTimeout(() => {
                    copyMessage.style.display = 'none';
                }, 2000);
            });
        }
    </script>
@endpush
