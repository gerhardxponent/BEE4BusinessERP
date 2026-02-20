<?php

namespace App\Http\Livewire\Users;

use App\Models\Module;
use App\Models\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;
use Spatie\Permission\Models\Role;

class UserDetails extends Component
{
    use AuthorizesRequests;

    public User $user;
    public $headerAttributes;
    public $userRoles;
    public $userPermissions; //permissions assigned directly to user
    public $modules;
    public $allRoles;
    public $selectedRole;
    public $editRole = false;
    public $showResetPasswordModal = false;
    public $showConfirmDeleteModal = false;
    public $newPassword;
    public $newPassword_confirmation;
    public $newUserId = null; // Selected user for task reassignment
    public $otherUsers = [];  // List of users except the one being deleted

    public $operations = [
        'create',
        'view',
        'edit',
        'delete'
    ];
    protected $rules = [
        'user.name' => 'required',
        'user.email' => 'required',

        'newPassword' => 'required',
        'newPassword_confirmation' => 'required',
    ];
    public $tabs = ['overview', 'permissions', 'tasks', 'files', 'activity'];
    public $currentTab = 'overview';
    protected $queryString = [
        'currentTab' => ['as' => 'tab']
    ];
    protected $listeners = [
        'successFlash',
        'errorFlash',
        'changeTab'
    ];

    public $breadcrumbs = [];

    public $editing = false;

    public $test = [];

    public function mount($id)
    {
        $this->user = User::find($id);
        $this->userRoles = $this->user->roles;
        $this->selectedRole = $this->user->roles[0]->id;
        $this->userPermissions = $this->user->getPermissionNames();
        $this->modules = Module::all();
        $this->allRoles = Role::all();

        $this->otherUsers = User::where('id', '!=', $id)
            ->where('enabled', 1) // only active users for reassignment
            ->get();

        $this->headerAttributes = [
            'Name' => $this->user->name,
            'Email' => $this->user->email,
            'Role' => $this->userRoles[0]->name
        ];

        $this->breadcrumbs = ['Users', $this->user->name];
    }

    public function render()
    {
        return view('livewire.users.user-details')
            ->layoutData([
                'backText' => 'all Users'
            ]);
    }

    public function successFlash($message)
    {
        session()->flash('success_message', $message);
    }
    public function errorFlash($message)
    {
        session()->flash('error_message', $message);
    }

    public function toggleEdit()
    {
        $this->editing = !$this->editing;
        $this->emit('editUser');
    }

    protected function generateInitials($name)
    {
        $words = explode(" ", $name);
        $initials = null;

        foreach ($words as $w) {
            if (!empty($w)) {
                $initials .= $w[0];
            }
        }
        return $initials;
    }

    public function changeTab($tabName)
    {
        $this->currentTab = $tabName;
        $this->editing = false;
        $this->emit('tab_changed');
    }

    public function changeRole()
    {
        if ($this->selectedRole != '') {
            $this->user->syncRoles([$this->selectedRole]);
            $this->userRoles = $this->user->roles;
            $this->editRole = false;
        }
    }

    public function update()
    {
        $this->emit('saveUser');
        $this->editing = false;

        // $this->user->save();
        // $this->changeRole();
        // $this->editing = false;
    }

    public function resetPassword()
    {
        $this->validate([
            'newPassword' => 'required|confirmed',
            'newPassword_confirmation' => 'required',
        ], [
            'required' => 'This field is required',
            'confirmed' => 'Passwords do not match'
        ]);

        $this->user->password = bcrypt($this->newPassword);
        $this->user->save();
        $this->showResetPasswordModal = false;

        session()->flash('success_message', 'Password reset successfully');
    }

    public function deleteUser()
    {
        if (!$this->newUserId) {
            session()->flash('error_message', 'You must select a user to reassign tasks.');
            return;
        }

        $newUser = User::find($this->newUserId);
        if (!$newUser || (int) $newUser->enabled !== 1) {
            session()->flash('error_message', 'Selected user is invalid or disabled.');
            return;
        }

        // ✅ Reassign tasks in user_board_items
        \DB::table('user_board_items')
            ->where('user_id', $this->user->id)
            ->update(['user_id' => $newUser->id]);

        // ✅ Rename 1:1 chat names before disable
        $chats = $this->user->chats()->where('isGroup', 0)->get();
        foreach ($chats as $chat) {
            $chat->name = $this->user->name . '-Disabled';
            $chat->save();
        }

        // ✅ Soft delete: mark disabled, do NOT remove record
        $this->user->enabled = 0;
        $this->user->save();

        // (Optional) revoke tokens/sessions if you use Sanctum/Passport
        // \DB::table('personal_access_tokens')->where('tokenable_id', $this->user->id)->delete();

        session()->flash('success_message', "User disabled and tasks reassigned to {$newUser->name}.");
        return redirect()->to('./users');
    }

    public function restoreUser()
    {
        if ((int) $this->user->enabled === 1) {
            session()->flash('success_message', 'User is already active.');
            return;
        }

        $this->user->enabled = 1;
        $this->user->save();

        session()->flash('success_message', 'User restored successfully.');
        // Refresh reassignment list now that this user is active again
        $this->otherUsers = User::where('id', '!=', $this->user->id)
            ->where('enabled', 1)
            ->get();
    }

}
