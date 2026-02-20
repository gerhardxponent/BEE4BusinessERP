<div
    x-init="function() {
        $(document).ready(function() {
            Livewire.on('chat-clicked', function() {
                const el = document.querySelector('.message-box');
                if(el != null) {
                    el.scrollTop += 100;
                    console.log(el.scrollTop);
                }
            });
        });
    }"
    >
    <style>
        .message-box {
            height: 86vh !important;
            background-color: white !important;
            overflow-y: scroll;
        }
    </style>

    <div class="bg-white p-6 w-full rounded-lg message-box test-box relative flex flex-col justify-between">
        @if($activeChat->id != null)
            <div class="overflow-y-scroll pb-4" wire:key="message-container">
            @foreach ($activeChat->messages as $index => $message)
                {{-- Message date --}}
                @if($index == 0 || $activeChat->messages[$index-1]->created_at->format('d M Y') != $message->created_at->format('d M Y'))
                <div class="flex items-center justify-center text-gray-400 mt-4 sticky top-0 bg-white">
                    <div>{{ $message->created_at->format('d M Y') }}</div>
                </div>
                @endif
                {{-- End message date --}}

                {{-- Message --}}
                @if($message->user_id == $user->id) {{-- Message sent --}}
                <div class="flex flex-col items-end" wire:key="my-message-{{ $message->id }}">
                    {{-- Message content --}}
                    <div class="flex justify-end items-center gap-1 w-3/4">
                        <div class="bg-blue-500 text-white text-lg rounded-t-2xl rounded-bl-2xl px-4 py-2 mt-2">
                            <div class="break-all">{{ $message->content }}</div>
                        </div>
                        @if($activeChat->isGroup === 1)
                        <div class="avatar cursor-pointer mr-1 shadow-md border-2 border-white w-10 h-10 bg-blue-200 text-base p-2 rounded-full flex items-center justify-center">
                            <span class="font-bold text-black">
                                {{ $this->generateInitials($message->user->name) }}
                            </span>
                        </div>
                        @endif
                    </div>
                    {{-- End message content --}}

                    {{-- Message time --}}
                    <div class="text-gray-500 text-sm flex gap-1">
                        <div>{{ $message->created_at->format('H:i') }}</div>
                    </div>
                    {{-- End message time --}}
                </div>
                @else {{-- Message recieved --}}
                <div class="flex flex-col items-start" wire:key="recieved-message-{{ $message->id }}">
                    {{-- Message content --}}
                    <div class="flex justify-start items-center gap-1 w-3/4">
                        @if($activeChat->isGroup === 1)
                        <div class="avatar cursor-pointer mr-1 shadow-md border-2 border-white w-10 h-10 bg-blue-200 text-base p-2 rounded-full flex items-center justify-center">
                            <span class="font-bold text-black">
                                {{ $this->generateInitials($message->user->name) }}
                            </span>
                        </div>
                        @endif
                        <div class="bg-gray-200 text-black text-lg rounded-t-2xl rounded-br-2xl px-4 py-2 mt-2">
                            <div class="break-all">{{ $message->content }}</div>
                        </div>
                    </div>
                    {{-- End message content --}}

                    {{-- Message time --}}
                    <div class="text-gray-500 text-sm flex gap-1">
                        <div>{{ $message->created_at->format('H:i') }}</div>
                    </div>
                    {{-- End message time --}}
                </div>
                @endif
                {{-- End message --}}
            @endforeach
            </div>

            <div class="sticky bottom-0 left-0 top-full w-full flex flex-row gap-4" style="box-shadow: 0px 1px 7px 9px #FFFFFF;" wire:key="message-box">
                <x-jet-input placeholder="Write a message..." type="text" class="" wire:model.defer="newMessage.content" />
                <x-jet-button wire:click="sendMessage">Send</x-jet-button>
            </div>
        @else
            <div class="flex flex-col justify-center items-center gap-4 h-full">
                <div class="text-xl text-gray-500">No chat selected</div>
                <div class="text-gray-500">Click on a contact on the left, or click the plus icon to start a new chat</div>
            </div>
        @endif
    </div>
</div>
