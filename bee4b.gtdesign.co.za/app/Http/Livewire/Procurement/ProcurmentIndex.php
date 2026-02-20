<?php

namespace App\Http\Livewire\Procurement;

use App\Models\ProcurementLog;
use Livewire\Component;

class ProcurmentIndex extends Component
{
    protected $listeners = [
        'changeProcurementStatus',
        'createProcurement',
    ];

    public function render()
    {
        return view('livewire.procurement.procurment-index')
            ->layoutData([
                'title' => 'Procurement',
                'buttonPermission' => 'view clients',
                'buttonAction' => 'createProcurement',
                'buttonText' => 'Create'
            ]);
    }

    public function changeProcurementStatus($id)
    {
        $procurement = ProcurementLog::find($id);

        // 1.white -> 2.green -> 3.gray -> 1.white
        switch ($procurement->procurement_status_id) {
            case 1:
                $procurement->procurement_status_id = 2;
                break;
            case 2:
                $procurement->procurement_status_id = 3;
                break;
            case 3:
                $procurement->procurement_status_id = 1;
                break;
            default: 
                $procurement->procurement_status_id = 2;
        }

        $procurement->save();

        $this->emit('pg:eventRefresh-default');
    }

    public function createProcurement()
    {
        $this->emit('showCreateProcurementModal');
    }
}
