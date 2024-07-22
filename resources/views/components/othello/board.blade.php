<div id="board" class="board-container" style="width: 100%"></div>
<div class="button-list">
    <button onmouseup="board.movePrev()">＜＜</button>
    <button onmouseup="board.moveNext()">＞＞</button>
</div>

@push('scripts')
    <script src="{{ asset('js/board.js') }}"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const kifu = "{{ $kifu ?? 'C8A8' }}";
            const initBoard = "{{ $initBoard ?? '-OOO----X-XO-O---XOOO-X-OOXOXX--OOOXXXX-OOXXXXX-O-XOOX---X-OO-O-' }}";
            const turn = "{{ $turn ?? '' }}";
            const start = "{{ $start ?? 0 }}";
            window.board = new Preview(kifu, initBoard, turn, Number(start));

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
