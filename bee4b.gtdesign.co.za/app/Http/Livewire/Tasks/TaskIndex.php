<?php

namespace App\Http\Livewire\Tasks;

use App\Http\Livewire\Clients\ClientsTable;
use App\Jobs\CommentMentionEmail;
use App\Models\Activity;
use App\Models\Board;
use App\Models\BoardItem;
use App\Models\Clients;
use App\Models\Colour;
use App\Models\Comment;
use App\Models\DefaultTask;
use App\Models\File;
use App\Models\Tag;
use App\Models\User;
use App\Models\Phase;
use App\Models\Priority;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\WithFileUploads;

class TaskIndex extends Component
{
    use WithFileUploads;

    /** Filters */
    public $filterUserId;          // null|int|'all'
    public $filterDueStart = null; // 'YYYY-MM-DD' or null
    public $filterDueEnd   = null; // 'YYYY-MM-DD' or null

    public $currentTask;
    public $currentTags = [];
    public $assignedUsers = [];
    public $listeners = [
        'taskClicked', 
        'changeStatus', 
        'refreshTasks' => '$refresh', 
        'filesProcessed',
        'createTask',
    ];

    public function createTask()
    {
        $this->showCreateItemModal = true;
    }

    public $tabs = ['details', 'files', 'comments', 'subtasks'];
    public $currentTab = 'details';
    public $showTaskDetailsModal = false;
    public $title;
    public $viewAll = false;
    public $editing = true;
    public $files = [];
    public $enableUpload = false;
    public $usersForComment;
    public $itemComment;

    public $newItem;
    public $newItemTags = [];
    public $newItemUsers = [];
    public $newItemClient = "";
    public $newItemBoard = '';
    public $newItemPhase;
    public $newItemParent;
    public $boardTasks;

    public $clientBoards = [];
    public $isSubtask = false;
    public $newTag;
    public $newPriority;
    public $newBoard;

    public $showCreateItemModal = false;
    public $showCreateTagModal = false;
    public $showCreatePriorityModal = false;
    public $showConfirmDeleteModal = false;
    public $accessDeniedModal = false;

    protected $rules = [
        'currentTask.name' => 'required',
        'currentTask.description' => 'required',
        'currentTask.priority' => 'required',
        'currentTask.deadline' => 'required',
        'curretTask.tags' => 'required',
        'itemComment.body' => 'requried',

        'newItem.name' => 'required',
        'newItem.description' => 'required',
        'newItem.priority' => 'required',
        'newItem.deadline' => 'required',
        'newItem.phase_id' => 'required',
        'newItem.priority_id' => 'required',
        'newItem.responsible_person' => 'required',
        'newItem.parent_id' => 'nullable',
        'newItemTags' => 'required',
        'newItemClient' => 'required',
        'newItemBoard' => 'required',

        'newTag.name' => 'required',
        'newTag.color' => 'required',
        'newTag.colour_id' => 'required',

        'newPriority.name' => 'required',

        'newBoard.name' => 'required',
    ];

    public function mount()
    {
        // $testTask = BoardItem::find(154);
        // dd($testTask->tags->pluck('id')->toArray());

        $this->currentTask = BoardItem::make();
        $this->title = Auth::user()->name . '\'s Tasks';
        $this->usersForComment = User::select('id', 'name')->get()->map(function($user) {
            return [
                'key' => $user->name,
                'value' => $user->name,
                'id' => $user->id
            ];
        });
        $this->itemComment = Comment::make();
        $this->newItem = BoardItem::make();
        array_push($this->newItemUsers, Auth::id());

        $this->newTag = Tag::make();
        $this->newTag->colour_id = 1;
        $this->newPriority = Priority::make();
        $this->newBoard = Board::make();

        $this->boardTasks = collect([]);

        // default user filter
        // If user can view all -> show "All"; else lock to themselves
        $this->filterUserId = auth()->user()->can('view all tasks') ? 'all' : auth()->id();
    }

    public function render()
    {
        return view('livewire.tasks.task-index')
            ->layoutData([
                'title' => 'Tasks',
                'titleButtonIcon' => 
                    '<svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-filter" width="24" height="24" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                        <path d="M5.5 5h13a1 1 0 0 1 .5 1.5l-5 5.5l0 7l-4 -3l0 -4l-5 -5.5a1 1 0 0 1 .5 -1.5"></path>
                    </svg>',
                'titleButtonAction' => 'toggleFilters',
                'buttonAction' => 'createTask',
                'buttonText' => 'New Task',
                'buttonPermission' => 'create tasks',       
            ]);
    }

