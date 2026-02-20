<?php

namespace App\Http\Livewire\Leads\Components;

use App\Models\Lead;
use Carbon\Carbon;
use Livewire\Component;

class Overview extends Component
{
    public $lead;
    public $editing = false;
    protected $rules = [
        'lead.name' => 'required|regex:/^[^_^\/^\\\\]*$/',
        'lead.primary_phone' => 'required',
        'lead.secondary_phone' => 'nullable',
        'lead.email_address' => 'nullable|email',
        'lead.company_name' => 'required|regex:/^[^_^\/^\\\\]*$/',
        'lead.website' => 'nullable',
        'lead.sector_id' => 'nullable',
        'lead.enquiry' => 'nullable',
        'lead.source' => 'nullable',
        'lead.description' => 'nullable',
        'lead.address' => 'nullable',
        'lead.city' => 'nullable',
        'lead.province' => 'nullable',
        'lead.country' => 'nullable',
    ];
    protected $messages = [
        'lead.name.regex' => 'The name cannot contain slashes or underscores.',
        'lead.first_name.regex' => 'The first name cannot contain slashes or underscores.',
        'lead.last_name.regex' => 'The last name cannot contain slashes or underscores.',
        'lead.company_name.regex' => 'The company name cannot contain slashes or underscores.',
    ];
    protected $listeners = [
        'toggleEditLead' => 'toggleEdit',
        'updateLead'
    ];

    public function render()
    {
        return view('livewire.leads.components.overview');
    }

    public function toggleEdit()
    {
        // Cancel
        if($this->editing) {
            $this->lead = Lead::find($this->lead->id);
        }

        $this->editing = !$this->editing;
    }

    public function updateLead()
    {
        $this->validate();
        $this->lead->save();
        $this->editing = false;
        $this->emitSelf('refreshComponent');
        // session()->flash('message', 'Changes saved successfully');
        $this->dispatchBrowserEvent('notify-success', ['message' => 'Changes saved successfully']);
    }

    public function getConsultationsProperty()
    {
        return $this->lead->consultable()
            ->where('starttime', '>=', Carbon::now())
            ->orderBy('starttime')
            ->limit(5)
            ->get();
    }

    public function getProjectsProperty()
    {
        return $this->lead
            ->boards()
            ->with('boardItems')
            ->whereHas('boardItems', fn($query) => $query->where('status_id', 1))
            ->get();
    }
}
