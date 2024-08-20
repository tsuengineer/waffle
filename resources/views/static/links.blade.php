@extends('layouts.app')
@include('layouts.header')
@section('title')リンク集｜{{ config('app.name') }}@endsection

@section('content')
    <div class="pt-4 pb-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="pb-8">
                {{ Breadcrumbs::render('static.links') }}
            </div>

            <div class="mb-8 py-4 bg-zinc-900 overflow-hidden border border-zinc-800 sm:rounded">
                <div class="p-4">
                    <h2 class="text-lg font-bold text-zinc-200">オセロAI</h2>
                    <p class="text-zinc-400 my-2">
                        PC向けのオセロ研究アプリ
                    </p>
                    <ul class="list-disc list-inside text-zinc-400">
                        <li><a href="https://www.egaroucid.nyanyan.dev/ja/" target="_blank" class="text-blue-400 hover:underline">Egaroucid</a></li>
                        <li><a href="http://simasuke.web.fc2.com/edaxgui.html" target="_blank" class="text-blue-400 hover:underline">EdaxGUI</a></li>
                        <li><a href="http://t-ishii.la.coocan.jp/hp/mr/" target="_blank" class="text-blue-400 hover:underline">MasterReversi</a></li>
                        <li><a href="http://www.radagast.se/othello/download.html" target="_blank" class="text-blue-400 hover:underline">WZebra</a></li>
                    </ul>
                    <p class="text-zinc-400 my-2">
                        スマホ向けのオセロ研究アプリ
                    </p>
                    <ul class="list-disc list-inside text-zinc-400">
                        <li><a href="https://app.lavox.net/kifubox/" target="_blank" class="text-blue-400 hover:underline">棋譜Box</a></li>
                        <li><a href="https://play.google.com/store/apps/details?id=com.droidSimax&hl=ja&pli=1" target="_blank" class="text-blue-400 hover:underline">droidShimax</a></li>
                    </ul>
                </div>
            </div>

            <div class="mb-8 py-4 bg-zinc-900 overflow-hidden border border-zinc-800 sm:rounded">
                <div class="p-4">
                    <h2 class="text-lg font-bold text-zinc-200">オセラーのブログ</h2>
                    <p class="text-zinc-400 mt-2">
                        読めばオセロが強くなる解説サイトなど
                    </p>
                    <ul class="list-disc list-inside mt-4 text-zinc-400">
                        <li><a href="https://bassy84.net/" target="_blank" class="text-blue-400 hover:underline">オセロの勝ち方(抜歯ぃさん)</a></li>
                        <li><a href="http://blog.livedoor.jp/umigame_oth/" target="_blank" class="text-blue-400 hover:underline">黒引き分け勝ち(うみがめさん)</a></li>
                        <li><a href="https://othelloq.com/" target="_blank" class="text-blue-400 hover:underline">おせろく(ラスクさん)</a></li>
                        <li><a href="http://othello2006.blog74.fc2.com/" target="_blank" class="text-blue-400 hover:underline">オセロ(りばーさん)</a></li>
                    </ul>
                </div>
            </div>

            <div class="mb-8 py-4 bg-zinc-900 overflow-hidden border border-zinc-800 sm:rounded">
                <div class="p-4">
                    <h2 class="text-lg font-bold text-zinc-200">オセラーのYoutube</h2>
                    <p class="text-zinc-400 mt-2">
                        観ればオセロが強くなる解説動画など
                    </p>
                    <ul class="list-disc list-inside mt-4 text-zinc-400">
                        <li><a href="https://www.youtube.com/@river-666" target="_blank" class="text-blue-400 hover:underline">りばーちゃんねる</a></li>
                    </ul>
                </div>
            </div>

            <div class="mb-8 py-4 bg-zinc-900 overflow-hidden border border-zinc-800 sm:rounded">
                <div class="p-4">
                    <h2 class="text-lg font-bold text-zinc-200">お世話になったサイト</h2>
                    <p class="text-zinc-400 mt-2">
                        XOTの棋譜データを使わせていただきました
                    </p>
                    <ul class="list-disc list-inside mt-4 text-zinc-400">
                        <li><a href="https://berg.earthlingz.de/xot/index.php" target="_blank" class="text-blue-400 hover:underline">XOT - for fun Othello start positions</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection
@include('layouts.footer')
