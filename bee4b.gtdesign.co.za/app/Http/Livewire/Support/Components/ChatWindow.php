<?php

namespace App\Http\Livewire\Support\Components;

use App\Events\MessageEvent;
use App\Models\Chat;
use App\Models\Message;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class ChatWindow extends Component
{
    public $user;
    public $activeChat;
    public $newMessage;

    // protected $listeners = [
    //     'setActiveChat',
    //     'refreshChats' => '$refresh',
    //     // 'newMessage' => 'updateMessages'
    // ];

    public function getListeners()
    {
        $auth_id = auth()->user()->id;

        return [
            // "echo:message-read.{$auth_id},MessageReadEvent" => 'testFunc',
            'setActiveChat',
            'refreshChats' => '$refresh',
            'refreshWindow' => '$refresh',
            'deleteChat', 
        ];
    }

    public function deleteChat()
    {
        // dd('hello');
        $this->activeChat = Chat::make();
        $this->emit('refreshChats');
        $this->emit('refreshWindow');
    }

    // public function testFunc()
    // {
    //     $this->emit('refreshChats');
    // }

    protected $rules = [
        'newMessage.content' => 'required',
    ];

    public function mount()
    {
        $this->user = User::find(Auth::id());
        $this->activeChat = Chat::make();
        $this->newMessage = Message::make();
    }

    public function render()
    {
        return view('livewire.support.components.chat-window');
    }

    // public function updateMessages()
    // {

    // }

    public function setActiveChat($id)
    {
        if($id == '') {
            $this->activeChat = Chat::make();
        } else {
            $this->activeChat = Chat::find($id);
            $this->activeChat->messages()->getQuery()
            ->where('recipient_id', $this->user->id)
            ->update([
                'read' => 1
            ]);
        }

        $this->emit('refreshWindow');
        $this->emit('refreshList');
    }

    public function sendMessage()
    {
        $this->newMessage->chat_id = $this->activeChat->id;
        $this->newMessage->user_id = $this->user->id;

        // if($this->user->id == $this->activeChat->user1_id) 
        //     $this->newMessage->recipient_id = $this->activeChat->user2_id;
        // else
        //     $this->newMessage->recipient_id = $this->activeChat->user1_id;

        $this->newMessage->recipient_id = $this->activeChat->users->where('id', '!=', Auth::id())->first()->id;

        $this->newMessage->save();
        $this->activeChat->updated_at = Carbon::now();
        $this->activeChat->save();
        
        event(new MessageEvent($this->newMessage->recipient_id, $this->newMessage->id, $this->newMessage->chat_id));

        $this->newMessage = Message::make();

        $this->emit('refreshChats');
        $this->emit('refreshList');
    }

    public function generateInitials($name)
    {
        $words = explode(" ", $name);
        $initials = null;
        foreach ($words as $w) {
            $initials .= strtoupper($w[0]);
        }
        return $initials;
    }
}
