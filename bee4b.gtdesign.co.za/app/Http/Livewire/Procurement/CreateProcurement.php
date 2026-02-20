<?php

namespace App\Http\Livewire\Procurement;

use App\Jobs\EmailJob;
use App\Models\Board;
use App\Models\Clients;
use App\Models\ProcurementLog;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class CreateProcurement extends Component
{
    public ProcurementLog $procurementLog;
    public $showCreateModal = false;
    public $clients;
    public $users;
    public $projects;

    protected $rules = [
        'procurementLog.client_id' => 'required',
        'procurementLog.date_allocated' => 'nullable',
        'procurementLog.due_date' => 'nullable',
        'procurementLog.pp_analyst_id' => 'nullable',
        'procurementLog.fye' => 'nullable',
        'procurementLog.board_id' => 'nullable',
        'procurementLog.scorecard_number' => 'nullable',
        'procurementLog.notes' => 'nullable',
    ];

    protected $listeners = [
        'showCreateProcurementModal'
    ];

    public function mount()
    {
        $this->procurementLog = ProcurementLog::make();
        $this->clients = Clients::all();
        $this->users = User::all();
        $this->projects = Board::all();
    }

    public function render()
    {
        return view('livewire.procurement.create-procurement');
    }

    public function updatedProcurementLogClientId($value)
    {
        $this->projects = Board::where([
            ['boardable_type', 'App\\Models\\Clients'],
            ['boardable_id', $value]
        ])->get();
    }

    public function createLog()
    {
        $this->procurementLog->procurement_status_id = 1;
        $this->procurementLog->save();
        $this->showCreateModal = false;

        $ppAnalystEmail = $this->procurementLog->ppAnalyst->email ?? null;
        // $analystEmail = 
        //     ($this->procurementLog->board->analyst == null || $this->procurementLog->board->analyst == $ppAnalystEmail) ?
        //     null :
        //     $this->procurementLog->board->analyst->email ?? null;

        $board = $this->procurementLog->board ?? null; // Safely check if board exists

        $analystEmail = ($board === null || $board->analyst === null || $board->analyst->email === $ppAnalystEmail) ?
    null :$board->analyst->email ?? null;

        dispatch(
            new EmailJob(
                $ppAnalystEmail,
                $analystEmail,
                'ERP',
                'New procurement ',
                'A new procurement log was created',
                url('/procurement')
            )
        );

        $this->procurementLog = ProcurementLog::make();

        $this->emit('pg:eventRefresh-default');
    }

    public function showCreateProcurementModal()
    {
        $this->showCreateModal = true;
    }
}
