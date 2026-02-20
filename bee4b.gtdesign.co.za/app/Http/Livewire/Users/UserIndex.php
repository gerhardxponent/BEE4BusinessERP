<?php

namespace App\Http\Livewire\Users;

use App\Models\Clients;
use App\Models\User;
use Livewire\Component;
use Spatie\Permission\Models\Role;
use App\Mail\WelcomeEmail;
use Illuminate\Support\Facades\Mail;

class UserIndex extends Component
{
    public User $user;
    public $roles = [];
    public $selectedRole;
    public $clientRoleId;
    public $showCreateModal = false;
    public $clients;

    protected $listeners = [
        'toggleShowCreateUserModal'
    ];

    public $showDeletedOnly = false;

    // (optional) keep state in the URL: ?showDeletedOnly=1
    protected $queryString = [
        'showDeletedOnly' => ['except' => false],
    ];

    protected function rules()
    {
        return [
            'user.name' => 'required|min:2',
            'user.email' => 'required|email',
            'user.client_id' => 'nullable',
            // 'user.password' => 'required|min:8|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{8,}$/',
            'user.password' => 'required|min:4',
            'selectedRole' => 'in:' . Role::all()->pluck('id')->implode(',')
        ];
    }

    public function mount()
    {
        $this->user = User::make();
        $this->roles = Role::all();
        $this->clientRoleId = Role::findByName('Client', 'web')->id;
        $this->clients = Clients::all();
    }

    public function render()
    {
        return view('livewire.users.user-index')
            ->layoutData([
                'title' => 'Users',
                'buttonPermission' => 'view audits',
                'buttonAction' => 'toggleShowCreateUserModal',
                'buttonText' => 'create user'
            ]);
    }

    public function toggleShowCreateUserModal()
    {
        $this->showCreateModal = true;
    }

    public function resetFields()
    {
        $this->user->name = '';
        $this->user->email = '';
        $this->user->password = '';
        $this->selectedRole = '';
    }

    public function submit()
    {
        $this->validate();
        $newUser = User::make([
            'name' => $this->user->name,
            'email' => $this->user->email,
            'client_id' => $this->user->client_id,
            'password' => bcrypt($this->user->password)
        ]);

        if ($this->selectedRole != $this->clientRoleId) {
            $this->user->client_id = null;
        }

        $newUser->save();

        // Send welcome email with CC
        Mail::to($this->user->email)
            ->cc('xiiphoid@gmail.com')
            ->send(new WelcomeEmail($newUser, $this->user->password));

        $newUser->assignRole(Role::find($this->selectedRole));
        $this->resetFields();
        $this->showCreateModal = false;
        $this->emit('pg:eventRefresh-UserTable');
        session()->flash('message', 'New User created successfully!');
    }
}