<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Board extends Component
{
    public string $kifu;
    public string $initBoard;
    public string $turn;
    public int $start;

    public function __construct($kifu = null, $initBoard = null, $turn = 'black', $start = 0)
    {
        $this->kifu = $kifu ?? '';
        $this->initBoard = $initBoard ?? '';
        $this->turn = $turn;
        $this->start = $start;
    }

    public function render()
    {
        return view('components.othello.board', [
            'initBoard' => $this->initBoard
        ]);
    }
}
