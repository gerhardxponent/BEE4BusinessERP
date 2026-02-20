<?php

namespace App\Http\Livewire\Boards;

use App\Jobs\CommentMentionEmail;
use App\Models\Board;
use App\Models\BoardItem;
use App\Models\BoardItemComment;
use App\Models\Clients;
use App\Models\File;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;

class BoardDetails extends Component
{
    use WithFileUploads;

    public $test;
    public $users = ['4', '30'];
    public $var = [];
    public $testArr = '4,30';

    protected $listeners = ['refreshComponent' => '$refresh'];
    
    //for refreshing wire:ignore elements
    public $iteration = 0;

    public $currentUser;

    //board
    public $board;
    public $contributers;
    //board files
    public $selectedFile;
    public $newFiles = [];
    public $editFile = false;
    public $showFiles = false;
    public $selectedFileOriginalName;
    //board items
    public $newTag;
    public $newItem;
    public $activeItem;
    public $tagsEditing = [];
    public $selectedTags = [];
    public $usersEditing = [];
    public $activeItemUsers = [];
    public $contributerNames = [];
    public $selectedContributers = [];
    public $editingData = [
        'users' => [],
        'tags' => []
    ];
    //editing
    public $editing = false;
    //filters
    public $showFilters = false;
    public $filters = [
        'tags' => [],
        'user' => []
    ];
    //comments
    public $newComment;
    public $editingComment;
    public $deletingComment;
    //modal toggles
    public $showCreateTagModal = false;
    public $showCreateItemModal = false;
    public $showDeleteItemModal = false;
    public $showDeleteFileModal = false;
    public $showFileDetailsModal = false;
    public $showDeleteCommentModal = false;
    public $showAllContributersModal = false;    
    //other
    public $colors = ['blue', 'violet', 'orange', 'emerald', 'lime'];

    protected $rules = [
        'newItem.name' => 'required',
        'newItem.description' => 'required',
        'newItem.description' => 'required',
        'newItem.priority' => 'required',
        'newItem.deadline' => 'required',
        'newItem.completed' => 'required',

        'activeItem.name' => 'required',
        'activeItem.description' => 'required',
        'activeItem.description' => 'required',
        'activeItem.priority' => 'required',
        'activeItem.deadline' => 'required',
        'activeItem.completed' => 'required',

        'newTag.name' => 'required',
        'newTag.color' => 'required',

        'boardItems.*.completed' => 'required',

        'newFiles' => 'required',

        'selectedFile.file_name' => 'nullable',
        'selectedFile.client_comments' => 'nullable',
        'selectedFile.reviewer_comments' => 'nullable',
        'selectedFile.status' => 'nullable',

        'newComment.comment' => 'required',
    ];

    public $client;

    public function mount($id)
    {
        $this->client = Clients::find(6);


        $this->board = Board::find($id);
        $this->activeItem = BoardItem::make();
        $this->newItem = BoardItem::make();
        $this->newTag = Tag::make();
        $this->contributers = $this->board->users;
        $this->selectedFile = File::make();
        $this->newComment = BoardItemComment::make();
        $this->currentUser = User::find(Auth::id());
        // dd($this->user);
    
        $this->contributerNames = $this->contributers->map(function($user) {
            return [
                'key' => $user->name,
                'value' => $user->name,
                'id' => $user->id
            ];
        });
    }

    public function render()
    {
        return view('livewire.boards.board-details');
    }

    //Computed Properties
    public function getItemsProperty()
    {
        return BoardItem::query()
            ->whereHas('board', function($query) {
                $query->where('id', $this->board->id);
            })
            ->when($this->filters['tags'], function($query, $tags) {
                foreach($tags as $t) {
                    $query->whereHas('tags', function($query) use ($t) {
                        $query->where('id', $t);
                    });
                }
            })
            ->when($this->filters['user'], function($query, $user) {
                foreach($user as $u) {
                    $query->whereHas('assignedUsers', function($query) use ($u) {
                        $query->where('id', $u);
                    });
                }
            })
            ->get();
    }

