<?php

namespace App\Http\Livewire\Leads;

use App\Models\Lead;
use Livewire\Component;

class LeadIndex extends Component
{
    public $restoringLead;
    public $restoreModal = false;

    protected $listeners = [
        'createLead',
        'showRestoreModal',
        'changeLeadStatus'
    ];

    public function render()
    {
        return view('livewire.leads.lead-index')
            ->layoutData([
                'title' => 'Leads',
                'buttonPermission' => 'create leads',
                'buttonAction' => 'createLead',
                'buttonText' => 'Create Lead'
            ]);
    }

    public function createLead()
    {
        return redirect()->to('/leads/create');
    }

    public function showRestoreModal($id)
    {
        $this->restoreModal = true;
        $this->restoringLead = Lead::withTrashed()->find($id);
    }

    public function restore()
    {
        $this->restoringLead->restore();
        $this->restoreModal = false;
        $this->emit('pg:eventRefresh-default');
    }

    public function permanentlyDelete()
    {
        $this->restoringLead->forceDelete();
        $this->restoreModal = false;
        $this->emit('pg:eventRefresh-default');
    }

    public function changeLeadStatus($id)
    {

        $lead = Lead::withTrashed()->find($id);
        
        // 1.green -> 3.red -> 2.yellow -> 1.green

        if(!empty($lead->lead_status_id)){
            switch ($lead->lead_status_id) {
                case 1:
                    $lead->lead_status_id = 3;
                    break;
                case 2:
                    $lead->lead_status_id = 1;
                    break;
                case 3:
                    $lead->lead_status_id = 2;
                    break;
                default: 
                    $lead->lead_status_id = 1;
            }
        }
        else{
            $lead->lead_status_id = 2;
        }
        $lead->save();
        $this->emit('pg:eventRefresh-default');
    }
}
