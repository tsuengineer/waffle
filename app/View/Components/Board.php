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
        $this->kifu = $kifu ?? 'G4';
        $this->initBoard = $initBoard ?? '-OOO----X-XO-O---XOOO-X-OOXOXX--OOOXXXX-OOXXXXX-O-XOOX---X-OO-X-';
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
