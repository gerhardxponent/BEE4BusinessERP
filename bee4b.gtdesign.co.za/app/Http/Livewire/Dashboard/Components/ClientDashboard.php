<?php

namespace App\Http\Livewire\Dashboard\Components;

use App\Models\Month;
use Livewire\Component;
use Livewire\WithPagination;

class ClientDashboard extends Component
{
    use WithPagination;

    public $perPage = 2;

    public function render()
    {
        return view('livewire.dashboard.components.audit-dashboard');
    }

    public function getMonthsProperty()
    {
        return Month::with('clients')->with('clients.getAnalyst')->get();
    }

    protected function generateInitials($name)
    {
        $words = explode(" ", trim($name));
        if (count($words) == 0) return "";
        
        $initials = "";
        foreach ($words as $w) {
            $initials .= $w[0];
        }
        return $initials;
    }
}
