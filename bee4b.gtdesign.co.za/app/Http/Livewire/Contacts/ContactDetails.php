<?php

namespace App\Http\Livewire\Contacts;

use App\Models\Activity;
use App\Models\Contact;
use App\Models\User;
use Livewire\Component;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;

class ContactDetails extends Component
{
    use AuthorizesRequests;

    public $contact;
    public $contact_backup;
    public $editing = false;
    public $showDeleteModal = false;
    public $breadcrumbs = [];
    public $tabs = [
        'overview', 'files', 'activity'
    ];
    public $currentTab = 'overview';
    public $showCreateUserModal = false;
    public $user;
    public $roles;
    public $clientSubUserRoleId;

    protected $rules = [
        'contact.client_id' => 'required',
        'contact.name' => 'required',
        'contact.jobtitle' => 'required',
        'contact.category' => 'required',
        'contact.email' => 'required',
        'contact.phone_primary' => 'required',
        'contact.phone_secondary' => 'required',

        'contact.contactable_type' => 'required',
        'contact.contactable_id' => 'required',

        'user.name' => 'required|min:2',
        'user.email' => 'required|email',
        'user.password' => 'required|min:4',
        'selectedRole' => 'required',
        'user.client_id'  => 'required|exists:clients,id',
    ];

    protected $listeners = [
        'newActivity',
        'refreshComponent' => '$refresh',
    ];

    protected $queryString = [
        'currentTab' => ['as' => 'tab']
    ];

    public $contactableModules = [
        'App\Models\ManagementProcess' => 'Management',
        'App\Models\Clients' => 'Clients'
    ];
    public $selectedModule = null;
    public $selectedRecord = null;
    public $records = [];
    public $selectedRole = '';
    
    public function updatedContact($value, $field)
    {
        if ($field !== 'contactable_type') return;

        $this->contact->contactable_id = '';

        if ( $value === '') {
            $this->selectedRecord = null;
            return;
        }

        $this->records = $value::all();
    } 

    public function mount($id)
    {
        $this->contact = Contact::find($id);
        
        $this->user = User::make();
        $this->user->name = $this->contact->firstname . ' ' . $this->contact->lastname;
        $this->user->email = $this->contact->email;

        $this->roles = Role::all();
        $this->selectedModule = isset($this->contact->contactable) ? get_class($this->contact->contactable) : null;
        $this->selectedRecord = $this->contact->contactable_id;
        $this->records = ($this->contact->contactable_type == '' || $this->contact->contactable_type == null) ? [] : $this->contact->contactable_type::all();

        $this->contact_backup = $this->contact;
        $this->breadcrumbs = ['Contacts', $this->contact->firstname . ' ' . $this->contact->lastname];

        $this->clientSubUserRoleId = Role::firstWhere('name', 'Client Sub User')->id;
    }

    public function render()
    {
        return view('livewire.contacts.contact-details', [
        'accessibleClients' => $this->accessibleClients,
        ]);
    }

    public function changeTab($tabName) 
    {
        $this->currentTab = $tabName;
    }

    public function newActivity($title, $body, $type)
    {
        $activity = Activity::make();

        $activity->user_id = Auth::id();
        $activity->title = ' ' . $title;
        $activity->body = $body;
        $activity->activity_type = $type;
        $this->contact->activities()->save($activity);
    }

    public function setEdit()
    {
        if($this->editing) {
            $this->contact = $this->contact_backup;
        }

        $this->editing = !$this->editing;
    }

    public function update()
    {
        $this->authorize('edit contacts');

        $this->validate([
            'contact.name' => 'required',
            'contact.email' => 'required',
            // 'contact.phone_primary' => 'required',
            // 'contact.phone_secondary' => 'required',

            'contact.contactable_type' => 'required',
            'contact.contactable_id' => 'required',
        ], [
            'contact.contactable_type.required' => 'Please select a module.',
            'contact.contactable_id.required' => 'Please select a record.',
            // 'contact.phone_primary.required' => 'The primary phone field is required.',
            // 'contact.phone_secondary.required' => 'The secondary phone field is required.',
        ]);

        $this->contact->save();

        $this->editing = false;

        $this->newActivity(
            'has updated a contact: ' . $this->contact->firstname . ' ' . $this->contact->lastname,
            '',
            'update'
        );

        $this->dispatchBrowserEvent('notify-success', ['message' => 'Contact updated successfully']);
        $this->emitSelf('refreshComponent');
    }

    public function delete($id)
    {
        $contact = \App\Models\Contact::find($id);

    if (! $contact) {
        return; // or throw 404
    }

    // 1️⃣ If this contact has a linked user, disable that account
    if ($contact->user_id) {
        $user = \App\Models\User::find($contact->user_id);
        if ($user) {
            $user->enabled = 0;    // or ->update(['status' => 0]);
            $user->save();
        }
    }

    // 2️⃣ Now delete the contact
    $contact->delete();       // or ->forceDelete(), depending on your setup

    // 3️⃣ Feedback & redirect
    $this->dispatchBrowserEvent('notify-success', [
        'message' => 'Contact deleted and linked user disabled.',
    ]);

        $this->newActivity(
            'has deleted a contact: ' . $this->contact->firstname . ' ' . $this->contact->lastname,
            '',
            'delete'
        );

        return redirect()->to('/contacts');
    }

    protected function generateInitials($name)
    {
        $words = explode(" ", $name);
        $initials = null;
        foreach ($words as $w) {
            if($w === '') return '';
            $initials .= $w[0];
        }
        return $initials;
    }

    public function getAccessibleClientsProperty()
    {
        $user = auth()->user();
        if ($user->hasAnyRole(['Client', 'Client Sub User'])) {
            $ids = array_filter(explode(',', $user->client_id));
            return \App\Models\Clients::whereIn('id', $ids)->get();
        }

        return \App\Models\Clients::all();
    }

    public function createUser()
    {
        if($this->contact->user_id !== null) return;

        $this->validate([
            'user.name'      => 'required|min:2|unique:users,name|regex:/^[^_^\/^\\\\]*$/',
            'user.email'     => 'required|email|unique:users,email',
            'user.password'  => 'required|min:4',
            'user.client_id' => 'required|exists:clients,id',
        ], [
            'user.name.regex'     => 'The name cannot contain slashes or underscores.',
            'user.password.*'     => 'Password must contain at least 8 characters, an uppercase letter, a lowercase letter and a number',
        ]);

        $new = \App\Models\User::create([
        'name'      => $this->user['name'],
        'email'     => $this->user['email'],
        'password'  => bcrypt($this->user['password']),
        'client_id' => $this->user['client_id'],
    ]);

    $new->syncRoles([$this->clientSubUserRoleId]);

    $this->contact->user_id = $new->id;
$this->contact->save();

        $this->showCreateUserModal = false;

        $this->dispatchBrowserEvent('notify-success', ['message' => 'User created successfully']);
    }
}
