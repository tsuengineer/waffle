@extends('layouts.app')
@include('layouts.header')
@section('title')
    テスト｜{{ config('app.name') }}
@endsection

@section('content')
    <div class="pt-4 pb-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <h2>牛定石</h2>
            <div class="w-full md:w-2/3">
                <x-board
                    boardId="cow"
                    kifu="F5F6E6D6C5"
                    initTurn="black"
                    start="5"
                    blackUserName=""
                    whiteUserName=""
                    comments="{{ json_encode([['moves' => 0, 'text' => '初手のコメント']]) }}"
                ></x-board>
            </div>
            <h2>虎定石</h2>
            <div class="w-full md:w-2/3">
                <x-board
                    boardId="tiger"
                    kifu="F5D6C3D3C4"
                    initTurn="black"
                    start="5"
                    blackUserName=""
                    whiteUserName=""
                    comments=""
                ></x-board>
            </div>
        </div>
    </div>
@endsection
@include('layouts.footer')
