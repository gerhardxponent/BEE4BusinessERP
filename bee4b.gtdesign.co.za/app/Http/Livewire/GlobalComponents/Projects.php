<?php

namespace App\Http\Livewire\GlobalComponents;

use App\Models\Activity as ModelActivity;
use App\Models\Board;
use App\Models\BoardItem;
use App\Models\BoardItemCategory;
use App\Models\Colour;
use App\Models\File;
use App\Models\Priority;
use App\Models\Tag;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;

class Projects extends Component
{
    use WithFileUploads;

    protected $listeners = [
        'refreshProjects' => '$refresh',
        'filesProcessed',
        'update:category-item' => 'updateCategory'
    ];

    public $entity;
    public $activeBoardID;
    public $activeBoard;
    public $activeItem;
    public $initialItem;
    public $boardItems;
    public $newItem;
    public $newItemTags = [];
    public $editItem = false;
    public $allUsers;
    public $allTags;
    public $contributers;
    public $activeTags;
    public $taskFiles = [];
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
    public $newCategory;
    
    public $selectedFile;
    public $editFile = false;
    public $selectedFileOriginalName = '';

    public $isSubtask = false;

    public $showCreateTagModal = false;
    public $showCreatePriorityModal = false;
    public $showCreateItemModal = false;
    public $showDeleteItemModal = false;
    public $showCreateCategoryModal = false;
    public $showFileDetailsModal = false;
    public $showConfirmDeleteCategoryModal = false;
    public $deletingCategory;

    // public $changeConsultant = false;
    // public $changeAnalyst = false;
    // public $changeJnrAnalyst = false;

    //new board
    public $newBoard;
    public $includeDefaults = true;
    public $showCreateBoardModal = false;

    public $activityPath = '';

    public $showKanban = false;
    public $currentUser;
    public $showEditCategoryModal = false;

    public function getCommentActivityDataProperty()
    {
        //CHANGE THIS********************************
        return [
            'title' => 'left a comment on a task',
            // 'body' => '<div class="text-sm text-gray-600 font-bold">'.$this->activeBoard->name.' / '.$this->activeItem->phase->name.' / '.$this->activeItem->name.'</div><div class="mt-2">'.$this->itemComment->body.'</div>',
            'body' => '',
            'type' => 'comment post'
        ];
    }

    public $colours;

    public $tabs = [ 'subtasks', 'files' ];
    public $currentTab = 'subtasks';

    protected $rules = [
        'activeBoardID' => 'required',

        'activeBoard.consultant_id' => 'required',
        'activeBoard.analyst_id' => 'required',
        'activeBoard.jnrAnalyst_id' => 'required',

        'newItem.name' => 'required',
        'newItem.description' => 'required',
        'newItem.priority' => 'required',
        'newItem.deadline' => 'required',
        'newItem.category_id' => 'required',
        'newItem.priority_id' => 'required',
        'newItemTags' => 'required',
        
        'activeItem.name' => 'required',
        'activeItem.deadline' => 'required',
        'activeItem.description' => 'required',
        'activeItem.priority_id' => 'required',
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

        'newCategory.name' => 'required',

        'selectedFile.file_name' => 'required',
        'selectedFile.client_comments' => 'required',
        'selectedFile.reviewer_comments' => 'required',
        'selectedFile.status' => 'required',
    ];

    public $phases;

