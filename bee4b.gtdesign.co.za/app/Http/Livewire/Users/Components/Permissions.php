<?php

namespace App\Http\Livewire\Users\Components;

use App\Models\Module;
use App\Models\Phase;
use App\Models\User;
use Livewire\Component;
use Spatie\Permission\Models\Role;

class Permissions extends Component
{
    public $user;
    public $userRoles;
    public $modules;
    public $allRoles;
    public $operations = [
        'create', 'view', 'edit', 'delete'
    ];
    public $systemPermissions = ['users', 'roles'];
    public $selectedRole;
    public $roleObject;
    public $phases;

    public function mount($id)
    {
        $this->user = User::find($id);
        $this->modules = Module::all();
        $this->allRoles = Role::all();
        $this->selectedRole = $this->user->roles[0]->id;
        $this->roleObject = Role::find($this->selectedRole);
        $this->userRoles = $this->user->roles;
        $this->phases = Phase::all();
    }

    public function render()
    {
        return view('livewire.users.components.permissions');
    }

    public function changeRole()
    {

    }

    public function submit($formData)
    {
        // dd($formData);
        if($this->selectedRole !== '') {
            $this->user->syncRoles([$this->selectedRole]);
            $this->userRoles = $this->user->roles;
        }
        $this->user->syncPermissions($formData);
        // $this->emit('successFlash', 'Changes saved successfully');
    }

    public function updatedSelectedRole($value)
    {
        if($value != '')
            $this->roleObject = Role::find($value);

        $this->emit('selectedRoleChanged', $value);
    }
}
