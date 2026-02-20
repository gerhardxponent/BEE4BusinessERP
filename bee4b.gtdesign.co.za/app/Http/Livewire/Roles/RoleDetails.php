<?php

namespace App\Http\Livewire\Roles;

use App\Models\Modules;
use App\Models\Phase;
use Livewire\Component;
use Spatie\Permission\Models\Role;

class RoleDetails extends Component
{
    public Role $role;
    public $operations = [
        'create', 'view', 'edit', 'delete'
    ];
    public $modules;
    public $breadcrumbs = [];
    public $phases;
    public $systemPermissions = ['users', 'roles'];

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

    public $systemPermissionCheck = [];
    // Checked property gets added to 'Module' attribute array
    protected $rules = [
        'modules.*.checked' => 'required',
        'systemPermissionCheck.*' => 'required'
    ];

    public function mount($id)
    {
        $this->role = Role::find($id);
        $this->modules = Modules::all();
        $this->breadcrumbs = ['Roles', $this->role->name];
        $this->phases = Phase::all();
    }

    public function render()
    {
        return view('livewire.roles.role-details')
            ->layoutData([
                'backText' => 'all Roles'
            ]);
    }

    public function submit($formData)
    {
        $this->role->syncPermissions($formData);

        $this->dispatchBrowserEvent('notify-success', ['message' => 'Role updated successfully']);
    }
}
