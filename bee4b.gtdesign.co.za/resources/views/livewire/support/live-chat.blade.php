<div>
    <div class="flex flex-row gap-4">
        <div class="w-3/5">
            <livewire:support.components.chat-list />
        </div>

        <div class="w-full">
            <livewire:support.components.chat-window />
        </div>
    </div>

    {{-- <div wire:key="qpeoiepoi">
        <x-select wire:model="newUser">
            @foreach($allUsers as $systemUser)
            <option value="{{ $systemUser->id }}">{{ $systemUser->name }}</option>
            @endforeach
        </x-select>
        <x-jet-button wire:click="createNewChat">New Chat</x-jet-button>
    </div>

    <div wire:key="qiewsmnmzlksadj">
        @foreach ($user->startedChats as $chat)
            <div 
                wire:click="setActiveChat({{ $chat->id }})" 
                class="cursor-pointer hover:underline text-blue-600"
                wire:key="chat-{{ $chat->id }}"
                >
                {{ $chat->user1->name }} + {{ $chat->user2->name }}
            </div>
        @endforeach

        @foreach ($user->participatingChats as $chat)
            <div 
                wire:click="setActiveChat({{ $chat->id }})" 
                class="cursor-pointer hover:underline text-blue-600"
                wire:key="chat-{{ $chat->id }}"
                >
                {{ $chat->user1->name }} + {{ $chat->user2->name }}
            </div>
        @endforeach
    </div>

    <div>
        @foreach ($activeChat->messages as $message)
            <div>{{ $message->content }}</div>
        @endforeach
    </div>

    <div>
        @if(isset($activeChat->id))
            <div>
                <x-textarea wire:model="newMessage.content"></x-textarea>
                <x-jet-button wire:click="sendMessage">Send</x-jet-button>
            </div>
        @endif
    </div> --}}
</div>
