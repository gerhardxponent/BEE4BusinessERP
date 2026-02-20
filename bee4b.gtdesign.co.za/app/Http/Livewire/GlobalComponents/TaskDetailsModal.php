<?php

namespace App\Http\Livewire\GlobalComponents;

use App\Models\BoardItem;
use App\Models\Clients;
use App\Models\Colour;
use App\Models\Phase;
use App\Models\Priority;
use App\Models\Tag;
use App\Models\User;
use Livewire\Component;

class TaskDetailsModal extends Component
{
    public $task;
    public $showModal = false;
    public $tabs = ['details', 'files', 'comments', 'subtasks'];
    public $currentTab = 'details';
    public $editing = true;
    public $currentTags = [];
    public $assignedUsers = [];

    protected $listeners = [
        'showTaskDetailsModal',
        'taskClicked',
    ];

    protected $rules = [
        'task.name' => 'required',
        'task.description' => 'required',
        'task.priority' => 'required',
        'task.deadline' => 'required',
        'task.tags' => 'required',

        'newItem.name' => 'required',
        'newItem.description' => 'required',
        'newItem.priority' => 'required',
        'newItem.deadline' => 'required',
        'newItem.phase_id' => 'required',
        'newItem.priority_id' => 'required',
        'newItem.responsible_person' => 'required',
        'newItemTags' => 'required',
        'newItemClient' => 'required',
        'newItemBoard' => 'required',

        'newTag.name' => 'required',
        'newTag.color' => 'required',
        'newTag.colour_id' => 'required',

        'newPriority.name' => 'required',

        'newBoard.name' => 'required',
    ];

    public function mount($taskId = null)
    {
        $this->task = BoardItem::make();
    }

    public function render()
    {
        return view('livewire.global-components.task-details-modal');
    }

    public function changeTab($tab)
    {
        $this->currentTab = $tab;
        $this->editing = false;
    }

    public function getAllTagsProperty() { return Tag::all(); }
    public function getPhasesProperty() { return Phase::all(); }
    public function getPrioritiesProperty() { return Priority::all(); }
    public function getAllUsersProperty() { return User::all(); }
    public function getAllClientsProperty() { return Clients::all(); }
    public function getColoursProperty() { return Colour::all(); }

    public function taskClicked($taskId)
    {
        $this->task = BoardItem::find($taskId);
        $this->currentTags = $this->task->tags->pluck('id')->toArray();
        $this->assignedUsers = $this->task->assignedUsers->pluck('id')->toArray();
        $this->showModal = true;
    }

    public function updateTask()
    {
        $this->task->save();
        $this->task->assignedUsers()->sync($this->assignedUsers);
        $this->task->tags()->sync($this->currentTags);

        $this->editing = false;
        $this->emit('refreshKanban');
        // $this->emit('refreshTasks');
    }
}
