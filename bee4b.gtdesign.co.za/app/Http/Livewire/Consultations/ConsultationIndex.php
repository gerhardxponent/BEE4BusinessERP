<?php

namespace App\Http\Livewire\Consultations;

use Livewire\Component;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class ConsultationIndex extends Component
{
    use AuthorizesRequests;

    protected $listeners = [
        'consultationCreated'
    ];

    public function render()
    {
        return view('livewire.consultations.consultation-index')
            ->layoutData([
                'title' => 'Consultations',
                'buttonPermission' => 'create consultations',
                'buttonAction' => 'createConsultation',
                'buttonText' => 'Create Consultation'
            ]);
    }

    public function consultationCreated()
    {
        $this->emit('pg:eventRefresh-consultationsTable');
    }
}
