<?php

namespace App\Http\Livewire\Boards;

use App\Jobs\CreateBoardEmail;
use App\Models\Board;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Spatie\Permission\Models\Permission;

class CreateBoard extends Component
{
    public $errors = [];

    public $board;
    public $allUsers;
    public $currentUserId;
    public $contributerIds = [];
    protected $rules = [
        'board.name' => 'required',
    ];

    public function mount()
    {
        $this->board = Board::make();
        $this->allUsers = User::all();
        $this->currentUserId = Auth::id();
    }

    public function render()
    {
        return view('livewire.boards.create-board');
    }

    public function save()
    {
        $this->validate([
            'board.name' => 'required|unique:boards,name,' . $this->board->id,
        ]);

        $this->board->save();
        $this->board->users()->attach($this->contributerIds);

        $emailContent = 'You\'ve been added to a new board called ' . $this->board->name;
        $boardLink = env('APP_URL') . '/boards/' . $this->board->id;

        foreach($this->contributerIds as $id) {
            $to_email = User::find($id)->email;

            // dispatch(new CreateBoardEmail(Auth::user()->name, $to_email, $emailContent, $boardLink));
        }

        Permission::create(['name' => $this->board->name . '-add items', 'guard_name' => 'web']);
        Permission::create(['name' => $this->board->name . '-edit items', 'guard_name' => 'web']);
        Permission::create(['name' => $this->board->name . '-delete items', 'guard_name' => 'web']);
        Permission::create(['name' => $this->board->name . '-upload files', 'guard_name' => 'web']);
        Permission::create(['name' => $this->board->name . '-delete files', 'guard_name' => 'web']);
        Permission::create(['name' => $this->board->name . '-post comments', 'guard_name' => 'web']);
        Permission::create(['name' => $this->board->name . '-delete any comment', 'guard_name' => 'web']);

        User::find(Auth::id())->givePermissionTo([
            $this->board->name . '-add items',
            $this->board->name . '-edit items',
            $this->board->name . '-delete items',
            $this->board->name . '-upload files',
            $this->board->name . '-delete files',
            $this->board->name . '-post comments',
            $this->board->name . '-delete any comment'
        ]);

        session()->flash('message', $this->board->name . ' successfully created');
        return redirect()->to('../boards');
    }

    public function addAllUsers()
    {
        $this->contributerIds = User::all()->pluck('id')->toArray();
        $this->emit('usersAdded');
    }
}
