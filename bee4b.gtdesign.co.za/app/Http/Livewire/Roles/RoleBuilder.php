<?php

namespace App\Http\Livewire\Roles;

use App\Models\Module;
use Livewire\Component;
use Spatie\Permission\Models\Role;

class RoleBuilder extends Component
{
    public $modules;
    public $roleName;
    public $operations = [
        'create', 'view', 'edit', 'delete'
    ];
    public $systemPermissions = [
        'users', 'roles'
    ];
    public $breadcrumbs = [];

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

    public function mount()
    {
        $this->modules = Module::all();
        // dd($this->modules[0]);
        $this->breadcrumbs = ['Roles', 'Create Role'];
    }

    public function render()
    {
        return view('livewire.roles.role-builder')
            ->layoutData([
                'backText' => 'all Roles'
            ]);
    }

    public function submit($formData)
    {
        // dd($this->test);
        // dd($this->modules);
        // dd($formData);

        $newRole = Role::create([
            'name' => $this->roleName, 
            'guard_name' => 'web'
        ]);

        $newRole->syncPermissions($formData);
    }
}
