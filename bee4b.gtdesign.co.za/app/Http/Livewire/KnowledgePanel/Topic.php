<?php

namespace App\Http\Livewire\KnowledgePanel;

use App\Models\Resource;
use App\Models\ResourceCategory;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;

class Topic extends Component
{
    use AuthorizesRequests;

    public $resourceCategory;
    public $resource;
    public $editing = false;
    public $showConfirmDeleteModal = false;

    protected $rules = [
        'resource.title' => 'required',
        'resource.content' => 'required',
    ];

    public function mount($categoryID, $resourceID)
    {
        $this->resourceCategory = ResourceCategory::find($categoryID);
        $this->resource = Resource::find($resourceID);
    }

    public function render()
    {
        return view('livewire.knowledge-panel.topic')
            ->layoutData([
                'backText' => 'all ' . $this->resourceCategory->name,
                'backLink' => '/../resources/' . $this->resourceCategory->id,
            ]);
    }

    public function update()
    {
        $this->authorize('edit knowledge-panel');
        $this->validate();

        $this->resource->save();
        $this->editing = false;

        $this->dispatchBrowserEvent('notify-success', ['message' => 'Topic updated successfully']);
    }

    public function deleteTopic()
    {
        $this->authorize('delete knowledge-panel');
        $this->resource->delete();

        // $this->dispatchBrowserEvent('notify-success', ['message' => 'Topic deleted successfully']);
        
        return redirect()->to('./resources/' . $this->resourceCategory->id);
    }
}
