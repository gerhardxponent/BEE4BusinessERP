<?php

namespace App\Http\Livewire\Settings\Components;

use Livewire\Component;

class Sections extends Component
{
    public $sections = [
         'clients', 'projects', 'audit Fields', 'audit Templates', 'roles and permissions', 'lead email'
     ];
    public $currentSection = 'clients';

    public function render()
    {
        return view('livewire.settings.components.sections');
    }

    public function changeSection($section)
    {
        $this->currentSection = $section;
        $this->emit('sectionChanged', $section);
    }
}