    public function getAllTagsProperty() { return Tag::all(); }
    public function getPhasesProperty() { return Phase::all(); }
    public function getPrioritiesProperty() { return Priority::all(); }
    public function getAllUsersProperty() { return User::all(); }
    public function getAllClientsProperty() { return Clients::all(); }
    public function getColoursProperty() { return Colour::all(); }

    public function updatedNewItemClient($value)
    {
        if($value == '') return;
        $this->clientBoards = Clients::find($this->newItemClient)->boardsMorph;
    }

    public function updatedNewItemPhase($value)
    {
        $this->newItem->phase_id = $value;
        $this->boardTasks = BoardItem::where('board_id', $this->newItemBoard)->where('phase_id', $value)->get();
    }

    public function newActivity($title, $body, $type)
    {
        $activity = Activity::make();

        $activity->user_id = Auth::id();
        $activity->title = ' ' . $title;
        $activity->body = $body;
        $activity->activity_type = $type;
        $this->client->activities()->save($activity);
    }

    public function createItem()
    {
        // $this->validate([
        //     'newItemClient' => 'required',
        //     'newItemBoard' => 'required',
        //     'newItem.phase_id' => 'required',
        //     'newItem.name' => 'required',
        //     'newItem.priority_id' => 'required',
        // ], [
        //     'newItemClient.required' => 'The client field is required',
        //     'newItemBoard.required' => 'The project field is required',
        //     'newItem.phase_id.required' => 'The phase field is required',
        //     'newItem.name.required' => 'The name field is required',
        //     'newItem.priority_id.required' => 'The priority field is required',
        // ]);

        $selectedBoard = Board::find($this->newItemBoard);

        if(!$this->isSubtask) {
            $last = $selectedBoard->boardItems
            ->where('phase_id', $this->newItem->phase_id)
            ->sortByDesc('position')
            ->first();

            if(isset($last->position)) {
                $last = ++$last->position;
            } else {
                $last = 1;
            }

            $this->newItem->position = $last;
        } else {
            $this->newItem->parent_id = $this->activeItem->id;
        }
        $this->newItem->board_id = $selectedBoard->id;
        $this->newItem->board_id = $selectedBoard->id;
        $this->newItem->created_by = Auth::id();
        $this->newItem->status = 'inactive';
        $this->newItem->save();

        $this->newItem->tags()->sync($this->newItemTags);
        $this->newItem->assignedUsers()->attach($this->newItemUsers);

        $this->showCreateItemModal = false;

        // $this->newActivity(
        //     'created a new task',
        //     '<span class="font-bold">' . 
        //     Auth::user()->name . 
        //     '</span> has created a new task in: <div>'.
        //     $this->activeBoard->name.' / '. 
        //     (isset($this->activeItem->phase->name) ? $this->activeItem->phase->name : '') . 
        //     ' named: <span class="font-bold">'.
        //     $this->newItem->name.'</span></div>',
        //     'new task'
        // );

        $this->newItem = BoardItem::make();
        $this->newItemTags = [];
        $this->newItemUsers = [];
        // array_push($this->newItemUsers, Auth::id());

        $this->emit('updateSelect2');
        $this->emit('refreshProjects');
        $this->emit('itemAdded');
        $this->emit('refreshKanban');
    }

    public function changeTab($tab)
    {
        $this->currentTab = $tab;
        $this->editing = false;
    }

    protected function generateInitials($name)
    {
        $words = explode(" ", $name);
        $initials = null;
        foreach ($words as $w) {
            $initials .= $w[0];
        }
        return $initials;
    }

    public function filesProcessed() { $this->enableUpload = true; }

    public function changeStatus($id)
    {
        $item = BoardItem::find($id);

        if($item->status == 'active') {
            $item->status = 'complete';
            $item->completed_at = Carbon::now()->format('Y-m-d');
        } else if($item->status == 'complete') {
            $item->status = 'inactive';
        } else if($item->status == 'inactive') {
            $item->status = 'active';
        }

        $item->save();
        $this->emit('pg:eventRefresh-task-table');
    }

    public function taskClicked($id)
    {
        $this->currentTask = BoardItem::find($id);
        $this->currentTags = $this->currentTask->tags->pluck('id')->toArray();
        $this->assignedUsers = $this->currentTask->assignedUsers->pluck('id')->toArray();
        // dd($this->currentTask->board->client);
        // dd($this->currentTags);
        $this->currentTab = 'details';
        $this->showTaskDetailsModal = true;

        $this->emit('updateSelect2');
    }

