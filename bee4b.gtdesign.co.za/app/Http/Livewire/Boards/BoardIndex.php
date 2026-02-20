<?php

namespace App\Http\Livewire\Boards;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class BoardIndex extends Component
{
    public $testString = 'hello there';

    protected $listeners = ['eventClicked'];
    public $modal = false;
    public function eventClicked()
    {
        $this->modal = true;
        // dd('in livewire');
        // $this->testString = 'string changed';
    }

    public $user;
    
    public function mount()
    {
        $this->user = User::find(Auth::id());
    }

    public function render()
    {
        return view('livewire.boards.board-index');
    }

    public function createBoard()
    {
        return redirect()->to('boards/create');
    }
}
