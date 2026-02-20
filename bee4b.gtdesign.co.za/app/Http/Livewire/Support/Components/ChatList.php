<?php

namespace App\Http\Livewire\Support\Components;

use App\Events\MessageEvent;
use App\Events\MessageReadEvent;
use App\Events\NewChatEvent;
use App\Models\Chat;
use App\Models\Message;
use App\Models\User;
use App\Models\UserChat;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Illuminate\Support\Str;

class ChatList extends Component
{
    public $user;
    public $userID;
    public $allUsers;
    public $newChat;
    public $activeChat; //id only
    public $showConfirmDeleteModal = false;
    public $showNewGroupChatModal = false;
    public $groupChatUsers = [];
    public $deletingChat;
    public $searchString = '';

    protected $rules = [
        'newChat.user2_id' => 'required',
        'newChat.name' => 'required',
    ];

    protected $listeners = [
        'refreshList' => '$refresh',
        'newMessage' => 'updateMessages'
    ];

    public function mount()
    {
        $this->user = User::find(Auth::id());
        $this->userID = Auth::id();

        // $test = array_map(function($value) {
        //     return $value['id'];
        // }, $this->user->chats()->select('id')->get()->toArray());

        // dd(UserChat::whereIn('chat_id', $test)->get()->first());

        // dd($test);
        $this->allUsers = User::where('id', '!=', Auth::id())->get()->sortBy('name');
        // $this->allUsers = User::whereHas('chats', function($query) {
        //     $query->where('user_chats.user_id', '!=', )
        // });



        // dd($this->user->startedChats()->select('user2_id')->get()->toArray());

        // dd(User::whereDoesntHave('participatingChats', function($query) {
        //     $query->where('user2_id', 36);
        // })->get());

        // dd($this->user->chats->first()->users->where('id', '!=', Auth::id()));

        $this->newChat = Chat::make();
    }

    public function getChatsProperty()
    {
        $search = $this->searchString;

        return 
            $this->user->chats()
                ->orderByDesc('updated_at')
                ->orderByDesc('pinned')
                ->when($search, function($query) use($search) {
                    $query->whereHas('users', function($query) use($search) {
                        $query->where('users.name', 'like', '%' . $search . '%');
                    });
                })
                ->get();
    }

    public function render()
    {
        return view('livewire.support.components.chat-list');
    }

    public function updateMessages($message_id)
    {
        if($message_id != null) {
            $message = Message::find($message_id);

            if($message->chat_id == $this->activeChat) {
                $message->update(['read' => '1']);
            }
        }

        $this->emit('refreshList');
    }

    public function generateInitials($name)
    {
        if ($name == '') return '';

        $words = explode(" ", $name);
        $initials = null;
        foreach ($words as $w) {
            $initials .= strtoupper($w[0]);
        }
        return $initials;
    }

    public function setActiveChat($id)
    {
        $this->activeChat = $id;
        // event(new MessageReadEvent(Auth::id()));
        $this->emit('setActiveChat', $id);
        $this->emit('refreshList');
        $this->emit('chat-clicked');
    }

    public function createChat()
    {
        $this->validate([
            'newChat.user2_id' => 'required|unique:chats,user2_id,NULL,NULL,user1_id,' . $this->user->id,
            'userID' => 'required|unique:chats,user1_id,NULL,NULL,user2_id,' . $this->newChat->user2_id,
        ], [
            'newChat.user2_id' => 'Chat already exists',
            'userID' => 'Chat already exists',
        ]);
        

        // $this->newChat->user1_id = $this->user->id;
        // $this->newChat->save();

        // $this->newChat = Chat::make();

        
        // $this->emit('refreshList');
        
        $this->newChat->save();
        $this->newChat->users()->attach([Auth::id(), $this->newChat->user2_id]);
        
        $this->newChat = Chat::make();
        
        event(new NewChatEvent($this->newChat->user2_id));
        $this->emit('refreshList');
    }

    // Delete chat
    public function confirmDeleteChat($id)
    {
        $this->deletingChat = $id;
        $this->showConfirmDeleteModal = true;
    }

    public function deleteChat()
    {
        $this->activeChat = null;
        $chat = Chat::find($this->deletingChat);
        $chat->delete();
        $this->showConfirmDeleteModal = false;
        
        $this->emit('setActiveChat', '');
        // $this->emit('refreshList');
    }
    // End delete chat

    //Pin chat
    public function pinChat($id)
    {
        $chat = Chat::find($id);
        $pinValue = ($chat->pinned == 0) ? 1 : 0;

        $chat->update(['pinned' => $pinValue]);
        $this->emit('refreshList');
    }
    //end pin chat

    //New group chat
    public function createGroup()
    {
        array_push($this->groupChatUsers, Auth::id());

        $this->newChat->isGroup = 1;
        $this->newChat->save();
        $this->newChat->users()->attach($this->groupChatUsers);

        $this->newChat = Chat::make();

        $this->showNewGroupChatModal = false;

        $this->emit('refreshList');
    }
    //End new group chat
}