    public function toggleViewAll()
    {
        if($this->viewAll) {
            $this->viewAll = false;
            $this->title = Auth::user()->name . '\'s Tasks';
        } else {
            $this->viewAll = true;
            $this->title = 'All Tasks';
        }
        $this->emit('toggleViewAll');
    }

    public function updateTask()
    {
        $this->currentTask->save();
        $this->currentTask->assignedUsers()->sync($this->assignedUsers);
        $this->currentTask->tags()->sync($this->currentTags);

        $this->editing = false;
        // $this->emit('pg:eventRefresh-task-table');
        $this->emit('refreshKanban');
        $this->emit('refreshTasks');
    }

    public function uploadFiles()
    {
        $fileNames = '';
        $client = $this->currentTask->board->client??null;

        foreach($this->files as $file) {
            $fileDetails = File::make();
            $fileDetails->file_name = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);

            if($fileDetails->where('file_name', $fileDetails->file_name)->exists()) {
                $fileDetails->file_name = 'copy_' . $fileDetails->file_name . '_' . date('d-m-y_h-i');
            }

            $fye = $client->fye ?? '';
            $phase_name = $this->currentTask->phase->name?? '';
            $client_name = $client->name?? '';
            $fileDetails->file_path = 
                'uploads/' . 
                preg_replace('/\s+/', '_', $client_name) . 
                '/' .
                $fye .
                '/tasks/' . 
                $phase_name . 
                '/' . 
                preg_replace('/\s+/', '_', $this->currentTask->name);
            $fileDetails->client_id = $client->id??'';
            $fileDetails->user_id = Auth::id();
            $fileDetails->file_size = $file->getSize()/1024;
            $fileDetails->type = $file->getClientOriginalExtension();
            $fileDetails->status = 'Accepted';

            $file->storeAs(
                'uploads/' . 
                preg_replace('/\s+/', '_', $client_name) . 
                '/' .
                $fye .
                '/tasks/' . $phase_name . 
                '/' . 
                preg_replace('/\s+/', '_', $this->currentTask->name), 
                $fileDetails->file_name . '.' . $file->getClientOriginalExtension()
            );

            $this->currentTask->files()->save($fileDetails);

            $fileNames .= '<div wire:click="$emit(\'openFileDetails\', '.$fileDetails->id.')" class="text-blue-600 cursor-pointer hover:underline">' . $fileDetails->file_name . '.' . $fileDetails->type . '</div>';
        }

