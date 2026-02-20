<?php

namespace App\Http\Livewire\AuditManagement;

use App\Models\Audit;
use App\Models\AuditReference;
use App\Models\Clients;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;

class AuditList extends Component
{
    public $auditReferences;
    public $newAudit;
    public $clients;
    public $showCreateAuditModal = false;
    
    protected $listeners = [
        'createAudit'
    ];

    protected $rules = [
        'newAudit.name' => 'required',
        'newAudit.client_id' => 'required'
    ];

    public function mount()
    {
        $this->auditReferences = AuditReference::all();
        $this->newAudit = Audit::make();
        $this->clients = Clients::all();
    }

    public function render()
    {
        return view('livewire.audit-management.audit-list')
            ->layoutData([
                'title' => 'Audits',
                'buttonPermission' => 'create audits',
                'buttonAction' => 'createAudit',
                'buttonText' => 'Create Audit'
            ]);
    }

    public function createAudit()
    {
        return redirect()->to('audits/create');
        // $this->newAudit->save();
        // return redirect()->to("audits/{$this->newAudit->id}");
    }

    public function defaultsRedirect()
    {
        return redirect()->to('/audit-defaults');
    }

    public function showDeleted()
    {
        $this->emit('toggleShowDeleted');
    }
}
