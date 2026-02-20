<?php

namespace App\Http\Livewire\Users\Components;

use App\Models\User;
use Livewire\Component;
use Spatie\Permission\Models\Role;
use App\Models\Clients;

class Overview extends Component
{
    public User $user;
    public $editing = false;
    public $allRoles;
    public $selectedRole1;
    public $selectedRole2;
    public $allClients;   

    protected $listeners = ['editUser', 'saveUser'];
    protected $rules = [
        'user.name' => 'required',
        'user.email' => 'required',
        'user.street_address' => 'required',
        'user.postal_code' => 'required',
        'user.city' => 'required',
        'user.province' => 'required',
        'user.country' => 'required',
        'selectedRole1' => 'required',
        'selectedRole2' => 'nullable',  // Role 2 can be optional
        'user.client_id' => 'nullable|exists:clients,id',
    ];

    public function mount($id)
    {
        $this->user = User::find($id);
        $this->allRoles = Role::all();
        // Initialize roles for user (if user has them assigned)
        $this->selectedRole1 = $this->user->roles[0]->id ?? null;
        $this->selectedRole2 = $this->user->roles[1]->id ?? null;
        // pre-fill clients from CSV in client_id

        $this->allClients = Clients::select('id','name')->get();

        $this->selectedClients = $this->user->client_id
            ? explode(',', $this->user->client_id)
            : [];
    }

    public function render()
    {
        return view('livewire.users.components.overview', [
            // pass through the clients array
            'allClients' => $this->allClients,
        ]);
    }

    public function editUser()
    {
        $this->editing = !$this->editing;
    }

    public function saveUser()
    {
        // 1) Sync roles first
        $rolesToSync = [];
        if ($this->selectedRole1) {
            $rolesToSync[] = $this->selectedRole1;
        }
        if ($this->selectedRole2) {
            $rolesToSync[] = $this->selectedRole2;
        }
        $this->user->syncRoles($rolesToSync);

        // 2) Serialize selectedClients back to CSV
        $this->user->client_id = count($this->selectedClients)
            ? implode(',', $this->selectedClients)
            : null;

        // 3) Save the user model with the new client_id
        $this->user->save();

        // 4) Refresh any dependent properties
        $this->userRoles = $this->user->roles;

        // 5) Exit edit mode and show success
        $this->editing = false;
        $this->emit('successFlash', 'Changes saved successfully');
    }
}
