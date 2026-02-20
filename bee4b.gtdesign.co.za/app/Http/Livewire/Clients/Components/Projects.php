<?php

namespace App\Http\Livewire\Clients\Components;

use App\Models\Activity as ModelActivity;
use App\Models\Board;
use App\Models\BoardItem;
use App\Models\Clients;
use App\Models\Colour;
use App\Models\Comment;
use App\Models\DefaultTask;
use App\Models\File;
use App\Models\Phase;
use App\Models\Priority;
use App\Models\Tag;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\WithFileUploads;

class Projects extends Component
{
    use WithFileUploads;

    protected $listeners = [
        'refreshProjects' => '$refresh',
        'filesProcessed',
        'consultationCreated',
        'archivedProjectClicked'
    ];

    protected $queryString = [
        'activeBoardID' => ['as' => 'project'],
        'activeItemID' => ['as' => 'item'],
        'showKanban' => ['as' => 'kanban'],
    ];

    public $currentUser;
    public $client;
    public $activeBoardID;
    public $activeBoard;
    public $activeItem;
    public $activeItemID;
    public $boardItems;
    public $expandedPhases = [];
    public $itemComment;
    public $newItem;
    public $newItemTags = [];
    public $iteration = 0;
    public $editItem = false;
    public $allUsers;
    public $allTags;
    public $contributers;
    public $activeTags;
    public $taskFiles = [];
    public $deletingComment;
    public $editing = false;
    public $enableUpload = false;
    public $users;
    public $selectedFiles = [];
    public $selectAll = false;
    public $newSubtask;
    public $newTag;
    public $newPriority;
    public $newItemUsers = [];
    public $allPriorities;

    public $isSubtask = false;

    public $showCreateTagModal = false;
    public $showCreatePriorityModal = false;
    public $showCreateItemModal = false;
    public $showDeleteItemModal = false;
    public $showConfirmDeleteCommentModal = false;
    public $showProjectRenameModal = false;

    public $changeConsultant = false;
    public $changeAnalyst = false;
    public $changeJnrAnalyst = false;

    //new board
    public $newBoard;
    public $includeDefaults = true;
    public $showCreateBoardModal = false;

    public $showKanban = false;

    public $showArchived = false;
    public ?Board $currentBoard = null;
    public int $clientID;

    public function getCommentActivityDataProperty()
    {
        return [
            'title' => 'left a comment on a task',
            'body' => '<div class="mt-2">' . $this->itemComment->body . '</div>',
            'type' => 'comment post',
            // 'path' => ''
            'path' => 'Clients / '. $this->client->name .' / Projects / ' . $this->activeBoard->name . ' / ' . $this->activeItem->phase->name . ' / ' . $this->activeItem->name
        ];
    }

    public $colours;

    public $tabs = [ 'subtasks', 'files' ];
    public $currentTab = 'subtasks';

    protected $rules = [
        'activeBoardID' => 'required',

        'activeBoard.name' => 'required',
        'activeBoard.consultant_id' => 'required',
        'activeBoard.analyst_id' => 'required',
        'activeBoard.jnrAnalyst_id' => 'required',

        'itemComment.body' => 'required',

        'newItem.name' => 'required',
        'newItem.description' => 'required',
        'newItem.priority' => 'required',
        'newItem.deadline' => 'required',
        'newItem.phase_id' => 'required',
        'newItem.priority_id' => 'required',
        // 'newItem.responsible_person' => 'required',
        'newItemTags' => 'required',
        
        'activeItem.name' => 'required',
        'activeItem.deadline' => 'required',
        'activeItem.description' => 'required',
        'activeItem.priority_id' => 'required',
        // 'activeItem.responsible_person' => 'required',
        'contributers' => 'required',
        'taskFiles' => 'required',

        'newBoard.name' => 'required',
        'includeDefaults' => 'required',

        'newSubtask.name' => 'required',
        'newSubtask.priority' => 'required',

        'newTag.name' => 'required',
        'newTag.color' => 'required',
        'newTag.colour_id' => 'required',

        'newPriority.name' => 'required',
    ];