    public function mount($entity) 
    {
        // $this->client = Clients::find(6);
        $this->phases = BoardItemCategory::all();
        $this->entity = $entity;

        $this->allUsers = User::all();
        $this->users = $this->allUsers->map(function($user) {
            return [
                'key' => $user->name,
                'value' => $user->name,
                'id' => $user->id
            ];
        });

        if ($this->entity->boards->last()) {
            $this->activeBoard = $this->entity->boards->last();
            $this->activeBoardID = $this->activeBoard->id;

            // $this->changeConsultant = $this->activeBoard->consultant != null ? false : true;
            // $this->changeAnalyst = $this->activeBoard->analyst != null ? false : true;
            // $this->changeJnrAnalyst = $this->activeBoard->jnrAnalyst != null ? false : true;
        } else {
            $this->activeBoard = Board::make();
        }

        // dd($this->activeBoard->boardItems->where('completed', 1)->last());
        // $this->activeItem = BoardItem::make();
        if($this->activeBoard->boardItems->where('status', 'active')->last()) {
            $this->activeItem = $this->activeBoard->boardItems
                                    ->where('status', 'active')
                                    ->where('parent_id', null)
                                    ->sortBy('position')
                                    ->last();
        } else {
            $this->activeItem = $this->activeBoard->boardItems->first();
        }
        $this->initialItem = $this->activeItem;

        // $this->categories = BoardItemCategory::all();
        $this->newItem = BoardItem::make();
        $this->allTags = Tag::all();
        $this->newTag = Tag::make();
        $this->newTag->colour_id = 1;
        $this->newPriority = Priority::make();
        $this->newSubtask = BoardItem::make();
        array_push($this->newItemUsers, Auth::id());

        $this->newBoard = Board::make();

        $this->allPriorities = Priority::all();
        $this->colours = Colour::all();

        $this->newCategory = BoardItemCategory::make();

        $this->selectedFile = File::make();

        $this->currentUser = Auth::user();
    }

    public function render()
    {
        return view('livewire.global-components.projects');
    }

    public function fileSelected($fileID)
    {
        $this->selectedFile = File::find($fileID);
        $this->selectedFileOriginalName = $this->selectedFile->file_name;
        $this->showFileDetailsModal = true;
    }

    public function updateFile()
    {
        if($this->selectedFile->file_name == '') $this->selectedFile->file_name = File::find($this->selectedFile->id)->file_name;
        // $this->validate();

        if($this->selectedFileOriginalName != $this->selectedFile->file_name) {
            Storage::move(
                $this->selectedFile->file_path . '/' . $this->selectedFileOriginalName . '.' . $this->selectedFile->type,
                $this->selectedFile->file_path . '/' . $this->selectedFile->file_name . '.' . $this->selectedFile->type
            );
        }

        $this->selectedFile->save();
        // $this->emit('pg:eventRefresh-GlobalFilesTable');
        $this->editFile = false;
        $this->showFileDetailsModal = false;
    }

    public function toggleFileEdit()
    {
        if ($this->editFile) {
            $this->selectedFile = File::find($this->selectedFile->id);
        }
        $this->editFile = !$this->editFile;
    }

    public function getCategoriesProperty()
    {
        return $this->entity->board_categories()
            ->with('items', function($query) {
                $query
                    ->where('board_id', $this->activeBoard->id)
                    ->where('parent_id', null)
                    ->orderBy('position');
            })
            ->get();
    }

    public function createNewCategory()
    {
        $this->validate([
            'newCategory.name' => 'required|regex:/^[^_^\/^\\\\]*$/'
        ], [
            'newCategory.name.regex' => 'The name cannot contain slashes or underscores.'
        ]);
        
        $this->entity->board_categories()->save($this->newCategory);
        $this->newCategory = BoardItemCategory::make();
        $this->showCreateCategoryModal = false;

        $this->dispatchBrowserEvent('notify-success', ['message' => 'New category created successfully']);
    }

    public function changeTab($tab)
    {
        // dd($tab);
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
        $this->entity->activities()->save($activity);
    }

    public function updatedActiveBoardID($value)
    {
        if ($value == "") {
            $this->activeBoard = Board::make();
            $this->activeItem = BoardItem::make();
            $this->initialItem = BoardItem::make();
            return;
        }

        $this->activeBoard = Board::find($value);
        if ($this->activeBoard->boardItems->where('completed', 1)->last()) {
            $this->activeItem = $this->activeBoard->boardItems->where('completed', 1)->last();
        } else {
            $this->activeItem = $this->activeBoard->boardItems->first();
        }
        $this->initialItem = $this->activeItem;

        // $this->changeConsultant = $this->activeBoard->consultant != null ? false : true;
        // $this->changeAnalyst = $this->activeBoard->analyst != null ? false : true;
        // $this->changeJnrAnalyst = $this->activeBoard->jnrAnalyst != null ? false : true;

        $this->emit('refreshProjects');
    }

    // public function getPhaseItemsProperty()
    // {
    //     return $phase->items->where('board_id', $activeBoardID);
    // }

    public function getEntityBoardsProperty()
    {
        return $this->entity->boards;
    }

