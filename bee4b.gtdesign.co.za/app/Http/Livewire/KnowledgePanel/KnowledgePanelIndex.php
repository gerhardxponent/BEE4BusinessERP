<?php

namespace App\Http\Livewire\KnowledgePanel;

use App\Models\Icon;
use App\Models\ResourceCategory;
use Livewire\Component;

class KnowledgePanelIndex extends Component
{
    public $newCategory;
    public $icons;
    public $showCreateCategoryModal = false;

    protected $rules = [
        'newCategory.name' => 'required',
        'newCategory.icon_id' => 'required',
    ];

    public function mount()
    {
        $this->newCategory = ResourceCategory::make();
        $this->icons = Icon::all();
    }

    public function getResourceCategoriesProperty()
    {
        return ResourceCategory::all();
    }

    public function render()
    {
        return view('livewire.knowledge-panel.knowledge-panel-index');
    }

    public function createCategory()
    {
        $this->validate([
            'newCategory.name' => 'required',
            'newCategory.icon_id' => 'required',
        ]);

        $this->newCategory->save();

        $this->newCategory = ResourceCategory::make();
        $this->showCreateCategoryModal = false;

        $this->dispatchBrowserEvent('notify-success', ['message' => 'Category successfully created']);
    }
}