    public function getBoardFilesProperty()
    {
        return File::query()
            ->whereHas('boards', function($query) {
                $query->where('id', $this->board->id);
            })->get();
    }

    public function getTagsProperty() 
    { 
        return Tag::all(); 
    }
    //End computed properties

    public function setActiveItem($id)
    {
        $this->iteration++;
        if($this->editing) return;

        $this->activeItem = BoardItem::find($id);
        $this->newComment = BoardItemComment::make();

        $this->emit('activeItemChanged');
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

    public function showAllContributers()
    {
        $this->showAllContributersModal = true;
    }

    public function setCompleted($index)
    {
        $item = BoardItem::find($index);

        if($item->completed == 1) $item->completed = 0;
        else $item->completed = 1;

        $item->save();
    }

    public function showCreateModal()
    {
        if($this->editing) return; 

        $this->showCreateItemModal = true;
    }

    public function createItem()
    {
        $res = [];
        array_push($res, $this->users);
        array_push($res, $this->var);
        dd($res);

        $this->newItem->board_id = $this->board->id;
        $this->newItem->completed = 0;
        $this->newItem->created_by = Auth::id();

        $this->newItem->save();

        $this->newItem->tags()->attach($this->selectedTags);
        $this->newItem->assignedUsers()->attach($this->selectedContributers);

        $this->forgetComputed('items');

        $this->emit('refreshComponent');

        $this->showCreateItemModal = false;

        $this->newItem = BoardItem::make();

        session()->flash('message', 'Task successfully created');
    }

    public function toggleEdit()
    {
        if(!$this->editing) {
            $this->editingData['users'] = [];
            
            foreach($this->activeItem->assignedUsers as $user) {
                array_push($this->editingData['users'], $user->id);
            }

            foreach($this->activeItem->tags as $tag) {
                array_push($this->editingData['tags'], $tag->id);
            }

            $this->emit('edit', $this->editingData);
        }
        $this->editing = !$this->editing;        
    }

    public function save()
    {
        $this->activeItem->save();
        $this->activeItem->assignedUsers()->sync($this->editingData['users']);
        $this->activeItem->tags()->sync($this->editingData['tags']);

        $this->emit('refreshComponent');

        $this->editingData['users'] = [];
        $this->editingData['tags'] = [];

        $this->editing = $this->toggleEdit();

        session()->now('message', 'Changes saved successfully');
    }

    public function createTag()
    {
        if($this->newTag->color == '' || $this->newTag == null) return;

        $this->newTag->save();
        $this->iteration++;

        $this->emit('edit', $this->editingData);
        $this->showCreateTagModal = false;
        $this->newTag = Tag::make();
    }

    public function inlineDelete()
    {
        if($this->editing) return;
        $this->showDeleteItemModal = true;
    }

    public function deleteItem()
    {
        $this->activeItem->delete();
        $this->activeItem = BoardItem::make();

        $this->emit('refreshComponent');
        $this->showDeleteItemModal = false;
    }

    public function setShowFilters()
    {
        if($this->editing) return;

        if($this->showFilters) {
            $this->showFilters = false;
        }
        else {
            $this->showFilters = true;
            $this->emit('show_filters');
        }
    }

    public function clearFilters()
    {
        $this->filters['tags'] = [];
        $this->filters['user'] = [];

        $this->emit('clear_filters');
    }

    public function boardSettings()
    {
        redirect()->to('../board-settings/' . $this->board->id);
    }

    public function contributerDetails($id)
    {

    }

    public function uploadBoardFiles()
    {
        if(count($this->newFiles) == 0) return;

        foreach($this->newFiles as $index => $file) {
            $fileDetails = File::make();

            $fileDetails->file_name = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);

            if(File::where('file_name', '=', $fileDetails->file_name)
                    ->exists()) {
                $fileDetails->file_name = 'copy_' . $fileDetails->file_name . '_' . date('d-m-y_h-i');
            }

            $fileDetails->file_path = 'uploads/boards/' . preg_replace('/\s+/', '_', $this->board->name);
            $fileDetails->client_id = null;
            $fileDetails->user_id = Auth::id();
            $fileDetails->file_size = $file->getSize()/1024;
            $fileDetails->type = $file->getClientOriginalExtension();
            $fileDetails->status = 'Accepted';

            $fileDetails->save();

            $this->board->files()->attach($fileDetails);

            $file->storeAs('uploads/boards/' . preg_replace('/\s+/', '_', $this->board->name), $fileDetails->file_name . '.' . $file->getClientOriginalExtension());
        }

        $this->emit('all_files_uploaded');
        session()->flash('message', 'Files uploaded successfully');
    }

