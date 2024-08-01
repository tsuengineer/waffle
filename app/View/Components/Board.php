<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Board extends Component
{
    public string $kifu;
    public string $initBoard;
    public string $initTurn;
    public int $start;
    public string $blackUserName;
    public string $whiteUserName;

    public function __construct(
        $kifu = null,
        $initBoard = null,
        $initTurn = 'black',
        $start = 0,
        $blackUserName = '',
        $whiteUserName = '',
    ) {
        $this->kifu = $kifu ?? '';
        $this->initBoard = $initBoard ?? '';
        $this->initTurn = $initTurn;
        $this->start = $start;
        $this->blackUserName = $blackUserName;
        $this->whiteUserName = $whiteUserName;
    }

    public function render()
    {
        return view('components.othello.board', [
            'kifu' => $this->kifu,
            'initBoard' => $this->initBoard,
            'initTurn' => $this->initTurn,
            'start' => $this->start,
            'blackUserName' => $this->blackUserName,
            'whiteUserName' => $this->whiteUserName,
        ]);
    }
}
