<?php

namespace App\Http\Livewire\Boards;

use App\Models\Board;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Spatie\Permission\Models\Permission;

class BoardSettings extends Component
{
    // public $listeners = ['refreshComponent' => '$refresh'];

    public $user;
    public $board;
    public $contributers;
    public $allUsers;
    public $contributerIds = [];
    public $confirmDelete = false;
    protected $rules = [
        'board.name' => 'required'
    ];
    
    public $operations = [
        'add items',
        'edit items',
        'delete items',
        'upload files',
        'delete files',
        'post comments',
        'delete any comment',
    ];

    public function mount($id)
    {
        $this->board = Board::find($id);
        $this->allUsers = User::all();
        $this->user = User::find(Auth::id());
        $this->contributers = $this->board->users;
        foreach($this->contributers as $contributer) {
            array_push($this->contributerIds, $contributer->id);
        }
    }

    public function test()
    {
        // $bp = BoardPermission::make();
        // $bp->user_board_id = 1;
        // $bp->permission_id = 51;
        // $bp->save();
    }

    // public function updatedContributerIds()
    // {
    //     $this->emit('refreshComponent');
    // }

    public function render()
    {
        return view('livewire.boards.board-settings');
    }

    public function save()
    {
        $this->board->save();
        $this->board->users()->sync($this->contributerIds);
        session()->flash('message', 'Changes saved successfully');
        return redirect()->to('../boards/' . $this->board->id);
    }

    public function submit($formData)
    {
        // foreach($formData as $item) {
        //     User::find(explode(';', $item))
        // }
    }

    public function check($id, $op)
    {
        $user = User::find($id);
        $permission = $this->board->name . '-' . $op;

        if($user->hasPermissionTo($permission)) {
            $user->revokePermissionTo($permission);
        }else {
            $user->givePermissionTo($permission);
        }
    }

    public function deleteBoard()
    {
        $this->board->delete();
        Permission::findByName($this->board->name . '-add items', 'web')->delete();
        Permission::findByName($this->board->name . '-edit items', 'web')->delete();
        Permission::findByName($this->board->name . '-delete items', 'web')->delete();
        Permission::findByName($this->board->name . '-upload files', 'web')->delete();
        Permission::findByName($this->board->name . '-delete files', 'web')->delete();
        Permission::findByName($this->board->name . '-post comments', 'web')->delete();
        Permission::findByName($this->board->name . '-delete any comment', 'web')->delete();
        return redirect()->to('../boards');
    }
}
