<?php

namespace App\Http\Livewire\GlobalComponents;

use App\Jobs\CommentMentionEmail;
use App\Jobs\EmailJob;
use App\Models\Comment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

use function PHPUnit\Framework\returnSelf;

class CommentBody extends Component
{
    public $comment;
    public $commentReply;
    public $replies;
    public $users = [];

    protected $rules = [
        'commentReply.body' => 'required',
    ];

    // protected $listeners = [
    //     'refreshCommentBody' => '$refresh',
    //     'postReply'
    // ];

    protected function getListeners()
    {
        return [
            'refreshCommentBody' => '$refresh',
            'postReply-' . $this->comment->id => 'postReply'
        ];
    }

    public function mount($comment)
    {
        $this->comment = $comment;
        $this->commentReply = Comment::make();

        // dd($this->comment->with('replies')->where('id', $comment->id)->get());
    }

    public function render()
    {
        return view('livewire.global-components.comment-body');
    }

    public function getTestProperty()
    {
        return $this->comment->replies;
    }

    public function postReply($link)
    {
        if ($this->commentReply->body == null) return;

        $this->commentReply->user_id = Auth::id();
        $this->commentReply->commentable_id = $this->comment->commentable_id;
        $this->commentReply->commentable_type = $this->comment->commentable_type;
        $this->commentReply->parent_id = $this->comment->id;
        // $this->commentReply->body = $this->commentReply->body == null ? '' : $this->commentReply->body;

        $this->commentReply->save();

        if ($this->commentReply->user_id !== $this->comment->user_id) {
            $emailSubject = Auth::user()->name . ' has replied to your comment';
            $emailContent = $this->commentReply->body;

            dispatch(
                new EmailJob(
                    $this->comment->user->email, 
                    null,
                    Auth::user()->email, 
                    $emailSubject, 
                    $emailContent, 
                    $link
                )
            );
        }

        $this->commentReply = Comment::make();
        $this->emit('commentReplyPosted');
        $this->emit('commentPosted');

        $this->emitSelf('refreshCommentBody');
    }

    public function pinComment()
    {
        if ($this->comment->pinned === 1) {
            $this->comment->pinned = 0;
        } else {
            $this->comment->pinned = 1;
        }

        $this->comment->save();

        // $this->emit('refreshCommentBody');
        $this->emit('refreshCommentSection');
    }
}
