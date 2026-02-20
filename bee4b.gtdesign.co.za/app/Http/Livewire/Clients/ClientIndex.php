<?php

namespace App\Http\Livewire\Clients;

use App\Models\Clients;
use App\Models\Size;
use Carbon\Carbon;
use Livewire\Component;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Storage;
use Livewire\WithFileUploads;
use PhpOffice\PhpWord\IOFactory;
use PhpOffice\PhpWord\PhpWord;
use Illuminate\Support\Facades\Auth;

class ClientIndex extends Component
{
    use AuthorizesRequests;
    use WithFileUploads;

    public $restoreModal = false;
    public $restoringClient;

    protected $listeners = [
        'createClient',
        'showRestoreModal',
    ];

    public function readWord()
    {
        $phpWord = IOFactory::load(Storage::path('/testWord2.docx'));
        
        dd($phpWord);
    }

    public function showRestoreModal($id)
    {
        $this->restoreModal = true;
        $this->restoringClient = Clients::withTrashed()->find($id);
    }

    public function mount()
    {
        // $client = Clients::first();
        // // dd(Carbon::parse($client->planned_audit_date)->month);

        // dd(Clients::codes()->firstWhere('code', Carbon::parse($client->planned_audit_date)->month)['label']);
    }

    public function render()
    {
        $title = (Auth::user()->hasRole('Client') || Auth::user()->hasRole('Client Sub User'))
            ? 'Companies'
            : 'Clients';

        return view('livewire.clients.client-index')
            ->layoutData([
                'title' => $title,
                'buttonPermission' => 'create clients',
                'buttonAction' => 'createClient',
                'buttonText' => 'Create Client'
            ]);
    }

    public function createClient() 
    {
        $this->authorize('create clients');
        return redirect()->to('/clients/create'); 
    }

    public function restore()
    {
        $this->restoringClient->restore();
        $this->restoreModal = false;
        $this->emit('pg:eventRefresh-default');
    }

    public function permanentlyDelete()
    {
        $this->restoringClient->forceDelete();
        $this->restoreModal = false;
        $this->emit('pg:eventRefresh-default');
    }
}