    public function getAllPrioritiesProperty()
    {
        return Priority::all();
    }

    public function mount($clientID) 
    {
        $this->currentUser = User::find(Auth::id());
        $this->allUsers = User::all();
        $this->users = User::select('id', 'name')->get()->map(function($user) {
            return [
                'key' => $user->name,
                'value' => $user->name,
                'id' => $user->id
            ];
        });
        // $this->client = Clients::find($clientID);
        $this->client = Clients::where('id', $clientID)->with('boards')->first();
        
        if(isset($this->activeBoardID)) {
            $this->activeBoard = Board::find($this->activeBoardID);
        } else if($this->clientBoards->last()) {
            $this->activeBoard = $this->clientBoards->last();
            $this->activeBoardID = $this->activeBoard->id;

            $this->changeConsultant = $this->activeBoard->consultant != null ? false : true;
            $this->changeAnalyst = $this->activeBoard->analyst != null ? false : true;
            $this->changeJnrAnalyst = $this->activeBoard->jnrAnalyst != null ? false : true;
        }else {
            $this->activeBoard = Board::make();
        }
        $this->itemComment = Comment::make();

        if (isset($this->activeItemID)) {
            $this->activeItem = BoardItem::find($this->activeItemID);
        } else if($this->activeBoard->boardItems->where('status', 'active')->last()) {
            $this->activeItem = $this->activeBoard->boardItems
                                    ->where('status', 'active')
                                    ->where('parent_id', null)
                                    ->sortBy('position')
                                    ->last();

            $this->activeItemID = $this->activeItem->id;
        } else {
            $this->activeItem = $this->activeBoard->boardItems->first();
        }

        // $this->phases = Phase::all();
        $this->newItem = BoardItem::make();
        $this->allTags = Tag::all();
        $this->newTag = Tag::make();
        $this->newTag->colour_id = 1;
        $this->newPriority = Priority::make();
        $this->deletingComment = Comment::make();
        $this->newSubtask = BoardItem::make();
        array_push($this->newItemUsers, Auth::id());

        $this->newBoard = Board::make();

        $this->allPriorities = Priority::all();
        $this->colours = Colour::all();

        // dd($this->phases); 

        $this->clientID = $clientID;

        // read ?project=358 from the URL
        $projectId = (int) request()->query('project', 0);

        if ($projectId > 0) {
            $this->currentBoard = Board::select('id','name','red_flagged')
                ->where('id', $projectId)
                ->first();
        }
    }

    public function render()
    {
        return view('livewire.clients.components.projects');
    }

    public function changeTab($tab)
    {
        $this->currentTab = $tab;
        $this->editing = false;
        $this->editItem = false;
    }

    public function newActivity($title, $body, $type, $path)
    {
        $activity = ModelActivity::make();

        $activity->user_id = Auth::id();
        $activity->title = ' ' . $title;
        $activity->body = $body;
        $activity->activity_type = $type;
        // $activity->path = 'Clients / ' . $this->client->name . ' / Projects / ' . $this->activeBoard->name . ' / ' . $this->activeItem->phase->name . ' / ' . $this->activeItem->name;
        $activity->path = $path;
        $this->client->activities()->save($activity);
    }

    public function getClientBoardsProperty()
    {
        return 
            $this->client->boardsMorph()
                ->when(!$this->currentUser->hasPermissionTo('view all projects'), function($query) {
                    $query
                        ->where(function($query) {
                            $query
                                ->where('consultant_id', Auth::id())
                                ->orWhere('analyst_id', Auth::id())
                                ->orWhere('jnrAnalyst_id', Auth::id());
                        });
                })
                ->get();
    }

    public function consultationCreated()
    {
        $this->emit('refreshProjects');
    }

    public function filesProcessed() 
    {
        $this->enableUpload = true;
    }

    public function checkCompleted($id)
    {
        $phase = Phase::find($id);

        if(count($phase->items) == 0) return false;

        foreach($phase->items->where('board_id', $this->activeBoard->id) as $item) {
            if($item->completed == 0) 
                return false; 
        }

        return true;
    }

