<div id="board" class="board-container" style="width: 100%"></div>
<div class="button-list flex w-full space-x-4 mt-2">
    <button class="flex-1 bg-zinc-700 rounded-lg py-2" onmouseup="board.movePrev()">←戻る</button>
    <button class="flex-1 bg-zinc-700 rounded-lg py-2" onmouseup="board.moveNext()">進む→</button>
</div>

@push('scripts')
    <script src="{{ asset('js/board.js') }}?v=20240807"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const kifu = "{{ $kifu ?? '' }}";
            const initBoard = "{{ $initBoard ?? '' }}";
            const initTurn = "{{ $initTurn ?? 'black' }}";
            const start = "{{ $start ?? 0 }}";
            const blackUserName = "{{ $blackUserName ?? '' }}";
            const whiteUserName = "{{ $whiteUserName ?? '' }}";
            const comments = "{{ $comments ?? '' }}";
            window.board = new Preview(kifu, initBoard, initTurn, Number(start), blackUserName, whiteUserName, comments);

            board.makeBoard(board.currentKifu);
            board.drawBoard();
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
