@section('footer')
    <div class="bg-zinc-800 border-t border-zinc-700">
        <div class="max-w-7xl m-auto pt-4 pb-12 sm:px-6 lg:px-8 text-zinc-100">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex">
                    <ul class="list-disc list-inside text-zinc-400">
                        <li class="pb-2">
                            <a href="{{ route('static.links') }}" class="text-zinc-400 hover:text-white">リンク集</a>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="pt-4 text-center">
                (C) {{now()->year}} わっふる
            </div>
        </div>
    </div>
@endsection
