<?php

namespace App\Http\Livewire\Settings\Components;

use Livewire\Component;
use Spatie\Permission\Models\Role;

class RolesAndPermissions extends Component
{
    public $currentRole;
    public $newRole = false;

    protected $listeners = [
        'refreshRoles' => '$refresh',
        'roleCreated',
        'roleDeleted',
    ];

    public function mount()
    {
        $this->currentRole = $this->roles->first()->id;
    }

    public function render()
    {
        return view('livewire.settings.components.roles-and-permissions');
    }

    public function getRolesProperty()
    {
        return Role::all();
    }

    public function roleCreated()
    {
        $this->newRole = false;
        $this->emitSelf('refreshRoles');
    }

    public function roleDeleted()
    {
        $this->emitSelf('refreshRoles');
    }

    public function toggleNewRole()
    {
        $this->newRole = true;
        $this->currentRole = null;
    }

    public function changeRole($roleID)
    {
        $this->currentRole = $roleID;
        $this->newRole = false;
        $this->emit('selectedRoleChanged', $roleID);
    }

    public function getRole()
    {
        return Role::find($this->currentRole);
    }
}
