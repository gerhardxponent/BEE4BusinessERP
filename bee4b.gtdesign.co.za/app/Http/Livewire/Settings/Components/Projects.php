<?php

namespace App\Http\Livewire\Settings\Components;

use App\Models\DefaultTask;
use App\Models\Phase;
use App\Models\Priority;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Projects extends Component
{
    protected $listeners = ['refreshProjectSettings' => '$refresh'];

    public $activeItem;
    public $editItem = false;
    public $allTags;
    public $showCreateItemModal = false;
    public $showDeleteItemModal = false;
    public $newItem;
    public $newSubtask;
    public $allPriorities;
    public $currentUser;
    public $isSubtask = false;

    public $tabs = [ 'subtasks', 'details' ];
    public $currentTab = 'subtasks';

    public $showCreatePhaseModal = false;

    public $newPhase;

    protected $rules = [
        'activeItem.name' => 'required',
        'activeItem.description' => 'required',
        'activeItem.priority' => 'required',
        'activeItem.priority_id' => 'required',

        'newItem.name' => 'required',
        'newItem.description' => 'required',
        'newItem.priority' => 'required',
        'newItem.phase_id' => 'required',
        'newItem.priority_id' => 'required',
        'newItem.parent_id' => 'required',

        'newSubtask.name' => 'required',
        'newSubtask.priority' => 'required',

        'newPhase.name' => 'required',
    ];

    public function mount()
    {
        // $this->phases = Phase::all();
        $this->currentUser = User::find(Auth::id());
        $this->activeItem = DefaultTask::make();
        $this->allTags = Tag::all();
        $this->newItem = DefaultTask::make();
        $this->newSubtask = DefaultTask::make();
        $this->allPriorities = Priority::all();
        $this->newPhase = Phase::make();
    }

    public function render()
    {
        return view('livewire.settings.components.projects');
    }

    public function getPhasesProperty()
    {
        return Phase::orderByRaw('-position DESC')->get();
    }

    public function changeTab($tab)
    {
        $this->currentTab = $tab;
        // $this->editing = false;
        $this->editItem = false;
    }

    public function setActiveItem($id)
    {
        $this->activeItem = DefaultTask::find($id);
        if ($this->activeItem->parent_id !== null) {
            $this->tabs = ['details'];
            $this->currentTab = 'details';
        } else {
            $this->tabs = ['subtasks', 'details'];
        }
    }

    public function toggleEditItem()
    {
        if ($this->editItem) {
            $this->editItem = false;
        } else {
            $this->editItem = true;
        }
    }

    public function saveItem()
    {
        $this->activeItem->save();
        $this->editItem = false;

        $this->emit('refreshProjectSettings');
    }

    public function createItem()
    {
        $this->validate([
            'newItem.phase_id' => 'required',
            'newItem.name' => 'required',
        ], [
            'newItem.phase_id.required' => 'The phase field is required',
        ]);

        $position = count(Phase::find($this->newItem->phase_id)->defaultItems()->where('parent_id', null)->get()) + 1;
        $this->newItem->position = $position;
        $this->newItem->save();

        $this->showCreateItemModal = false;
        $this->newItem = DefaultTask::make();
        $this->emit('refreshProjectSettings');
    }

    public function deleteItem()
    {
        $this->activeItem->delete();
        $this->activeItem = DefaultTask::make();

        $this->showDeleteItemModal = false;
        $this->emit('refreshProjectSettings');
    }

    public function deleteSubtask($id)
    {
        DefaultTask::find($id)->delete();

        $this->emit('refreshProjectSettings');
    }

    // public function updateTaskOrder($list)
    // {
    //     foreach($list as $item) {
    //         DefaultTask::find($item['value'])->update(['position' => $item['order']]);
    //     }

    //     $this->emitSelf('refreshProjectSettings');
    // }

    public function newSubtask()
    {
        $this->isSubtask = true;
        $this->newItem->phase_id = $this->activeItem->phase_id;
        $this->newItem->parent_id = $this->activeItem->id;
        $this->showCreateItemModal = true;

        $this->emit('updateNamedSelect2', [
            'elementName' => 'project_settings_phase'
        ]);
    }

    public function cancelCreateItem()
    {
        $this->newItem = DefaultTask::make();
        $this->showCreateItemModal = false;
        $this->emit('updateSelect2');
    }

    public function createPhase()
    {
        $this->newPhase->save();
        $this->showCreatePhaseModal = false;
        $this->emit('updateData', [
            'id' => $this->newPhase->id,
            'text' => $this->newPhase->name,
            'elementName' => 'project_settings_phase',
        ]);
        $this->newPhase = Phase::make();
        $this->emit('updateSelect2');
    }

    public function updateGroupOrder($list)
    {
        foreach($list as $item) {
            Phase::find($item['value'])->update(['position' => $item['order']]);
        }
    }

    public function updateTaskOrder($list)
    {
        $updates = [];

        foreach ($list as $group) {
            foreach ($group['items'] as $item) {
                array_push($updates, [
                    'id' => $item['value'],
                    'position' => $item['order'],
                ]);
            }
        }

        DB::table('default_tasks')->upsert($updates, 'id', ['position']);
    }
}