    public function selectFile($id)
    {
        $this->selectedFile = File::find($id);
        $this->selectedFileOriginalName = $this->selectedFile->file_name;
        $this->showFileDetailsModal = true;
    }

    public function downloadSelected()
    {
        return Storage::download($this->selectedFile->file_path . '/' . $this->selectedFile->file_name . '.' . $this->selectedFile->type);
    }

    public function selectAndDownload($id)
    {
        $this->selectedFile = File::find($id);
        return Storage::download($this->selectedFile->file_path . '/' . $this->selectedFile->file_name . '.' . $this->selectedFile->type);
    }

    public function toggleFileEdit()
    {
        if($this->editFile) {
            $this->selectedFile = File::find($this->selectedFile->id);
        }
        $this->editFile = !$this->editFile;
    }

    public function updateFile()
    {
        if($this->selectedFile->file_name == '') $this->selectedFile->file_name = File::find($this->selectedFile->id)->file_name;

        if($this->selectedFileOriginalName != $this->selectedFile->file_name) {
            Storage::move(
                $this->selectedFile->file_path . '/' . $this->selectedFileOriginalName . '.' . $this->selectedFile->type,
                $this->selectedFile->file_path . '/' . $this->selectedFile->file_name . '.' . $this->selectedFile->type
            );
        }

        $this->selectedFile->save();
        $this->editFile = false;
    }

    public function confirmDelete($id)
    {
        $this->showDeleteFileModal = true;
        $this->selectedFile = File::find($id);
    }

    public function deleteFile()
    {
        $fullFileName = $this->selectedFile->file_path . '/' . $this->selectedFile->file_name . '.' . $this->selectedFile->type;
        if(Storage::exists($fullFileName)) {
            Storage::delete($fullFileName);
        }
        $this->selectedFile->delete();
        
        $this->selectedFile = File::make();
        $this->showDeleteFileModal = false;
        session()->flash('message', 'File deleted successfully');
    }

    // Item Comments
    public function postComment()
    {
        $this->validate([
            'newComment.comment' => 'required'
        ]);

        preg_match_all('/@(\d+)@/', $this->newComment->comment, $matches);
        if(count($matches[1]) > 0) {
            foreach($matches[1] as $id) {
                $to_email = User::find($id)->email;

                dispatch(new CommentMentionEmail($to_email, Auth::user()->name, $this->newComment->comment));
            }
        }

        $this->newComment->board_item_id = $this->activeItem->id;
        $this->newComment->user_id = Auth::id();
        $this->newComment->save();
        $this->newComment = BoardItemComment::make();

        $this->emit('commentPosted');
        $this->emit('refreshComponent');
    }

    public function confirmDeleteComment($id)
    {
        $this->showDeleteCommentModal = true;
        $this->deletingComment = $id;
    }

    public function deleteComment()
    {
        $comment = BoardItemComment::find($this->deletingComment);

        if($comment->user_id != Auth::id() && !$this->currentUser->can($this->board->name . '-delete any comment')) {
            return;
        }

        $comment->delete();

        $this->emit('refreshComponent');

        $this->showDeleteCommentModal = false;
        $this->deletingComment = null;

        // session()->flash('message', 'Comment deleted successfully');
    }
    // End Item Comments
}


