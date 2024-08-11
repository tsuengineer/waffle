<?php

namespace App\View\Components;

use Illuminate\View\Component;

class EditBoard extends Component
{
    public string $initBoard;
    public string $initTurn;

    public function __construct(
        $initBoard = null,
        $initTurn = 'black',
    ) {
        $this->initBoard = $initBoard ?? '';
        $this->initTurn = $initTurn;
    }

    public function render()
    {
        return view('components.othello.edit-board', [
            'initBoard' => $this->initBoard,
            'initTurn' => $this->initTurn,
        ]);
    }
}
