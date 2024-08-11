<div id="editBoard" class="board-container" style="width: 100%"></div>
<div class="button-list flex w-full space-x-4 mt-2">
    <button class="flex-1 bg-zinc-700 rounded-lg py-2" onmouseup="editBoard.movePrev()">←戻る</button>
    <button class="flex-1 bg-zinc-700 rounded-lg py-2" onmouseup="editBoard.moveNext()">進む→</button>
</div>

@push('scripts')
    <script src="{{ asset('js/edit-board.js') }}?v=20240807"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const initBoard = "{{ $initBoard ?? '' }}";
            const initTurn = "{{ $initTurn ?? 'black' }}";
            window.editBoard = new Edit(initBoard, initTurn);

            editBoard.makeBoard(board.currentKifu);
            editBoard.drawBoard();
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