        $this->emit('refreshTasks');
        $this->emit('all_files_uploaded');
        $this->enableUpload = false;
        // $this->emit('pg:eventRefresh-task-table');
    }

    public function postComment()
    {
        if($this->itemComment->body == '') return;

        preg_match_all('/@(\d+)@/', $this->itemComment->body, $matches);
        if(count($matches[1]) > 0) {
            foreach($matches[1] as $id) {
                $to_email = User::find($id)->email;
                dispatch(new CommentMentionEmail($to_email, Auth::user()->name, $this->itemComment->body));
            }
        }

        $this->itemComment->user_id = Auth::id();

        $this->currentTask->comments()->save($this->itemComment);

        // $this->newActivity(
        //     'left a comment on task',
        //     '<div class="text-sm text-gray-600 font-bold">'.$this->activeBoard->name.' / '.$this->activeItem->phase->name.' / '.$this->activeItem->name.'</div><div class="mt-2">'.$this->itemComment->body.'</div>',
        //     'comment post'
        // );

        $this->itemComment = Comment::make();

        $this->emit('refreshTasks');
        $this->emit('commentPosted');
    }

    public function setTagColour($id)
    {
        $this->newTag->colour_id = $id;
    }

    public function createTag()
    {
        // if($this->newTag->color == '' || $this->newTag == null) return;

        $this->newTag->save();
        
        $this->emit('updateData', [
            'id' => $this->newTag->id,
            'text' => $this->newTag->name,
            'elementName' => 'tagSelect-item-creation',
        ]);

        $this->showCreateTagModal = false;
        $this->newTag = Tag::make();
        $this->newTag->colour_id = 1;
    }

    public function createPriority()
    {
        $this->newPriority->save();

        $this->emit('updateData', [
            'id' => $this->newPriority->id,
            'text' => $this->newPriority->name,
            'elementName' => 'priority_new_item'
        ]);

        $this->showCreatePriorityModal = false;
        $this->newPriority = Priority::make();
    }

    public function newSubtask()
    {
        $this->showTaskDetailsModal = false;
        $this->newItemClient = $this->currentTask->board->client_id;
        $this->clientBoards = Clients::find($this->newItemClient)->boards??'';
        $this->newItem->phase_id = $this->currentTask->phase_id;
        $this->showCreateItemModal = true;
    }

    public function setCompleted($id)
    {
        $item = BoardItem::find($id);

        //New
        if($item->status == 'inactive') $item->status = 'active';
        else if($item->status == 'active') $item->status = 'complete';
        else if($item->status == 'complete') $item->status = 'inactive';

        // $this->newActivity(
        //     'has marked a task as ' . ($item->completed == 0 ? 'uncomplete' : 'complete'),
        //     'Task: ' . '<span class="font-bold">'. $item->name .'</span>' . ' from Client: <span class="font-bold">' . $this->client->name . '</span>, Project: <span class="font-bold">' . $item->board->name . '</span> has been marked as ' . ($item->completed == 0 ? 'uncomplete' : 'complete'),
        //     'task status change'
        // );

        $item->save();

        $this->emit('refreshTasks');
    }

    public function deleteTask()
    {
        if (Auth::user()->hasPermissionTo('delete tasks')) {
            $this->currentTask->delete();

            $this->showConfirmDeleteModal = false;
            $this->showTaskDetailsModal = false;

            $this->emit('pg:eventRefresh-task-table');
        } else {
            $this->accessDeniedModal = true;
        }
    }

    public function createBoard()
    {
        $client = Clients::find($this->newItemClient);

        $this->validate([
            'newBoard.name' => 
                Rule::unique('boards', 'name')->where(function($query) use($client) {
                    $query->where([
                        ['boardable_id', $client->id],
                        ['boardable_type', 'App\\Models\\Clients']
                    ]);
                }),
        ], [
            'newBoard.name.unique' => 'Board already exists'
        ]);

        $this->newBoard->consultant_id = $client->manager;
        $this->newBoard->analyst_id = $client->analyst;

        $client->boardsMorph()->save($this->newBoard);

        // if($this->includeDefaults) {
            $defaultTasks = DefaultTask::all();

            foreach($defaultTasks->where('parent_id', null) as $df) {
                $newItem = BoardItem::make();

                $newItem->name = $df->name;
                $newItem->description = $df->description;
                $newItem->priority_id = $df->priority_id;
                $newItem->deadline = $df->deadline;
                $newItem->completed = 0;
                $newItem->created_by = Auth::id();
                $newItem->phase_id = $df->phase_id;
                $newItem->position = $df->position;

                $this->newBoard->boardItems()->save($newItem);

                foreach($df->subTasks as $subTask) {
                    $newSubItem = BoardItem::make();;
                    
                    $newSubItem->name = $subTask->name;
                    $newSubItem->description = '';
                    $newSubItem->priority = $subTask->priority;
                    $newSubItem->completed = 0;
                    $newSubItem->created_by = Auth::id();
                    $newSubItem->phase_id = $subTask->phase_id;

                    $newSubItem->parent()->associate($newItem);
                    $this->newBoard->boardItems()->save($newSubItem);
                }
            }
        // }

        // $this->activeBoard = $this->newBoard;
        // $this->activeBoardID = $this->activeBoard->id;

        // $this->newActivity(
        //     'has created a new project named <span class="font-bold">' . $this->newBoard->name . '</span>',
        //     '',
        //     'create',
        //     'Clients / ' . $this->client->name . ' / Projects'
        // );

        // $this->emit('refreshProjects');
        // $this->showCreateBoardModal = false;
        
        $this->clientBoards = Clients::find($this->newItemClient)->boardsMorph;
        
        $this->newItemBoard = $this->newBoard->id;

        $this->newBoard = Board::make();
    }

    /** Emit to children when filter changes (Kanban / Table) */
    public function updatedFilterUserId()  { $this->emitFiltersChanged(); }
    public function updatedFilterDueStart(){ $this->emitFiltersChanged(); }
    public function updatedFilterDueEnd()  { $this->emitFiltersChanged(); }

    protected function emitFiltersChanged(): void
    {
        // For PowerGrid table (if used)
        $this->emitTo('tasks.task-table', 'externalFiltersChanged', [
            'user'     => $this->filterUserId,
            'dueStart' => $this->filterDueStart,
            'dueEnd'   => $this->filterDueEnd,
        ]);

        // For Kanban (expects same event)
        $this->emitTo('global-components.kanban', 'externalFiltersChanged', [
            'user'     => $this->filterUserId,
            'dueStart' => $this->filterDueStart,
            'dueEnd'   => $this->filterDueEnd,
        ]);
    }
}
