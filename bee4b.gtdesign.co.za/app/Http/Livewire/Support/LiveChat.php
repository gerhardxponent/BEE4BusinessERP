<?php

namespace App\Http\Livewire\Support;

use App\Events\MessageEvent;
use App\Models\Chat;
use App\Models\Message;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class LiveChat extends Component
{
    public $user;
    public $activeChat;
    public $newMessage;
    public $newChat;
    public $allUsers;
    public $newUser;

    // protected $listeners = [
    //     'echo:message,MessageEvent' => 'messageTest',
    //     'refreshChats' => '$refresh',
    // ];

    public function getListeners()
    {
        $user_id = Auth::id();

        $chats = Auth::user()->chats;

        $res = [
            'refreshChats' => '$refresh',
            "echo:new-chat-{$user_id},NewChatEvent" => "updateMessages",
        ];

        foreach($chats as $chat) {
            $res["echo:chat.{$chat->id},MessageEvent"] = "updateMessages";
        }

        return $res;

        // return [
        //     "echo:chat.{$auth_id},MessageEvent" => "updateMessages",
        //     'refreshChats' => '$refresh',
        //     // 'setActiveChat',
        // ];
    }

    public function updateMessages($data)
    {
        // dd('hello');
        $this->emit('refreshChats');
        // $this->emit('refreshList');

        $this->emit('newMessage', $data['message_id']);
    }

    protected $rules = [
        'newMessage.content' => 'required',
        'newUser' => 'required',
    ];

    public function mount()
    {
        $this->user = User::find(Auth::id());
        $this->activeChat = Chat::make();
        $this->newMessage = Message::make();
        $this->newChat = Chat::make();
        $this->allUsers = User::all();
    }

    public function render()
    {
        return view('livewire.support.live-chat');
    }

    public function setActiveChat($id)
    {
        $this->activeChat = Chat::find($id);
    }

    public function messageTest()
    {
        // dd('hello');
        $this->emit('refrehsChats');
    }

    // public function sendMessage()
    // {
    //     event(new MessageEvent);
    //     return;
    // }

    public function sendMessage()
    {
        $this->newMessage->chat_id = $this->activeChat->id;
        $this->newMessage->user_id = $this->user->id;
        if($this->user->id == $this->activeChat->user1_id) 
            $this->newMessage->recipient_id = $this->activeChat->user2_id;
        else
            $this->newMessage->recipient_id = $this->activeChat->user1_id;
        
        $this->newMessage->save();
        
        event(new MessageEvent($this->newMessage->recipient_id, $this->newMessage->id, $this->newMessage->chat_id));

        $this->newMessage = Message::make();

        $this->emit('refreshChats');
    }

    public function createNewChat()
    {
        $this->newChat->user1_id = $this->user->id;
        $this->newChat->user2_id = $this->newUser;
        $this->newChat->save();

        event(new MessageEvent($this->newUser, null, null));
        $this->emit('refreshChats');
    }
}