    public function filesProcessed() 
    {
        $this->enableUpload = true;
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

    public function setActiveItem($id)
    {
        if($this->editItem) return;

        // $this->activeItem = BoardItem::find($id);
        $this->activeItem = BoardItem::query()
            ->with('assignedUsers')
            ->with('tags')
            ->where('id', $id)
            ->first();

        $this->selectAll = false;
        $this->selectedFiles = [];
    }

    public function setCompleted($id)
    {
        $item = BoardItem::find($id);

        //New
        // if($item->status == 'inactive') $item->status = 'active';
        // else if($item->status == 'active') $item->status = 'complete';
        // else if($item->status == 'complete') $item->status = 'inactive';

        // 1 = Active
        // 2 = Inactive
        // 3 = Complete

        switch ($item->status_id) {
            case 2: 
                $item->status_id = 1;
                break;
            case 1: {
                $item->status_id = 3;
                $item->completed_at = Carbon::now();
                break;
            }
            case 3: 
                $item->status_id = 2;
                break;
            default: 
                $item->status_id = 2;
        }

        // $this->newActivity(
        //     'has marked a task as ' . ($item->completed == 0 ? 'uncomplete' : 'complete'),
        //     'Task: ' . '<span class="font-bold">'. $item->name .'</span>' . ' from Client: <span class="font-bold">' . $this->client->name . '</span>, Project: <span class="font-bold">' . $item->board->name . '</span> has been marked as ' . ($item->completed == 0 ? 'uncomplete' : 'complete'),
        //     'task status change'
        // );

        $item->save();

        // $this->emit('refreshProjects');
    }

    public function newTask()
    {
        $this->isSubtask = false;
        $this->showCreateItemModal = true;
    }
    public function newSubtask()
    {
        $this->isSubtask = true;
        $this->newItem->category_id = $this->activeItem->category_id;
        $this->showCreateItemModal = true;
    }
    //create new task
    public function createItem()
    {
        // $this->newItem->name = trim($this->newItem->name, " ");

        $this->validate([
            // 'newItem.name' => 'required|regex:/^[a-zA-Z0-9\s\(\)\-\_\.]*$/',
            'newItem.name' => 'required|regex:/^[^_^\/^\\\\]*$/',
            'newItem.description' => 'required',
            'newItem.priority_id' => 'required',
            'newItem.deadline' => 'required',
            'newItem.category_id' => 'required',
            'newItem.priority_id' => 'required',
        ], [
            'newItem.category_id.required' => 'Please select a category.',
            'newItem.name.regex' => 'The name cannot contain slashes or underscores.',
            'newItem.deadline.required' => 'The due date field is required.',
            'newItem.priority_id.required' => 'The priority field is required.'
        ]);

        if(!$this->isSubtask) {
            $last = $this->activeBoard->boardItems
                ->where('category_id', $this->newItem->category_id)
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

        $path = $this->activityPath . ' / ' . $this->entity->name . ' / Projects / ' . $this->activeBoard->name . ' / ' . $this->newItem->category->name . ' / ' .  '<span class="font-bold">' . $this->newItem->name . '</span>';
        if ($this->isSubtask) {
            $path .= ' / ' . $this->newItem->parent->name;
        }

        $this->newActivity(
            $this->isSubtask ? 'created a new subtask' : 'created a new task',
            '',
            'new task',
            $path
        );

        $this->newItem = BoardItem::make();
        $this->newItemTags = [];
        $this->newItemUsers = [];
        array_push($this->newItemUsers, Auth::id());

        $this->emit('updateSelect2');
        $this->emit('refreshProjects');
        $this->emit('itemAdded');

        $this->dispatchBrowserEvent('notify-success', ['message' => 'Task created successfully']);
    }

    public function toggleEditItem()
    {
        if ($this->editItem) {
            $this->editItem = false;
        } else {
            $this->editItem = true;
            $this->contributers = $this->activeItem->assignedUsers->pluck('id')->toArray();
            $this->activeTags = $this->activeItem->tags->pluck('id')->toArray();
        }
    }

    public function saveItem()
    {
        $this->validate([
            'activeItem.name' => 'required|regex:/^[^_^\/^\\\\]*$/',
            'activeItem.description' => 'required',
            'activeItem.priority_id' => 'required',
            'activeItem.deadline' => 'required',
            'activeItem.priority_id' => 'required',
            'contributers' => 'required',
        ], [
            'activeItem.name.regex' => 'The name cannot contain slashes or underscores.',
            'contributers.required' => 'The task must be assigned to at least one user.',
        ]);

        $this->activeItem->name = trim($this->activeItem->name, " ");
        $this->activeItem->overdue = $this->activeItem->deadline >= Carbon::now() ? 0 : 1;
        
        $this->activeItem->save();
        $this->activeItem->assignedUsers()->sync($this->contributers);
        $this->activeItem->tags()->sync($this->activeTags);
        

        $this->newActivity(
            'has updated a ' . (isset($this->activeItem->parent) ? 'subtask' : 'task'),
            '',
            'update',
            $this->activityPath . 
            ' / ' . 
            $this->entity->name . 
            ' / Projects / ' . 
            $this->activeItem->category->name . 
            ' / ' . 
            (isset($this->activeItem->parent) ? ($this->activeItem->parent->name . ' / ') : '') .  
            '<span class="font-bold">' . $this->activeItem->name . '</span>'
        );

        $this->editItem = false;
        $this->emit('refreshProjects');
        $this->dispatchBrowserEvent('notify-success', ['message' => 'Task updated successfully']);
    }

    public function uploadTaskFiles()
    {
        $fileNames = '';

        foreach ($this->taskFiles as $file) {
            $fileDetails = File::make();
            $fileDetails->file_name = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);

            if($fileDetails->where('file_name', $fileDetails->file_name)->exists()) {
                $fileDetails->file_name = 'copy_' . $fileDetails->file_name . '_' . date('d-m-y_h-i');
            }

            $fileDetails->file_path = 
                'uploads/' . 
                preg_replace('/\s+/', '_', $this->entity->name) . 
                '/' .
                preg_replace('/\s+/', '_', $this->activeBoard->name) .
                '/tasks/' . 
                $this->activeItem->category->name . 
                '/' . 
                (isset($this->activeItem->parent) ? preg_replace('/\s+/', '_', ($this->activeItem->parent->name) . '/') : '') .
                preg_replace('/\s+/', '_', $this->activeItem->name);
            $fileDetails->client_id = null;
            $fileDetails->user_id = Auth::id();
            $fileDetails->file_size = $file->getSize()/1024;
            $fileDetails->type = $file->getClientOriginalExtension();
            $fileDetails->status = 'Accepted';

            $file->storeAs(
                'uploads/' . 
                preg_replace('/\s+/', '_', $this->entity->name) . 
                '/' .
                preg_replace('/\s+/', '_', $this->activeBoard->name) .
                '/tasks/' . $this->activeItem->category->name . 
                '/' . 
                (isset($this->activeItem->parent) ? preg_replace('/\s+/', '_', ($this->activeItem->parent->name) . '/') : '') .
                preg_replace('/\s+/', '_', $this->activeItem->name), 
                $fileDetails->file_name . '.' . $file->getClientOriginalExtension()
            );

            $this->activeItem->files()->save($fileDetails);

            $fileNames .= '<div wire:click="$emit(\'openFileDetails\', '.$fileDetails->id.')" class="text-blue-600 cursor-pointer hover:underline">' . $fileDetails->file_name . '.' . $fileDetails->type . '</div>';
        }

        // $path = 
        //     $this->activityPath . 
        //     ' / ' . 
        //     $this->entity->name . 
        //     ' / Projects / ' . 
        //     $this->activeBoard->name . 
        //     ' / ' . 
        //     $this->activeItem->category->name .
        //     ' / ' .
        //     (isset($this->activeItem->parent) ? ($this->activeItem->parent->name . ' / ') : '') . 
        //     '<span class="font-bold">' . $this->activeItem->name . '</span>';

        $this->newActivity(
            (count($this->taskFiles) > 1 ? ('has uploaded ' . count($this->taskFiles) . ' files') : 'has uploaded a file'),
            '<div class="mt-2">'.$fileNames.'</div>',
            'file upload',
            $this->getPath()
        );

        $this->emit('refreshProjects');
        $this->emit('all_files_uploaded');
        $this->taskFiles = [];
        $this->enableUpload = false;
    }

    public function updatedSelectAll($value)
    {
        if ($value) {
            $this->selectedFiles = $this->activeItem->files->pluck('id')->toArray();
        } else {
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

    public function getPath()
    {
        return (
            $this->activityPath . 
            ' / ' . 
            $this->entity->name . 
            ' / Projects / ' . 
            $this->activeBoard->name . 
            ' / ' . 
            $this->activeItem->category->name .
            ' / ' .
            (isset($this->activeItem->parent) ? ($this->activeItem->parent->name . ' / ') : '') . 
            '<span class="font-bold">' . $this->activeItem->name . '</span>'
        );            
    }

    public function deleteItem()
    {
        $temp_name = $this->activeItem->name;

        $this->newActivity(
            'has deleted a task named <span class="font-bold">'.$temp_name.'</span>',
            '',
            'delete',
            $this->getPath()
        );

        $this->activeItem->delete();
        $this->activeItem = BoardItem::make();

        $this->showDeleteItemModal = false;
        $this->emit('refreshProjects');
    }

    // REMOVE
    public function deleteSubtask($id)
    {
        BoardItem::find($id)->delete();

        $this->emit('refreshProjects');
    }

    //Create new board
    public function createBoard()
    {
        $this->validate([
            'newBoard.name' => 'required',
        ]);

        $this->entity->boards()->save($this->newBoard);

        $this->activeBoard = $this->newBoard;
        $this->activeBoardID = $this->activeBoard->id;

        $this->newActivity(
            'has created a new project named <span class="font-bold">' . $this->newBoard->name . '</span>',
            '',
            'create',
            $this->activityPath . ' / Projects / ' . '<span class="font-bold">' . $this->newBoard->name . '</span>'
        );

        $this->emit('refreshProjects');
        $this->newBoard = Board::make();
        $this->showCreateBoardModal = false;
        $this->dispatchBrowserEvent('notify-success', ['message' => 'Project created successfully']);
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
        
        // $elementName = $this->showCreateTagModal ? 'tagSelect-item-creation' : 'tagEditSelect2';

        $this->emit('updateData', [
            'id' => $this->newTag->id,
            'text' => $this->newTag->name,
            'elementName' => 'tagEditSelect2',
        ]);

        $this->emit('updateData', [
            'id' => $this->newTag->id,
            'text' => $this->newTag->name,
            'elementName' => 'tagSelect-item-creation',
        ]);

        $this->showCreateTagModal = false;
        $this->newTag = Tag::make();
        $this->newTag->colour_id = 1;

        $this->dispatchBrowserEvent('notify-success', ['message' => 'Tag created successfully']);
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

        $this->dispatchBrowserEvent('notify-success', ['message' => 'Priority created successfully']);
    }

    public function updateTaskOrder($list)
    {
        foreach($list as $item) {
            BoardItem::find($item['value'])->update(['position' => $item['order']]);
        }

        // $this->emitSelf('refreshProjects');
    }

    // public function setTeamMember($member)
    // {
    //     $this->activeBoard->save();

    //     if($member == 'consultant') $this->changeConsultant = false;
    //     else if($member == 'analyst') $this->changeAnalyst = false;
    //     else if($member == 'jnrAnalyst') $this->changeJnrAnalyst = false;

    //     $this->activeBoard = Board::find($this->activeBoardID);
    //     $this->emit('refreshProjects');
    // }

    public function getSubtasksProperty()
    {
        return BoardItem::where('parent_id', $this->activeItem->id)
            ->orderBy('position')
            ->get();
    }

    public function editCategories()
    {
        $this->showEditCategoryModal = true;
    }

    public function updateCategory($value, $model, $id, $field)
    {
        ('App\Models\\' . $model)::find($id)->update([ $field => $value ]);
    }

    public function setDeletingCategory($id)
    {
        $this->deletingCategory = $id;
        $this->showConfirmDeleteCategoryModal = true;
    }

    public function deleteCategory()
    {
        if ($this->deletingCategory == null) return;

        $category = BoardItemCategory::find($this->deletingCategory);

        foreach ($category->items as $item) {
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

        $category->delete();
        $this->showConfirmDeleteCategoryModal = false;
    }
}
