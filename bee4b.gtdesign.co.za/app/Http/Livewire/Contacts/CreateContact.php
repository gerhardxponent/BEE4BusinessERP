<?php

namespace App\Http\Livewire\Contacts;

use Livewire\Component;
use App\Models\Clients;
use App\Models\Contact;
use Illuminate\Validation\Rule;

class CreateContact extends Component
{
    public Contact $contact;
    public $clients;
    public $breadcrumbs = [];
    
    public $contactableModules = [
        'App\Models\ManagementProcess' => 'Management',
        'App\Models\Clients' => 'Clients'
    ];
    public $selectedModule = null;
    public $records = [];
    public $selectedRecord;
    public $modelName = null;

    public $module;
    public $client;

    public $showCreateContactModal = false;

    protected $listeners = [
        'toggleCreateContactModal'
    ];

    protected function rules()
    {
        return [
            'contact.client_id' => 'required',
            'contact.name' => 'required|regex:/^[^_^\/^\\\\]*$/',
            'contact.jobtitle' => 'nullable',
            'contact.category' => 'nullable|string|max:100',
            'contact.email' => ['required', Rule::unique('contacts', 'email')->ignore($this->contact->email)],
            'contact.phone_primary' => 'nullable',
            'contact.phone_secondary' => 'nullable',
        ];
    }

    protected $messages = [
        'contact.name.regex' => 'The name cannot contain slashes or underscores.',
    ];

    public function mount()
    {
        $this->contact = Contact::make(['client_id' => null]);
        $this->clients = Clients::all();
        $this->breadcrumbs = ['Contacts', 'Create Contact'];

        if (isset($this->client)) {
            $this->records = Clients::all();
            $this->selectedModule = 'App\Models\Clients';
            $this->selectedRecord = $this->client;
        }
    }

    public function render()
    {
        return view('livewire.contacts.create-contact');
    }

    public function toggleCreateContactModal()
    {
        $this->showCreateContactModal = true;
    }

    public function updatedSelectedModule($value)
    {
        if( $value === '') {
            $this->selectedRecord = null;
            return;
        }
        
        $this->records = $this->selectedModule::all();
    }

    public function submit()
    {
        $this->validate([
            'contact.name' => 'required|regex:/^[^_^\/^\\\\]*$/',
            'contact.jobtitle' => 'nullable',
            'contact.category' => 'nullable|string|max:100',
            'contact.email' => ['required', Rule::unique('contacts', 'email')->ignore($this->contact->email)],
            'contact.phone_primary' => 'nullable',
            'contact.phone_secondary' => 'nullable',
        ]);

        if($this->contact->client_id == "") $this->contact->client_id = null;

        $this->contact->contactable_id = $this->selectedRecord;
        $this->contact->contactable_type = $this->selectedModule;

        $this->contact->save();
        $this->contact = Contact::make(['client_id' => null]);
        $this->showCreateContactModal = false;

        $this->emit('pg:eventRefresh-contactsIndexTable');
        $this->emit('pg:eventRefresh-clientsContactsTable');
        $this->dispatchBrowserEvent('notify-success', ['message' => 'Contact created successfully']);
    }
}
