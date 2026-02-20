<?php

namespace App\Http\Livewire\GlobalComponents;

use Livewire\Component;
use App\Models\Module;
use Spatie\Permission\Models\Role;

class RolesAndPermissions extends Component
{
    public $title = 'Permissions';
    public $modules;
    public $roleName;
    public $operations = [
        'create', 'view', 'edit', 'delete'
    ];
    public $systemPermissions = [
        'users', 'roles'
    ];
    // public $breadcrumbs = [];
    public $selectedRole = '';

    public $usersAndRolesCheckboxes = [
        'create' => false,
        'view' => false,
        'edit' => false,
        'delete' => false,
    ];

    public $modulesCheckboxes = [
        'create' => false,
        'view' => false,
        'edit' => false,
        'delete' => false,
    ];

    public $createBox = false;

    public $systemPermissionCheck = [];
    // Checked property gets added to 'Module' attribute array
    protected $rules = [
        'modules.*.checked' => 'required',
        'systemPermissionCheck.*' => 'required'
    ];

    public $user;
    public $role;
    public $roleID;

    public $showConfirmDeleteModal = false;

    protected $listeners = [
        'selectedRoleChanged',
        'confirmDelete'
    ];

    public function selectedRoleChanged($value) 
    {
        if($value != '') {
            $this->role = Role::find($value);
            $this->selectedRole = $value;
        }
    }

    public function mount()
    {
        $this->modules = Module::all();
        $this->breadcrumbs = ['Roles', 'Create Role'];
        isset($this->roleID) ?? $this->role = Role::find($this->roleID);
    }

    public function render()
    {
        return view('livewire.global-components.roles-and-permissions');
    }

    public function submit($formData)
    {
        if (isset($this->role) && !isset($this->user)) { //editing role
            $this->role->syncPermissions($formData);
        } else if (isset($this->user)) { //user permissions
            if($this->selectedRole !== '') {
                $this->user->syncRoles([$this->selectedRole]);
                $this->userRoles = $this->user->roles;
            }
            $this->user->syncPermissions($formData);
        } else { //creating new role
            $newRole = Role::create([
                'name' => $this->roleName, 
                'guard_name' => 'web'
            ]);
            $newRole->syncPermissions($formData);
            $this->emit('roleCreated');
        }
    }

    public function confirmDelete()
    {
        $this->showConfirmDeleteModal = true;
    }

    public function deleteRole()
    {   
        if($this->role->name == 'administrator' || $this->role->name == 'Administrator')
            return; 

        $this->role->delete();

        $this->showConfirmDeleteModal = false;
        $this->emit('roleDeleted');
    }
}
