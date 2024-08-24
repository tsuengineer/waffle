<div id="{{ $boardId ?? '' }}" class="board-container" style="width: 100%"></div>
<div class="button-list flex w-full space-x-4 mt-2">
    <button class="flex-1 bg-zinc-700 rounded-lg py-2" onmouseup="window['{{ $boardId }}'].movePrev()">←戻る</button>
    <button class="flex-1 bg-zinc-700 rounded-lg py-2" onmouseup="window['{{ $boardId }}'].moveNext()">進む→</button>
</div>

@push('scripts')
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const boardId = "{{ $boardId ?? '' }}";
            const kifu = "{{ $kifu ?? '' }}";
            const initBoard = "{{ $initBoard ?? '' }}";
            const initTurn = "{{ $initTurn ?? 'black' }}";
            const start = "{{ $start ?? 0 }}";
            const blackUserName = "{{ $blackUserName ?? '' }}";
            const whiteUserName = "{{ $whiteUserName ?? '' }}";
            const comments = "{{ $comments ?? '' }}";
            window[boardId] = new Preview(boardId, kifu, initBoard, initTurn, Number(start), blackUserName, whiteUserName, comments);

            window[boardId].makeBoard(window[boardId].currentKifu);
            window[boardId].drawBoard();
        });
    </script>
@endpush

@push('styles')
    <style>
        * {
            margin: 0;
            padding: 0;
            touch-action: manipulation;
        }
        .button-list {
            display: flex;
            justify-content: space-between;
            width: 100%;
        }

        button {
            flex: 1;
            margin: 0 5px;
        }
    </style>
@endpush
