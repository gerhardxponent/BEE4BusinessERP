<?php

namespace App\Http\Livewire\Roles;

use Livewire\Component;

class RoleIndex extends Component
{
    protected $listeners = [
        'createRole'
    ];

    public function render()
    {
        return view('livewire.roles.role-index')
            ->layoutData([
                'title' => 'Roles',
                'buttonPermission' => 'create roles',
                'buttonAction' => 'createRole',
                'buttonText' => 'Create Role'
            ]);
    }

    public function createRole() { return redirect()->to('/roles/create'); }
}
