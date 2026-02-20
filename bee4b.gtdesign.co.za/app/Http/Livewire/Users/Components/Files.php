<?php

namespace App\Http\Livewire\Users\Components;

use App\Models\User;
use Livewire\Component;

class Files extends Component
{
    public User $user;

    public function mount($id)
    {
        $this->user = User::find($id);
    }

    public function render()
    {
        return view('livewire.users.components.files');
    }
}
