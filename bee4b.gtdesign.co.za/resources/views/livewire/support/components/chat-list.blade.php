<div x-data="{ show: false, }">
    <style>
        .box {
            height: 86vh !important;
            background-color: white !important;
            overflow-y: scroll;
        }
    </style>

    <div class="bg-white rounded-lg p-6 w-full box relative">
        <div class="mb-2">
            <div class="flex flex-col">
                <div class="text-2xl font-bold">Messages</div>
                <div class="my-2">
                    <x-buttons.flat x-on:click="show = !show">
                        <x-slot name="icon"><x-icons.plus /></x-slot>
                        New
                    </x-buttons.flat>
                    <x-buttons.flat wire:click="$set('showNewGroupChatModal', true)">
                        <x-slot name="icon"><x-icons.plus /></x-slot>
                        New Group Chat
                    </x-buttons.flat>
                </div>
            </div>

            <div 
                x-show="show" 
                x-transition:enter="ease-out duration-300"
                x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0"
                x-transition:enter-end="opacity-100 translate-y-0"
                x-transition:leave="ease-in duration-200"
                x-transition:leave-start="opacity-100 translate-y-0"
                x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0"
                class="flex flex-row gap-2 w-full justify-start"
                >
                <div class="grow">
                    <x-select2-multiple id="new-chat" wire:model.defer="newChat.user2_id">
                        <option value="">Select User</option>
                        @foreach ($allUsers as $_user)
                            <option value="{{ $_user->id }}">{{ $_user->name }}</option>
                        @endforeach
                    </x-select2-multiple>
                </div>
                <x-jet-button wire:click="createChat">Start</x-jet-button>
            </div>
        </div>

        <x-search-clear wire:model="searchString" placeholder="Search chats..." />

        {{-- Pinned chats --}}
        @if (count($this->chats->where('pinned', 1)) > 0)
            <div class="py-4 text-gray-500 flex flex-row items-center justify-start gap-1">
                <x-icons.pinned size="20" />
                <div>Pinned chats</div>
            </div>

            @foreach($this->chats->where('pinned', 1) as $index => $chat)
                <div>
                    <div 
                        wire:loading.class="opacity-50"
                        wire:target="searchString"
                        class="
                            @if($activeChat == $chat->id) bg-blue-600 hover-blue-600 text-white active:bg-blue-600 
                            @else bg-white hover:bg-gray-50 active:bg-gray-100 @endif
                            flex flex-row space-x-2 items-center transition-colors cursor-pointer rounded-lg justify-between transition-opacity mb-2
                        ">
                        <div class="grid grid-cols-6 w-full py-4 pl-4 rounded-l-lg" wire:click="setActiveChat({{ $chat->id }})">
                            {{-- Initials --}}
                            <div class="col-span-1">
                                <div class="avatar cursor-pointer mr-1 shadow-md border-2 border-white w-10 h-10 @if($chat->isGroup) bg-red-200 @else bg-blue-200 @endif text-base p-2 rounded-full flex items-center justify-center">
                                    <span class="font-bold text-black">
                                        {{ 
                                            $this->generateInitials(isset($chat) && isset($chat->name) ? 
                                            $chat->name : 
                                            $chat->users->where('id', '!=', Auth::id())->first()->name) 
                                        }}
                                    </span>
                                </div>
                            </div>
                            {{-- End initials --}}

                            {{-- Name and last message --}}
                            <div class="col-span-3">
                                <div class="flex flex-col">
                                    {{-- @if($chat->user1->id == $user->id)
                                    <div class="font-bold">{{ $chat->user2->name }}</div>
                                    @else
                                    <div class="font-bold">{{ $chat->user1->name }}</div>
                                    @endif --}}

                                    <div class="font-bold">{{ isset($chat->name) ? $chat->name : $chat->users->where('id', '!=', Auth::id())->first()->name }}</div>

                                    <div class="flex flex-row gap-1 items-center @if($activeChat == $chat->id) text-white @else text-gray-500 @endif">
                                        @if($chat->messages->last() != null)
                                            @if($chat->messages->last()->user_id === Auth::id())
                                            <x-icons.up-arrow width="16" height="16" />
                                            @else
                                            <x-icons.down-arrow width="16" height="16"/>
                                            @endif
                                        <div>{{ \Illuminate\Support\Str::limit($chat->messages->last()->content, 15, $end='...') }}</div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            {{-- End name and last message --}}

                            {{-- Last message time and dot --}}
                            <div class="col-span-2">
                                <div class="@if($activeChat == $chat->id) text-white @else text-gray-600 @endif text-sm text-right">
                                    @if($chat->messages->last() != null)
                                    <div>{{ $chat->messages->last()->created_at->format('Y-m-d') }}</div>
                                    @endif
                                </div>
                                <div class="flex justify-end mt-1">
                                    @if (count($chat->messages->where('read', 0)->where('recipient_id', $user->id)))
                                    <div class="bg-green-500 text-white p-1 font-bold w-4 h-4 rounded-full ">
                                        <div></div>
                                    </div>
                                    @else
                                    <div class="bg-transparent text-white p-1 font-bold w-4 h-4 rounded-full flex justify-center items-center">
                                        <div></div>
                                    </div>
                                    @endif
                                </div>
                            </div>
                            {{-- End last message time and dot --}}
                        </div>

                        <div class="pr-4">
                            <x-jet-dropdown align="right" width="100">
                                <x-slot name="trigger">
                                    <x-icons.vertical-dots />
                                </x-slot>

                                <x-slot name="content">
                                    <x-jet-dropdown-link wire:click="confirmDeleteChat({{ $chat->id }})">Delete</x-jet-dropdown-link>
                                    <x-jet-dropdown-link wire:click="pinChat({{ $chat->id }})">
                                        @if($chat->pinned === 0)
                                        <div>Pin</div>
                                        @else
                                        <div>Unpin</div>
                                        @endif
                                    </x-jet-dropdown-link>
                                </x-slot>
                            </x-jet-dropdown>
                        </div>
                    </div>
                    {{-- <div class="flex-grow border-t border-gray-100 my-2"></div> --}}
                </div>
            @endforeach

            <div class="flex-grow border-t border-gray-300 mb-2"></div>
        @endif
        {{-- End pinned chats --}}

        {{-- Unpinned chats --}}
        @foreach ($this->chats->where('pinned', 0) as $index => $chat)
            <div>
                <div 
                    wire:loading.class="opacity-50"
                    wire:target="searchString"
                    class="
                        @if($activeChat == $chat->id) bg-blue-600 hover-blue-600 text-white active:bg-blue-600 
                        @else bg-white hover:bg-gray-50 active:bg-gray-100 @endif
                        flex flex-row space-x-2 items-center transition-colors cursor-pointer rounded-lg justify-between transition-opacity mb-2
                    ">
                    <div class="grid grid-cols-6 w-full py-4 pl-4 rounded-l-lg" wire:click="setActiveChat({{ $chat->id }})">
                        {{-- Initials --}}
                        <div class="col-span-1">
                            <div class="avatar cursor-pointer mr-1 shadow-md border-2 border-white w-10 h-10 @if($chat->isGroup) bg-red-200 @else bg-blue-200 @endif text-base p-2 rounded-full flex items-center justify-center">
                                <span class="font-bold text-black">
                                    {{ 
                                        $this->generateInitials(isset($chat) && isset($chat->name) ?
                                        $chat->name : 
                                        ($chat->users->where('id', '!=', Auth::id())->first() !== null ? $chat->users->where('id', '!=', Auth::id())->first()->name : ''))
                                    }}
                                </span>
                            </div>
                        </div>
                        {{-- End initials --}}

                        {{-- Name and last message --}}
                        <div class="col-span-3">
                            <div class="flex flex-col">
                                <div class="font-bold">
                                    {{ 
                                        isset($chat) && isset($chat->name) ? 
                                        $chat->name : 
                                        ($chat->users->where('id', '!=', Auth::id())->first() !== null ? $chat->users->where('id', '!=', Auth::id())->first()->name : 'Deleted user')
                                    }}
                                </div>

                                <div class="flex flex-row gap-1 items-center @if($activeChat == $chat->id) text-white @else text-gray-500 @endif">
                                    @if($chat->messages->last() != null)
                                        @if($chat->messages->last()->user_id === Auth::id())
                                            <x-icons.up-arrow width="16" height="16" />
                                        @else
                                            <x-icons.down-arrow width="16" height="16"/>
                                        @endif
                                    <div>{{ \Illuminate\Support\Str::limit($chat->messages->last()->content, 15, $end='...') }}</div>
                                    @endif
                                </div>
                            </div>
                        </div>
                        {{-- End name and last message --}}

                        {{-- Last message time and dot --}}
                        <div class="col-span-2">
                            <div class="@if($activeChat == $chat->id) text-white @else text-gray-600 @endif text-sm text-right">
                                @if($chat->messages->last() != null)
                                <div>{{ $chat->messages->last()->created_at->format('Y-m-d') }}</div>
                                @endif
                            </div>
                            <div class="flex justify-end mt-1">
                                @if (count($chat->messages->where('read', 0)->where('recipient_id', $user->id)))
                                <div class="bg-green-500 text-white p-1 font-bold w-4 h-4 rounded-full ">
                                    <div></div>
                                </div>
                                @else
                                <div class="bg-transparent text-white p-1 font-bold w-4 h-4 rounded-full flex justify-center items-center">
                                    <div></div>
                                </div>
                                @endif
                            </div>
                        </div>
                        {{-- End last message time and dot --}}
                    </div>

                    <div class="pr-4">
                        <x-jet-dropdown align="right" width="100">
                            <x-slot name="trigger">
                                <x-icons.vertical-dots />
                            </x-slot>

                            <x-slot name="content">
                                <x-jet-dropdown-link wire:click="confirmDeleteChat({{ $chat->id }})">Delete</x-jet-dropdown-link>
                                <x-jet-dropdown-link wire:click="pinChat({{ $chat->id }})">
                                    @if($chat->pinned === 0)
                                    <div>Pin</div>
                                    @else
                                    <div>Unpin</div>
                                    @endif
                                </x-jet-dropdown-link>
                            </x-slot>
                        </x-jet-dropdown>
                    </div>
                </div>
                {{-- <div class="flex-grow border-t border-gray-100 my-2"></div> --}}
            </div>
        @endforeach
        {{-- End unpinned chats --}}
    </div>

    {{-- MODALS --}}
    {{-- Confirm delete modal --}}
    <x-jet-confirmation-modal wire:model="showConfirmDeleteModal">
        <x-slot name="title">Delete Chat</x-slot>

        <x-slot name="content">
            Are you sure you would like to delete this chat?
        </x-slot>

        <x-slot name="footer">
            <div class="flex items-center gap-1">
                <x-buttons.cancel-button wire:click="$set('showConfirmDeleteModal', false)">Cancel</x-buttons.cancel-button>
                <x-jet-button wire:click="deleteChat">Delete</x-jet-button>
            </div>
        </x-slot>
    </x-jet-confirmation-modal>
    {{-- End confirm delete modal --}}

    {{-- New group chat modal --}}
    <x-jet-dialog-modal wire:model="showNewGroupChatModal">
        <x-slot name="title">New group chat</x-slot>
        <x-slot name="content">
            <div class="space-y-4">
                <div>
                    <x-jet-label value="Name" for="group-chat-name" />
                    <x-jet-input type="text" id="group-chat-name" wire:model="newChat.name" />
                </div>

                <div class="space-y-2">
                    @foreach (App\Models\User::where('id', '!=', Auth::id())->get() as $user)
                        <div class="flex gap-1 items-center">
                            <x-jet-checkbox id="user-check-{{ $user->id }}" wire:model="groupChatUsers" value="{{ $user->id }}" />
                            <x-jet-label for="user-check-{{ $user->id }}" value="{{ $user->name }}" />
                        </div>
                    @endforeach
                </div>
            </div>
        </x-slot>
        <x-slot name="footer">
            <div class="flex justify-end gap-1 items-center">
                <x-buttons.cancel-button x-on:click="show = false">Cancel</x-buttons.cancel-button>
                <x-create-button wire:click="createGroup">Create</x-create-button>
            </div>
        </x-slot>
    </x-jet-dialog-modal>
    {{-- End new group chat modal --}}
    {{-- END MODALS --}}
</div>
