@extends('layouts.app')
@include('layouts.header')
@section('title')棋譜投稿｜{{ config('app.name') }}@endsection

@section('content')
    <div class="pt-4 pb-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-8">
                {{ Breadcrumbs::render('post.create') }}
            </div>

            @if (count($errors) > 0)
                <x-text.aside type="error" class="mb-4 mx-2 sm:mx-0">
                    入力内容に誤りがあります。エラーメッセージを確認してください。
                </x-text.aside>
            @endif

            <form id="postUpload" method="POST" action="{{ route('posts.store') }}"  class="px-2 sm:px-0">
                @csrf

                <div class="grid sm:grid-cols-2 grid-cols-1 grid-auto-rows gap-4 pb-6">
                    <div>
                        <x-input-label for="title" value="タイトル" />
                        <x-text-input id="title" name="title" type="text" class="mt-1 block w-full" :value="old('title')" placeholder="今日の詰めオセロ" maxlength="100" autocomplete="title" />
                        <x-input-error class="mt-2" :messages="$errors->get('title')" />
                    </div>

                    <div>
                        <x-input-label for="initBoard" value="初期盤面" />
                        <x-text-input id="initBoard" name="initBoard" type="text" class="mt-1 block w-full" :value="old('initBoard')" placeholder="-OOO----X-XO-O---XOOO-X-OOXOXX--OOOXXXX-OOXXXXX-O-XOOX---X-OO-X-" autocomplete="initBoard" />
                        <x-input-error class="mt-2" :messages="$errors->get('initBoard')" />
                    </div>

                    <div>
                        <x-input-label for="kifu" value="棋譜" />
                        <x-text-input id="kifu" name="kifu" type="text" class="mt-1 block w-full" :value="old('kifu')" placeholder="F5D6C3D3C4F4F6F3" autocomplete="kifu" />
                        <x-input-error class="mt-2" :messages="$errors->get('kifu')" />
                    </div>

                    <div>
                        <x-input-label for="initTurn" value="1手目の手番" />
                        <select id="initTurn" name="initTurn" class="mt-1 block w-full bg-zinc-900 text-white border-zinc-700 focus:border-amber-500 focus:ring-amber-500 rounded-md shadow-sm">
                            <option value="black" {{ old('initTurn') === 'black' ? 'selected' : '' }}>黒番</option>
                            <option value="white" {{ old('initTurn') === 'white' ? 'selected' : '' }}>白番</option>
                        </select>
                        <x-input-error class="mt-2" :messages="$errors->get('initTurn')" />
                    </div>

                    <div>
                        <x-input-label for="blackUserName" value="黒番ユーザ名" />
                        <x-text-input id="blackUserName" name="blackUserName" type="text" class="mt-1 block w-full" :value="old('blackUserName')" placeholder="user1" maxlength="20" autocomplete="blackUserName" />
                        <x-input-error class="mt-2" :messages="$errors->get('blackUserName')" />
                    </div>

                    <div>
                        <x-input-label for="whiteUserName" value="白番ユーザ名" />
                        <x-text-input id="whiteUserName" name="whiteUserName" type="text" class="mt-1 block w-full" :value="old('whiteUserName')" placeholder="user2" maxlength="20" autocomplete="whiteUserName" />
                        <x-input-error class="mt-2" :messages="$errors->get('whiteUserName')" />
                    </div>

                    <div>
                        <x-input-label for="startMove" value="開始手数" />
                        <x-text-input id="startMove" name="startMove" type="text" class="mt-1 block w-full" :value="old('startMove')" placeholder="3" autocomplete="startMove" />
                        <x-input-error class="mt-2" :messages="$errors->get('startMove')" />
                    </div>

                    <div>
                        <x-form.toggle-button name="ai" :value="old('ai', '1')">
                            終盤20マス空きで評価値を表示<span class="ml-1 text-xs text-amber-600">β版で実装</span>
                        </x-form.toggle-button>
                    </div>

                    <div class="sm:col-span-2">
                        <x-input-label for="comments" value="コメント" /><span class="ml-1 text-xs text-amber-600">β版で実装</span>
                        <x-form.input-textarea id="comments" name="comments" type="text" class="mt-1 block w-full" :value="old('comments')" maxlength="10000" autocomplete="comments" rows="8" />
                        <x-input-error class="mt-2" :messages="$errors->get('comments')" />
                    </div>

                    <div>
                        <x-input-label for="beginText" value="盤面より上部のテキスト" />
                        <x-form.input-textarea id="beginText" name="beginText" type="text" class="mt-1 block w-full" :value="old('beginText')" maxlength="10000" placeholder="白番です。ここから勝ってください。" autocomplete="beginText" rows="8" />
                        <x-input-error class="mt-2" :messages="$errors->get('beginText')" />
                    </div>

                    <div>
                        <x-input-label for="endText" value="盤面より下部のテキスト" />
                        <x-form.input-textarea id="endText" name="endText" type="text" class="mt-1 block w-full" :value="old('endText')" maxlength="10000" placeholder="正解は次へボタンを押すと確認できます。" autocomplete="endText" rows="8" />
                        <x-input-error class="mt-2" :messages="$errors->get('endText')" />
                    </div>

                    @for($i = 0; $i < 10; $i++)
                        <div class="tag-input">
                            <x-input-label for="tag-input-{{ $i }}"
                                           :value="$i === 0 ? 'タグ(最大10個)' : 'タグ' . ($i + 1)" />
                            <x-text-input id="tag-input-{{ $i }}" name="tags[]" type="text" class="mt-1 block w-full" :value="old('tags.'.$i)" maxlength="21" placeholder="" autocomplete="description"/>
                            <x-input-error class="mt-2" :messages="$errors->get('tags.*')" />
                        </div>
                    @endfor
                </div>

                <x-primary-button>
                    投稿する
                </x-primary-button>
            </form>
        </div>
    </div>
    <script>
        // エンターでsubmitが発火しないようにする
        const form = document.getElementById('postUpload');
        form.addEventListener('keydown', (event) => {
            if (event.key === 'Enter' && event.target.type !== 'textarea') {
                event.preventDefault();
            }
        });

        document.addEventListener('DOMContentLoaded', function () {
            const textarea = document.getElementById('comments');
            if (textarea) {
                textarea.setAttribute('placeholder', "0:初手のコメント\n4:4手目のコメント");
            }
        });
    </script>
@endsection
@include('layouts.footer')
