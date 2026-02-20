<?php

namespace App\Http\Livewire\GlobalComponents;

use App\Jobs\CommentMentionEmail;
use App\Models\Comment;
use App\Models\User;
use App\Models\Activity;
use App\Models\File;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Mail;

class CommentSection extends Component
{
    use WithFileUploads;

    public $users;
    public $entity;
    public $newComment;
    public $activityData;
    // public $activityPath;
    public $activityEntity;
    public $deletingComment;
    public $showConfirmDeleteCommentModal = false;
    public $location = '';
    
    public $files = [];

    protected $rules = [
        'newComment.body' => 'required',
    ];

    protected $listeners = [
        'refreshCommentSection' => '$refresh',
        'confirmDeleteComment',
        'updateEntity',
        'createComment',
    ];

    public function mount($entity)
    {
        $this->entity = $entity;
        $this->newComment = Comment::make();
        $this->deletingComment = Comment::make();
        
        $this->users = User::orderBy('name')->select('id', 'name')->get()->map(function($user) {
            return [
                'key' => $user->name,
                'value' => $user->name,
                'id' => $user->id
            ];
        });
    }

    public function render()
    {
        return view('livewire.global-components.comment-section');
    }

    /**
     * To update the entity variable.
     * For when comment section is in modal
     * 
     * @return void
     */
    public function updateEntity($entityID)
    {
        $this->entity = get_class($this->entity)::find($entityID);
    }

    public function getCommentsProperty()
    {
        return $this->entity
            ->comments()
            ->with('user')
            ->with('replies')
            ->where('parent_id', null)
            ->orderByDesc('pinned')
            ->orderByDesc('created_at')
            ->get();
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

    public function createComment($link)
    {
        // dd($this->files);
        if($this->newComment->body == '') return;

        $this->newComment->link = $link;

        $header = $this->location != '' ? 
            '<div style="margin-bottom:5px;">'.Auth::user()->name.' posted a comment on: '.$this->location.'</div>' : 
            '';
        $linkAnchor = "<div style='margin-bottom:20px;'><a href='".$this->newComment->link."'>Go to comment</a></div>";
        
        $emailBody = $header . $linkAnchor . $this->newComment->body;

        preg_match_all('/@(\d+)@/', $this->newComment->body, $matches);
        if(count($matches[1]) > 0) {
            foreach($matches[1] as $id) {
                $user = User::find($id);
                if (!$user) continue;

                $emailData = [
                    'userName' => $user->name,
                    'commenterName' => Auth::user()->name,
                    'body' => $this->newComment->body,
                    'link' => $link,
                    'location' => $this->location ?? null,
                ];

                Mail::send('emails.comment-mention', $emailData, function ($message) use ($user) {
                    $message->to($user->email)
                            ->cc('xiiphoid@gmail.com')
                            ->subject('You were mentioned in a comment');
                });
            }
        }
        $this->newComment->user_id = Auth::id();
        $this->entity->comments()->save($this->newComment);

        foreach ($this->files as $file) {
            $fileRecord = File::make();
            $filePath = 'uploads/Comments/' . Auth::user()->name;

            $fileRecord->file_name = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
            $fileRecord->user_id = Auth::id();
            $fileRecord->file_path = $filePath;
            $fileRecord->type = $file->getClientOriginalExtension();

            $this->newComment->files()->save($fileRecord);

            $file->storeAs($filePath, $fileRecord->file_name . '.' . $fileRecord->type);
        }
        
        $this->newActivity();

        $this->newComment = Comment::make();
        $this->files = [];

        $this->emit('commentPosted');
        $this->emit('refreshCommentSection');
        $this->emit('all_files_uploaded');

        $this->dispatchBrowserEvent('notify-success', ['message' => 'Comment posted successfully']);
    }

    public function confirmDeleteComment($id)
    {
        $this->deletingComment = Comment::find($id);
        $this->showConfirmDeleteCommentModal = true;
    }

    public function deleteComment()
    {
        if(!isset($this->deletingComment)) {
            return;
        } 

        foreach ($this->deletingComment->files as $file) {
            $fullFileName = $file->file_path . '/' . $file->file_name . '.' . $file->type;
            if (Storage::exists($fullFileName)) {
                Storage::delete($fullFileName);
            }

            $file->delete();
        }

        $this->deletingComment->delete();
        $this->showConfirmDeleteCommentModal = false;

        $this->emitSelf('refreshCommentSection');
        $this->emit('refreshCommentBody');
        $this->dispatchBrowserEvent('notify-success', ['message' => 'Comment deleted successfully']);
    }

    public function newActivity()
    {
        $activity = Activity::make();

        $activity->user_id = Auth::id();
        $activity->title = isset($this->activityData['title']) ? $this->activityData['title'] : 'left a comment';
        $activity->body = isset($this->activityData['body']) ? $this->activityData['body'] . $this->newComment->body : $this->newComment->body;
        $activity->path = isset($this->activityData['path']) ? $this->activityData['path'] : '';
        $activity->activity_type = 'comment';

        $this->activityEntity ? 
            $this->activityEntity->activities()->save($activity) : 
            $this->entity->activities()->save($activity);
    }

    public function removeAttachment($index)
    {
        unset($this->files[$index]);
    }
}