    public function checkPhase($id) 
    {
        $phase = Phase::find($id);
        $items = $phase->items->where('board_id', $this->activeBoard->id)->where('parent_id', null);
        
        if(count($items) == 0) return false;

        foreach($items as $item) {
            if($item->completed == 0) 
                return false; 
        }

        return true;
    }

    public function testFunc($id)
    {
        $phase = Phase::find($id);

        foreach($phase->items->where('board_id', $this->activeBoard->id)->where('parent_id', null) as $item) {
            if($item->completed == 0) 
                dd('false'); 
        }
        dd('true');
    }

    public function selectAndDownload($id)
    {
        $selectedFile = File::find($id);
        return Storage::download($selectedFile->file_path . '/' . $selectedFile->file_name . '.' . $selectedFile->type); 
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

    public function selectBoard()
    {
        if($this->activeBoardID == '') return; 

        $this->activeBoard = Board::find($this->activeBoardID);

        $this->boardItems = $this->activeBoard->boardItems;

        // $this->activeBoard = '';
    }

    /**
     * Select item
     */
    public function setActiveItem($id)
    {
        if($this->editItem) return;

        $this->activeItemID = $id;
        $this->activeItem = BoardItem::find($id);

        $this->selectAll = false;
        $this->selectedFiles = [];
    }

    public function setCompleted($id)
    {
        $item = BoardItem::find($id);

        // task_statuses: 1=Active, 2=Inactive, 3=Complete, 4=Red Flag
        switch ((int) $item->status_id) {
            case 2: // Inactive -> Active
                $item->status_id = 1;
                break;

            case 1: // Active -> Complete
                $item->status_id = 3;
                $item->completed_at = Carbon::now();
                break;

            case 3: // Complete -> Red Flag
                $item->status_id = 4;
                break;

            case 4: // Red Flag -> Inactive
            default:
                $item->status_id = 2;
                break;
        }

        $item->save();
        $this->emit('refreshProjects');
    }

    public function newTask()
    {
        $this->isSubtask = false;
        // $this->newItem->responsible_person = Auth::id();
        $this->showCreateItemModal = true;
    }
    public function newSubtask()
    {
        $this->isSubtask = true;
        $this->newItem->phase_id = $this->activeItem->phase_id;
        // $this->newItem->responsible_person = Auth::id();
        $this->showCreateItemModal = true;
    }
    //create new task
    public function createItem()
    {
        $this->validate([
            'newItem.name' => 'required|regex:/^[^_^\/^\\\\]*$/',
            'newItem.priority_id' => 'required',
            'newItem.deadline' => 'required',
            'newItem.phase_id' => 'required',
            'newItem.priority_id' => 'required',
            // 'newItem.responsible_person' => 'required',
        ], [
            'newItem.category_id.required' => 'Please select a category.',
            'newItem.name.regex' => 'The name cannot contain slashes or underscores.',
            'newItem.deadline.required' => 'The due date field is required.',
            'newItem.priority_id.required' => 'The priority field is required.'
        ]);

        if(!$this->isSubtask) {
            $last = $this->activeBoard->boardItems
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

        $this->newItem->board_id = $this->activeBoard->id;
        $this->newItem->created_by = Auth::id();
        $this->newItem->status = 'inactive';
        
        $this->newItem->save();

        $this->newItem->tags()->sync($this->newItemTags);
        $this->newItem->assignedUsers()->attach($this->newItemUsers);

        $this->showCreateItemModal = false;

        $this->newActivity(
            'created a new task',
            '<span class="font-bold">' . 
            Auth::user()->name . 
            '</span> has created a new task in: <div>'.
            $this->activeBoard->name.' / '. 
            (isset($this->activeItem->phase->name) ? $this->activeItem->phase->name : '') . 
            ' named: <span class="font-bold">'.
            $this->newItem->name.'</span></div>',
            'new task',
            'Clients / ' . $this->client->name . ' / Projects / ' . $this->activeBoard->name
        );

        $this->newItem = BoardItem::make();
        $this->newItemTags = [];
        $this->newItemUsers = [];
        array_push($this->newItemUsers, Auth::id());

        $this->emit('updateSelect2');
        $this->emit('refreshProjects');
        $this->emit('itemAdded');
    }

    public function toggleEditItem()
    {
        // dd($this->activeItem->responsible_person);
        if($this->editItem) {
            $this->editItem = false;
        }else {
            $this->editItem = true;
            $this->contributers = $this->activeItem->assignedUsers->pluck('id')->toArray();
            $this->activeTags = $this->activeItem->tags->pluck('id')->toArray();
        }
    }

    public function saveItem()
    {
        $this->validate([
            'activeItem.name' => 'required|regex:/^[^_^\/^\\\\]*$/'
        ], [
            'activeItem.name.regex' => 'The name cannot contain slashes or underscores.',
        ]);

        // if ($this->activeItem->deadline >= Carbon::now()) {
        //     $this->activeItem->overdue = 0;
        // } else {
        //     $this->activeItem->overdue = 1;
        // }

        $this->activeItem->overdue = $this->activeItem->deadline >= Carbon::now() ? 0 : 1;

        $this->activeItem->save();
        $this->activeItem->assignedUsers()->sync($this->contributers);
        $this->activeItem->tags()->sync($this->activeTags);

        $this->newActivity(
            'has updated a task',
            '',
            'update',
            'Clients / ' . $this->client->name . ' / Projects / ' . $this->activeBoard->name . ' / ' . $this->activeItem->phase->name . ' / ' . $this->activeItem->name
        );

        $this->editItem = false;
        $this->emit('refreshProjects');
    }

    public function uploadTaskFiles()
    {
        $fileNames = '';

        foreach($this->taskFiles as $file) {
            $fileDetails = File::make();
            $fileDetails->file_name = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);

            if($fileDetails->where('file_name', $fileDetails->file_name)->exists()) {
                $fileDetails->file_name = 'copy_' . $fileDetails->file_name . '_' . date('d-m-y_h-i');
            }

            $fileDetails->file_path = 
                'uploads/' . 
                preg_replace('/\s+/', '_', $this->client->name) . 
                '/' .
                $this->activeBoard->name .
                '/tasks/' . 
                $this->activeItem->phase->name . 
                '/' . 
                preg_replace('/\s+/', '_', $this->activeItem->name);
            $fileDetails->client_id = $this->client->id;
            $fileDetails->user_id = Auth::id();
            $fileDetails->file_size = $file->getSize()/1024;
            $fileDetails->type = $file->getClientOriginalExtension();
            $fileDetails->status = 'Accepted';

            $file->storeAs(
                'uploads/' . 
                preg_replace('/\s+/', '_', $this->client->name) . 
                '/' .
                $this->activeBoard->name .
                '/tasks/' . 
                $this->activeItem->phase->name . 
                '/' . 
                preg_replace('/\s+/', '_', $this->activeItem->name), 
                $fileDetails->file_name . '.' . $file->getClientOriginalExtension()
            );

            $this->activeItem->files()->save($fileDetails);

            $fileNames .= '<div wire:click="$emit(\'openFileDetails\', '.$fileDetails->id.')" class="text-blue-600 cursor-pointer hover:underline">' . $fileDetails->file_name . '.' . $fileDetails->type . '</div>';
        }

        $this->newActivity(
            (count($this->taskFiles) > 1 ? ('has uploaded ' . count($this->taskFiles) . ' files') : 'has uploaded a file'),
            '<div class="text-sm text-gray-600 font-bold">'.$this->activeBoard->name.' / '.$this->activeItem->phase->name.' / '.$this->activeItem->name.'</div><div class="mt-2">'.$fileNames.'</div>',
            'file upload',
            'Clients / ' . $this->client->name . ' / Projects / ' . $this->activeBoard->name . ' / ' . $this->activeItem->phase->name . ' / ' . $this->activeItem->name
        );

        $this->taskFiles = [];

        $this->emit('refreshProjects');
        $this->emit('all_files_uploaded');
        $this->enableUpload = false;
    }

    public function confirmDeleteComment($id)
    {
        $this->showConfirmDeleteCommentModal = true;
        $this->deletingComment = Comment::find($id);
    }

    public function deleteComment()
    {
        $this->deletingComment->delete();

        $this->newActivity(
            'has deleted a comment',
            '<div class="text-sm text-gray-600 font-bold">'.$this->activeBoard->name.' / '.$this->activeItem->phase->name.' / '.$this->activeItem->name.'</div>',
            'delete comment',
            'Clients / ' . $this->client->name . ' / Projects / ' . $this->activeBoard->name . ' / ' . $this->activeItem->phase->name . ' / ' . $this->activeItem->name
        );
        
        $this->showConfirmDeleteCommentModal = false;
        $this->emit('refreshProjects');
    }

    public function updatedSelectAll($value)
    {
        if($value) {
            $this->selectedFiles = $this->activeItem->files->pluck('id')->toArray();
        }else {
            $this->selectedFiles = [];
        }
    }

    public function emailAllFiles()
    {
        $this->selectedFiles = $this->selectedFiles = $this->activeItem->files->pluck('id')->toArray();
        $this->emit('email_files', $this->selectedFiles);
        $this->selectedFiles = [];
    }

    public function emailFiles()
    {
        $this->emit('email_files', $this->selectedFiles);
    }

    public function deleteItem()
    {
        $temp_name = $this->activeItem->name;
        $temp_phase_name = $this->activeItem->phase->name;

        $this->activeItem->delete();
        $this->activeItem = BoardItem::make();

        $this->newActivity(
            'has deleted a task named <span class="font-bold">'.$temp_name.'</span>',
            '<div class="text-sm text-gray-600 font-bold">'.$this->activeBoard->name.' / '.$temp_phase_name . '</div>',
            'delete',
            'Clients / ' . $this->client->name . ' / Projects / ' . $this->activeBoard->name . ' / ' . $temp_phase_name
        );

        $this->showDeleteItemModal = false;
        $this->emit('refreshProjects');
    }

    public function deleteSubtask($id)
    {
        BoardItem::find($id)->delete();

        $this->emit('refreshProjects');
    }

    //Create new board
    public function createBoard()
    {
        $this->validate([
            'newBoard.name' => 
                Rule::unique('boards', 'name')->where(function($query) {
                    $query->where([
                        ['boardable_id', $this->client->id],
                        ['boardable_type', 'App\\Models\\Clients']
                    ]);
                }),
        ], [
            'newBoard.name.unique' => 'Board already exists'
        ]);

        $this->newBoard->consultant_id = $this->client->manager;
        $this->newBoard->analyst_id = $this->client->analyst;

        $this->client->boardsMorph()->save($this->newBoard);

        if($this->includeDefaults) {
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
        }

        $this->activeBoard = $this->newBoard;
        $this->activeBoardID = $this->activeBoard->id;

        $this->newActivity(
            'has created a new project named <span class="font-bold">' . $this->newBoard->name . '</span>',
            '',
            'create',
            'Clients / ' . $this->client->name . ' / Projects'
        );

        $this->emit('refreshProjects');
        $this->newBoard = Board::make();
        $this->showCreateBoardModal = false;
    }
    //End create new board

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

    public function updateTaskOrder($list)
    {
        foreach($list as $item) {
            BoardItem::find($item['value'])->update(['position' => $item['order']]);
        }

        $this->emitSelf('refreshProjects');
    }

    public function setTeamMember($member)
    {
        $this->activeBoard->save();

        if($member == 'consultant') $this->changeConsultant = false;
        else if($member == 'analyst') $this->changeAnalyst = false;
        else if($member == 'jnrAnalyst') $this->changeJnrAnalyst = false;

        $this->activeBoard = Board::find($this->activeBoardID);
        $this->emit('refreshProjects');
    }    

    public function setActiveBoard($id)
    {
        $this->activeBoard = Board::with('boardItems')->where('id', $id)->first();
        $this->activeBoardID = $id;
        // dd($this->activeBoard);

        if ($this->activeBoard->boardItems->where('status', 'active')->last()) {
            $this->activeItem = $this->activeBoard->boardItems->where('status', 'active')->last();
        } else {
            $this->activeItem = $this->activeBoard->boardItems->first();
        }
        $this->activeItemID = isset($this->activeItem) ? $this->activeItem->id : null;

        $this->changeConsultant = $this->activeBoard->consultant != null ? false : true;
        $this->changeAnalyst = $this->activeBoard->analyst != null ? false : true;
        $this->changeJnrAnalyst = $this->activeBoard->jnrAnalyst != null ? false : true;

        $this->emit('refreshProjects');
        $this->emit('changeBoard', $this->activeBoardID);
    }

    public function updateBoard()
    {
        if (!$this->activeBoard->exists) {
            $this->showProjectRenameModal = false;
            return;
        };

        $this->activeBoard->save();
        $this->showProjectRenameModal = false;
        $this->emit('refreshProjects');
    }

    public function getPhasesProperty()
    {
        return Phase::query()
            ->has('items', '>=', 1, 'and', fn($query) => $query->where('board_id', $this->activeBoardID))
            ->with('items', function($query) {
                $query
                    ->where('board_id', $this->activeBoard->id)
                    ->where('parent_id', null)
                    ->when(!Auth::user()->hasPermissionTo('view all tasks'), function($q) {
                        $q->whereHas('assignedUsers', function($query) {
                            $query->where('users.id', Auth::id());
                        });
                    })
                    ->orderBy('position');
            })
            ->get()
            ->filter(fn($item) => Auth::user()->hasPermissionTo('view ' . $item->name) ?? $item);
    }

    public function getAllPhasesProperty() { return Phase::all(); }

    public function newConsultation()
    {
        $this->emit('updateConsultationEntity', $this->activeItem->id, "\App\Models\BoardItem");
        // $this->emit('createConsultation');
    }

    public function archiveBoard()
    {
        $boardName = $this->activeBoard->name;

        $this->activeBoard->delete();
        if ($this->clientBoards->last() !== null) {
            $this->activeBoard = $this->clientBoards->last();
            $this->activeBoardID = $this->activeBoard->id;
            $this->activeItem = $this->activeBoard->boardItems->first();
        } else {
            $this->activeBoard = null;
            $this->activeBoardID = null;
            $this->activeItem = null;
            $this->activeItemID = null;
        }
        $this->dispatchBrowserEvent('notify-success', ['message' => $boardName . ' has been archived']);
    }

    public function toggleShowArchived()
    {
        $this->showArchived = !$this->showArchived;
    }

    public $showUnarchiveModal = false;
    public $unarchivingProject;

    public function archivedProjectClicked($id)
    {
        $this->showUnarchiveModal = true;
        $this->unarchivingProject = Board::withTrashed()->where('id', $id)->first();
    }

    public function restore()
    {
        $this->unarchivingProject->restore();
        $this->showUnarchiveModal = false;
        $this->emit('pg:eventRefresh-default');
    }

    public function permanentlyDelete()
    {
        foreach ($this->unarchivingProject->boardItems as $item) {
            foreach ($item->files as $file) {
                $fullFilePath = $file->file_path . '/' . $file->file_name . '.' . $file->type;
                if (Storage::exists($fullFilePath)) 
                    Storage::delete($fullFilePath);
            }

            foreach ($item->subTasks as $subtask) {
                foreach ($subtask->files as $file) {
                    $fullFilePath = $file->file_path . '/' . $file->file_name . '.' . $file->type;
                    if (Storage::exists($fullFilePath)) 
                        Storage::delete($fullFilePath);
                }
            }
        }

        $this->unarchivingProject->forceDelete();

        $this->showUnarchiveModal = false;
        $this->emit('pg:eventRefresh-default');
    }

    public function settingsRedirect()
    {
        return redirect()->to('/settings?section=projects');
    }
}
