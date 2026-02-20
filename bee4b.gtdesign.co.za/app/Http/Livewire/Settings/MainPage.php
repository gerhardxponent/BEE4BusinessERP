<?php

namespace App\Http\Livewire\Settings;

use Livewire\Component;

class MainPage extends Component
{
    public $currentSection = 'clients';

    protected $listeners = ['sectionChanged' => 'setSection'];

    protected $queryString = [
        'currentSection' => ['as' => 'section']
    ];

    public function setSection(string $section): void
{
    $this->currentSection = $section;
}

    public function render()
    {
        return view('livewire.settings.main-page', [
            'currentSection' => $this->currentSection,
        ]);
    }

    public function sectionChanged($section)
    {
        $this->currentSection = $section;
    }
}
