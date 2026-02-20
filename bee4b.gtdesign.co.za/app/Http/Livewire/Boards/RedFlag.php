<?php

namespace App\Http\Livewire\Boards;

use Livewire\Component;
use App\Models\Board;

class RedFlag extends Component
{
    public int $boardId;
    public bool $flagged = false;

    public function mount(int $boardId, bool $initial = false): void
    {
        $this->boardId = $boardId;
        $this->flagged = $initial;
    }

    public function toggle(): void
    {
        $board = Board::find($this->boardId);
        if (!$board) return;

        $board->red_flagged = !$board->red_flagged;
        $board->save();

        $this->flagged = $board->red_flagged; // reflect change
    }

    public function render()
    {
        return view('livewire.boards.red-flag');
    }
}
