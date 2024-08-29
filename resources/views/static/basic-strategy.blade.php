@extends('layouts.app')
@include('layouts.header')
@section('title')オセロ基本戦略｜{{ config('app.name') }}@endsection

@section('content')
    <div class="pt-4 pb-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="pb-8">
                {{ Breadcrumbs::render('static.basic-strategy') }}
            </div>

            <!-- 新しく追加するセクション -->
            <div class="mb-8 py-4 bg-zinc-900 overflow-hidden border border-zinc-800 sm:rounded">
                <div class="sm:pt-4 sm:pr-4 pt-8 px-4">
                    <h2 class="mb-4 text-lg text-zinc-200 font-bold">オセロの基本的な戦術について</h2>
                    <p class="text-zinc-400">
                        あなたがオセロについてどれくらい理解しているかを確かめるために、簡単なクイズを用意しました。<br>
                        YesかNoで答えてください。
                    </p>
                    <ol class="pt-8 pb-16 text-zinc-400 list-decimal ml-6 leading-10">
                        <li>オセロは、石の数が多い方が勝ちなので、序盤からどんどん石を増やすべきである</li>
                        <li>オセロは、四隅（角）を全て取れば必ず勝てる</li>
                        <li>オセロは、序盤は中央の4×4のマスから出ない方がいい</li>
                        <li>オセロは、辺を取らない方がいい</li>
                        <li>隅（角）の周りは積極的に取っていった方がいい</li>
                    </ol>
                    <p class="text-zinc-400">
                        答えはすべて「<span class="font-bold text-red-400">No</span>」です！ <br>
                        ただし、②については、隅を取れないより取った方がいいですが時と場合によります。<br>
                        特に、①については誤解している人が多いです。<br>
                        オセロでは、最終的に石の数が多い方が勝ちますが、<span class="text-red-400 underline decoration-wavy">序盤に石を多く取れば有利になるとは限りません</span>。
                    </p>
                </div>
            </div>

            <div class="mb-8 py-4 bg-zinc-900 overflow-hidden border border-zinc-800 sm:rounded">
                <div class="sm:pt-4 sm:pr-4 pt-8 px-4">
                    <h2 class="mb-4 text-lg text-zinc-200 font-bold">Ⅰ、基本的な考え方</h2>
                    <p class="text-zinc-400">
                        まずは次の例を見てみましょう。
                    </p>
                    <p class="text-zinc-400">
                        白が序盤に大量の石を取った場面です。<br>
                        ここで黒番、どのように打っていけばいいか考えてみてください。
                    </p>
                    <div class="w-full md:w-2/3 py-4">
                        <x-board
                            boardId="no1"
                            initBoard="-OOOOOO---OOOO--OOOXOO--OOOXOO--OOOXOO---OOOOO----OXO----OOOO---"
                            kifu="A7A6A2B2A1H1G2G3H3H2H4H5B7H6G4G5F8G8G6G7H8A8"
                            initTurn="black"
                            start="0"
                            blackUserName=""
                            whiteUserName=""
                            comments="{{ json_encode([
                                ['moves' => 0, 'text' => '黒はどこに打つべきでしょうか？進むボタンで正解を表示'],
                                ['moves' => 1, 'text' => '正解はA7です\n進むボタンを押して終局まで進めてください'],
                                ['moves' => 2, 'text' => '白はB7に打つと黒にA8を取られてしまうので、A6に打ちました'],
                                ['moves' => 3, 'text' => '黒はA8を取られないようにA2に打ちます'],
                                ['moves' => 4, 'text' => '白はB2にしか打てません'],
                                ['moves' => 5, 'text' => '黒はA1を取れました！'],
                                ['moves' => 6, 'text' => 'H1も取れました！'],
                                ['moves' => 7, 'text' => 'どんどん取っていきます'],
                                ['moves' => 8, 'text' => '白はG3しか打てません'],
                                ['moves' => 9, 'text' => 'H3に打ちます'],
                                ['moves' => 10, 'text' => '白はH2しか打てません'],
                                ['moves' => 11, 'text' => 'H4に打ちます'],
                                ['moves' => 12, 'text' => '白はH5しか打てません'],
                                ['moves' => 13, 'text' => 'B7に打ちます'],
                                ['moves' => 14, 'text' => 'H6に打ちます'],
                                ['moves' => 15, 'text' => 'G4に打ちます'],
                                ['moves' => 16, 'text' => '白はG5しか打てません'],
                                ['moves' => 17, 'text' => 'F8に打ちます'],
                                ['moves' => 18, 'text' => '白はG8しか打てません'],
                                ['moves' => 19, 'text' => 'G6に打ちます'],
                                ['moves' => 20, 'text' => '白はG7しか打てません'],
                                ['moves' => 21, 'text' => 'H8に打ちます'],
                                ['moves' => 22, 'text' => 'A8に打ちます\n全滅です！'],
                            ]) }}"
                        ></x-board>
                    </div>
                    <p class="pb-4 text-zinc-400">
                        途中から白には選択肢がなく、常に1か所しか打てない状況が続いて負けてしまいました。<br>
                        白は序盤に大量に石を取ったために、自分の打てる場所が限られてしまったのです。<br>
                    </p>
                    <p class="text-zinc-400">
                        つまり、序盤で多くの石を取ると、自分の手数が減り、負けることが多くなるのです。<br>
                        オセロは手数の勝負です。手数がなくなった方が負けます。基本的に打てる箇所が多い方が有利です。<br>
                        この考え方は、序盤、中盤、終盤のすべてで重要ですので、しっかり覚えておきましょう。
                    </p>
                </div>
            </div>

            <div class="mb-8 py-4 bg-zinc-900 overflow-hidden border border-zinc-800 sm:rounded">
                <div class="sm:pt-4 sm:pr-4 pt-8 px-4">
                    <h2 class="mb-4 text-lg text-zinc-200 font-bold">Ⅱ、だんご石と中割り(※以降作成中)</h2>
                    <p class="text-zinc-400">
                        次に、良い手の一つとして「だんご石」というものがあります。これは図6に示すように、自分の石が内側に集まっている状態です。内側に集まるように石を置くと有利になることが多いです。

                        図6：だんご石を作る
                        白番です。次の手は？
                        白e3と打つことで、白石がすべてつながり、だんご石の形になりました。
                    </p>
                </div>
            </div>

            <div class="mb-8 py-4 bg-zinc-900 overflow-hidden border border-zinc-800 sm:rounded">
                <div class="sm:pt-4 sm:pr-4 pt-8 px-4">
                    <h2 class="mb-4 text-lg text-zinc-200 font-bold">Ⅲ、天王山を見極める</h2>
                    <p class="text-zinc-400">
                        オセロでは、相手の手数を減らし、自分の手数を増やすことが基本です。相手にも自分にも有利な場所は早めに打っておく必要があります。このような場所を「天王山」と呼びます。                    </p>
                    <p class="text-zinc-400">
                        白番です。天王山はどこでしょう？
                        この図では、c4がそれに該当します。白番ならc4に打つことで、黒がc4に打つ絶好の手を消すことができます。好手を消すことで、黒は他に打たざるを得なくなり、一手（または二手）のアドバンテージを得ることができます。天王山は簡単に見えるものから、見えにくいものまであり、それを見極めることが勝率を高める鍵となります。                    </p>
                </div>
            </div>

            <div class="mb-8 py-4 bg-zinc-900 overflow-hidden border border-zinc-800 sm:rounded">
                <div class="sm:pt-4 sm:pr-4 pt-8 px-4">
                    <h2 class="mb-4 text-lg text-zinc-200 font-bold">Ⅳ、辺の戦術</h2>
                    <p class="text-zinc-400">
                        辺の戦術は、オセロにおいて非常に重要です。辺を制することで、隅を取るための布石を打つことができます。一般的には、辺を取ることはリスクが伴いますが、正しく活用することで大きなメリットを得ることができます。
                    </p>
                    <p class="text-zinc-400">
                        辺を取る際には、相手の次の手を制限するように石を置くことが重要です。たとえば、隅に近い辺を取ることで、相手に隅を取らせないようにすることが可能です。また、辺を取ることで相手の手数を減らし、自分の手数を増やす戦略もあります。
                    </p>
                </div>
            </div>

            <div class="mb-8 py-4 bg-zinc-900 overflow-hidden border border-zinc-800 sm:rounded">
                <div class="sm:pt-4 sm:pr-4 pt-8 px-4">
                    <h2 class="mb-4 text-lg text-zinc-200 font-bold">Ⅴ、まとめ</h2>
                    <ol class="pt-8 pb-16 text-zinc-400 list-decimal ml-6 leading-10">
                        <li>隅を取ることと手数を確保することを心がける。</li>
                        <li>序盤に大量の石を取らず、一手返しを心がけて壁を作らないようにする。</li>
                        <li>効果的な中割りや、だんご石などを考慮しながら次の手を考える。</li>
                        <li>天王山は先に打つ。</li>
                        <li>余裕が出てきたら、3手先を考えて打つ（相手の置く場所や次に自分が置く場所を予測する）。</li>
                        <li>辺に置くのは他に良い手が見つからないときにし、単独C打ちは避ける。</li>
                        <li>ウィングの形はできるだけ避ける。ただし、手数を確保するために必要な場合は手数を優先する。</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
@endsection
@include('layouts.footer')
