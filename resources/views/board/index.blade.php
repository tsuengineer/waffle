@extends('layouts.app')
@include('layouts.header')
@section('title'){{ config('app.name') }}@endsection

@section('content')
    <div class="pt-4 pb-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div x-data="{ showPreviewBoard: true }" class="mb-8">
                {{-- トグルボタン --}}
                <label class="relative inline-flex items-center cursor-pointer mt-4">
                    <input type="checkbox" x-model="showPreviewBoard" class="sr-only">
                    <div x-bind:class="showPreviewBoard ? 'bg-gray-700' : 'bg-green-400'" class="w-11 h-6 rounded-full peer-focus:outline-none">
                        <div x-bind:class="showPreviewBoard ? 'translate-x-0' : 'translate-x-full'" class="absolute top-[2px] left-[2px] bg-white border-gray-300 border rounded-full h-5 w-5 transition-transform"></div>
                    </div>
                    <span class="ml-3 text-sm font-medium text-gray-300">編集モード</span>
                </label>

                <div>
                    {{-- edit-boardコンポーネント --}}
                    <div x-show="!showPreviewBoard">
                        <x-edit-board initTurn="black"></x-edit-board>
                    </div>

                    {{-- boardコンポーネント --}}
                    <div x-show="showPreviewBoard">
                        <x-board initTurn="black" kifu="{{ request('kifu') }}"></x-board>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@include('layouts.footer')
