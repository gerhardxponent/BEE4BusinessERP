<div>
    <a href="./">
        <div class="flex flex-row space-x-2 text-indigo-600 hover:underline cursor-pointer items-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-arrow-left" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                <line x1="5" y1="12" x2="19" y2="12"></line>
                <line x1="5" y1="12" x2="11" y2="18"></line>
                <line x1="5" y1="12" x2="11" y2="6"></line>
            </svg>
            <span class="font-bold text-lg">Back to My Boards</span>
        </div>
    </a>

    <style>
        .avatar {
            transition: transform 0.8s cubic-bezier(0.075, 0.82, 0.165, 1);
        }
        .contributer-container:hover .avatar {
            transform: translateX(0) !important;
        }

        .username {
            left: 50%;
            top: calc(100% + 5px);
            transform: translateX(-50%);
            transition: opacity 0.1s ease-in-out;
            transition-delay: 0.125s;
        }

        .avatar-container:hover .username {
            opacity: 1;
        }

        .comment-delete-button {
            opacity: 0;
            transition: opacity 0.1s ease-in-out;
        }
        .comment-container:hover .comment-delete-button {
            opacity: 1;
        }

        .file-table {
            height: 210px;
            overflow-y: scroll;
        }
    </style>

    {{-- Notifications --}}
    <div class="fixed z-50 top-20 right-5 space-y-4">
        @if (session()->has('message'))
            <x-toast.success message="{{ session('message') }}"></x-toast.success>
        @endif
    </div>
    {{-- End Notifications --}}

    <livewire:global-components.projects :entity="$client" />

    <?php /*
    {{-- Board name, contributers and buttons --}}
    <div class="font-bold text-3xl my-8 flex flex-row justify-between items-center">
        <div class="flex flex-row space-x-6 items-center relative mb-2">
            <span>{{ $board->name }}</span>
            {{-- Contributers --}}
            <div class=" flex flex-col">
                <div class="text-sm text-gray-500">Contributers</div>
                <div class="flex flex-row contributer-container">
                    @foreach($board->users as $index => $user)
                    
                    @if($index != 5)
                    <div class="relative avatar-container">
                        <div 
                            wire:click="contributerDetails({{ $user->id }})"
                            style="transform:translateX(-{{ $index }}rem);"
                            class="avatar cursor-pointer mr-1 shadow-md border-2 border-white w-10 h-10 bg-blue-200 text-base p-2 rounded-full flex items-center justify-center"
                            >
                            <span>{{ $this->generateInitials($user->name) }}</span>
                        </div>
                        <div class="username opacity-0 bg-blue-100 px-2 py-0.5 rounded-md whitespace-nowrap absolute text-sm">{{ $user->name }}</div>
                    </div>
                    @else
                    <div class="relative avatar-container">
                        <div 
                            wire:click="showAllContributers"
                            style="transform:translateX(-{{ $index }}rem);"
                            class="avatar cursor-pointer mr-1 shadow-md border-2 border-white w-10 h-10 bg-purple-200 active:bg-purple-300 text-base p-2 rounded-full flex items-center justify-center"
                            >
                            <span>+{{ count($board->users) - 5 }}</span>
                        </div>
                        <div class="username opacity-0 bg-purple-100 px-2 py-0.5 rounded-md whitespace-nowrap absolute text-sm">View All</div>
                    </div>
                    @endif

                    @if($index == 5)
                        @break
                    @endif

                    @endforeach
                </div>
            </div>
            {{-- End contributers --}}
        </div>

        {{-- Board buttons --}}
        <div class="flex flex-row space-x-2">
            <button class="border-2 border-gray-300 p-2 rounded-lg">
                <svg xmlns="http://www.w3.org/2000/svg" class="text-gray-700 icon icon-tabler icon-tabler-star" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                    <path d="M12 17.75l-6.172 3.245l1.179 -6.873l-5 -4.867l6.9 -1l3.086 -6.253l3.086 6.253l6.9 1l-5 4.867l1.179 6.873z"></path>
                </svg>
            </button>
            <button wire:click="$toggle('showFiles')" class="flex flex-row items-center space-x-1 border-2 border-gray-300 p-2 rounded-lg">
                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-files" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                    <path d="M15 3v4a1 1 0 0 0 1 1h4"></path>
                    <path d="M18 17h-7a2 2 0 0 1 -2 -2v-10a2 2 0 0 1 2 -2h4l5 5v7a2 2 0 0 1 -2 2z"></path>
                    <path d="M16 17v2a2 2 0 0 1 -2 2h-7a2 2 0 0 1 -2 -2v-10a2 2 0 0 1 2 -2h2"></path>
                </svg>
                <span class="text-base font-bold">Board Files</span>
            </button>
            <button wire:click="boardSettings" class="flex flex-row items-center space-x-1 border-2 border-gray-300 px-4 py-2 rounded-lg">
                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-settings" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                    <path d="M10.325 4.317c.426 -1.756 2.924 -1.756 3.35 0a1.724 1.724 0 0 0 2.573 1.066c1.543 -.94 3.31 .826 2.37 2.37a1.724 1.724 0 0 0 1.065 2.572c1.756 .426 1.756 2.924 0 3.35a1.724 1.724 0 0 0 -1.066 2.573c.94 1.543 -.826 3.31 -2.37 2.37a1.724 1.724 0 0 0 -2.572 1.065c-.426 1.756 -2.924 1.756 -3.35 0a1.724 1.724 0 0 0 -2.573 -1.066c-1.543 .94 -3.31 -.826 -2.37 -2.37a1.724 1.724 0 0 0 -1.065 -2.572c-1.756 -.426 -1.756 -2.924 0 -3.35a1.724 1.724 0 0 0 1.066 -2.573c-.94 -1.543 .826 -3.31 2.37 -2.37c1 .608 2.296 .07 2.572 -1.065z"></path>
                    <circle cx="12" cy="12" r="3"></circle>
                </svg>
                <span class="text-base font-bold">Board Settings</span>
            </button>
        </div>
        {{-- End board buttons --}}
    </div>
    {{-- End board name, contributers and buttons --}}

    {{-- Files section --}}
    <div>
        @if($showFiles)
        <div class="w-full flex flex-row space-x-4 mb-4">
            @can($board->name . '-upload files')
            <div class="w-1/4">
                <x-input.filepond wire:model="newFiles" key="board-files" multiple />
                <div class="w-full flex justify-center">
                    <x-jet-button wire:click="uploadBoardFiles">Upload</x-jet-button>
                </div>
            </div>
            @endcan

            <div 
                class="file-table bg-white rounded-lg @can($board->name . '-upload files') w-3/4 @else w-full @endcan"
                >
                <table class="w-full table-auto relative bg-white">
                    <thead>
                        <tr>
                            <th class="sticky top-0 bg-gray-200 py-2 text-gray-800">File Name</th>
                            <th class="sticky top-0 bg-gray-200 py-2 text-gray-800">Type</th>
                            <th class="sticky top-0 bg-gray-200 py-2 text-gray-800">Size (KB)</th>
                            <th class="sticky top-0 bg-gray-200 py-2 text-gray-800">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($this->boardFiles as $file)
                        <tr class="hover:bg-gray-100">
                            <td class="px-4 py-1">
                                <a wire:click="selectFile({{ $file->id }})" class="cursor-pointer hover:underline text-blue-600">{{ $file->file_name }}</a>
                            </td>
                            <td class="px-4 py-1 text-center">{{ $file->type }}</td>
                            <td class="px-4 py-1 text-center">{{ $file->file_size }}</td>
                            <td class="px-4 py-1 text-center flex flex-row items-center justify-center space-x-2">
                                {{-- Download button --}}
                                <div wire:click="selectAndDownload({{ $file->id }})" class="cursor-pointer transition-colors bg-white p-1 rounded-md text-black hover:bg-emerald-500 hover:text-white active:bg-emerald-600 active:text-white">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-download" width="20" height="20" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                        <path d="M4 17v2a2 2 0 0 0 2 2h12a2 2 0 0 0 2 -2v-2"></path>
                                        <polyline points="7 11 12 16 17 11"></polyline>
                                        <line x1="12" y1="4" x2="12" y2="16"></line>
                                    </svg>
                                </div>
                                {{-- Delete button --}}
                                @can($board->name . '-delete files')
                                <button
                                    wire:click="confirmDelete({{ $file->id }})" 
                                    class="cursor-pointer hover:bg-rose-500 hover:text-white transition-colors bg-white p-1 rounded-md  text-black"
                                    >
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-trash" width="20" height="20" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                        <line x1="4" y1="7" x2="20" y2="7"></line>
                                        <line x1="10" y1="11" x2="10" y2="17"></line>
                                        <line x1="14" y1="11" x2="14" y2="17"></line>
                                        <path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12"></path>
                                        <path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3"></path>
                                    </svg>
                                </button>
                                @endcan
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @endif
    </div>
    {{-- End files section --}}
    
    <div class="flex flex-row gap-4">
        {{-- Left Panel --}}
        <div class="w-1/4 h-100 bg-white p-4 rounded-md transition-opacity @if($editing) opacity-50 @endif">
            {{-- New and Filter buttons --}}
            <div class="font-bold text-lg mb-4 px-4 flex flex-row items-center justify-between">
                <div>Tasks</div>
                <div class="flex flex-row space-x-1">
                    @can($board->name . '-add items')
                    <div class="relative">
                        <button 
                            wire:click="showCreateModal" 
                            class="
                            @if(!$editing) cursor-pointer border-gray-300 active:bg-gray-200 @endif
                            cursor-default border p-1 rounded-md"
                            >
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-plus" width="20" height="20" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                <line x1="12" y1="5" x2="12" y2="19"></line>
                                <line x1="5" y1="12" x2="19" y2="12"></line>
                            </svg>
                        </button>
                    </div>
                    @endcan

                    <div>
                        <button
                            wire:click="setShowFilters"
                            class="
                            @if(!$editing) cursor-pointer border-gray-300 active:bg-gray-200 @endif
                            cursor-default border p-1 rounded-md"
                            >
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-adjustments-horizontal" width="20" height="20" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                <circle cx="14" cy="6" r="2"></circle>
                                <line x1="4" y1="6" x2="12" y2="6"></line>
                                <line x1="16" y1="6" x2="20" y2="6"></line>
                                <circle cx="8" cy="12" r="2"></circle>
                                <line x1="4" y1="12" x2="6" y2="12"></line>
                                <line x1="10" y1="12" x2="20" y2="12"></line>
                                <circle cx="17" cy="18" r="2"></circle>
                                <line x1="4" y1="18" x2="15" y2="18"></line>
                                <line x1="19" y1="18" x2="20" y2="18"></line>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
            {{-- End new and filter buttons --}}

            {{-- Filters --}}
            <div>
            @if($showFilters)
                <div class="p-4 bg-gray-100 rounded-lg space-y-4 mb-2">
                    <div 
                        wire:ignore 
                        wire:key="tag-filter"
                        >
                        <x-jet-label for="tagFilter" value="Tag" />
                        <select id="tagFilter"  multiple style="width:100%;">
                            @foreach($this->tags as $tag)
                            <option value="{{ $tag->id }}">{{ $tag->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div
                        wire:ignore
                        wire:key="assigned-user-filter"
                        >
                        <x-jet-label for="assignedUsersFilter" value="Assigned user" />
                        <x-select id="assignedUsersFilter" multiple style="width:100%;">
                            @foreach($contributers as $user)
                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                            @endforeach
                        </x-select>
                    </div>

                    <div class="w-full flex flex-row items-center justify-center">
                        @if(count($filters['tags']) != 0 || count($filters['user']) != 0)
                        <button
                            wire:click="clearFilters"
                            class="bg-red-100 text-red-900 font-bold flex flex-row items-center justify-center px-4 py-2 rounded-lg"
                            >
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-x" width="20" height="20" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                <line x1="18" y1="6" x2="6" y2="18"></line>
                                <line x1="6" y1="6" x2="18" y2="18"></line>
                            </svg>
                            <span>Clear Filters</span>
                        </button>
                        @endif
                    </div>
                </div>
            @endif
            </div>
            {{-- End filters --}}

            {{-- Task list --}}
            <div class="space-y-1">
                @if(count($this->items) == 0)
                    <div class="w-full py-10">
                        <div class="text-center text-lg text-gray-600">
                            No tasks to show
                            <div class="text-gray-400 pt-2">Click the plus button above to create a new one</div>
                        </div>
                    </div>
                @else
                    @foreach($this->items as $index => $boardItem)
                    <div 
                        wire:click="setActiveItem('{{ $boardItem->id }}')"
                        wire:key="board-item={{ $index }}"
                        class="
                        @if($activeItem->name == $boardItem->name) bg-blue-600 text-white hover:bg-blue-600 @endif
                        @if(!$editing) cursor-pointer hover:bg-gray-200 active:bg-gray-300 @endif
                        flex flex-row items-center justify-between px-4 py-2 rounded-md"
                        >
                        <div class="flex flex-row items-center justify-start space-x-2">
                            <input 
                            class="rounded-full p-2 border-1 border-gray-400 checked:border-white checked:bg-emerald-500 hover:border-gray-400" 
                            type="checkbox" @if($boardItem->completed == 1) checked @endif 
                            wire:click="setCompleted({{ $boardItem->id }})" 
                            />
                            <span>{{ $boardItem->name }}</span>
                        </div>

                        @can($board->name . '-delete items')
                        <button 
                            wire:click="inlineDelete" 
                            class="
                            @if(!$editing) cursor-pointer hover:bg-rose-500 hover:text-white @endif
                            transition-colors cursor-default bg-white p-1 rounded-md  text-black"
                            >
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-trash" width="20" height="20" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                <line x1="4" y1="7" x2="20" y2="7"></line>
                                <line x1="10" y1="11" x2="10" y2="17"></line>
                                <line x1="14" y1="11" x2="14" y2="17"></line>
                                <path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12"></path>
                                <path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3"></path>
                            </svg>
                        </button>
                        @endcan
                    </div>
                    @endforeach
                @endif
            </div>
            {{-- End task list --}}
        </div>
        {{-- End left panel --}}

        {{-- Board Item details --}}
        <div
            wire:loading.class="opacity-50"
            wire:target="setActiveItem"
            class="w-3/4 bg-white rounded-md transition-opacity"
            >
            @if(!isset($activeItem->name))
                <div class="h-100 bg-white p-4 space-y-4 flex items-center justify-center">
                    <div class="text-xl text-gray-600">No task selected</div>
                </div>
            @else
                <div
                    class="h-100  p-4 space-y-6"
                    >
                    {{-- Edit and delete buttons --}}
                    <div class="flex flex-row justify-between items-center">
                        <div class="flex flex-row w-full justify-between">
                            @can($board->name . '-edit items')
                            {{-- Edit --}}
                            <div class="flex flex-row justify-start items-center space-x-2">
                                <button class="border border-gray-300 p-2 rounded-md active:bg-gray-300" wire:click="toggleEdit">
                                    @if($editing)
                                    <div class="flex flex-row space-x-1 items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-x" width="20" height="20" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                            <line x1="18" y1="6" x2="6" y2="18"></line>
                                            <line x1="6" y1="6" x2="18" y2="18"></line>
                                        </svg>
                                        <span class="font-bold">Cancel</span>
                                    </div>
                                    @else
                                    <div class="flex flex-row space-x-1 items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-edit" width="20" height="20" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                            <path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1"></path>
                                            <path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z"></path>
                                            <path d="M16 5l3 3"></path>
                                        </svg>
                                        <span class="font-bold">Edit</span>
                                    </div>
                                    @endif
                                </button>
                                @if($editing)
                                    <button class="space-x-1 border border-gray-300 p-2 rounded-md active:bg-gray-300 flex flex-row items-center" wire:click="save">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-device-floppy" width="20" height="20" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                            <path d="M6 4h10l4 4v10a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2v-12a2 2 0 0 1 2 -2"></path>
                                            <circle cx="12" cy="14" r="2"></circle>
                                            <polyline points="14 4 14 8 8 8 8 4"></polyline>
                                        </svg>
                                        <span class="font-bold">Save</span>
                                    </button>
                                @endif
                            </div>
                            @endcan

                            <div class="font-bold text-xl">
                                @if($editing)
                                <x-jet-input type="text" wire:model.defer="activeItem.name" />
                                @else
                                {{ $activeItem->name }}
                                @endif
                            </div>

                            {{-- Delete --}}
                            @can($board->name . '-delete items')
                            <div>
                                <button class="border border-gray-300 p-2 rounded-md active:bg-gray-300" wire:click="$set('showDeleteItemModal', true)">
                                    <div class="flex flex-row space-x-1 items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-trash" width="20" height="20" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                            <line x1="4" y1="7" x2="20" y2="7"></line>
                                            <line x1="10" y1="11" x2="10" y2="17"></line>
                                            <line x1="14" y1="11" x2="14" y2="17"></line>
                                            <path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12"></path>
                                            <path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3"></path>
                                        </svg>
                                        <span class="font-bold">Delete</span>
                                    </div>
                                </button>
                            </div>
                            @endcan
                        </div>
                    </div>
                    {{-- End edit and delete buttons --}}

                    {{-- Description --}}
                    <div>
                        <div class="text-base font-bold">Description</div>
                        @if($editing)
                        <x-textarea wire:model.defer="activeItem.description" rows="5"></x-textarea>
                        @else
                        <div>{{ $activeItem->description }}</div>
                        @endif
                    </div>
                    {{-- End description --}}

                    {{-- Created by and on --}}
                    @if(!$editing)
                    <div class="flex flex-row space-x-8">
                        <div>
                            <div class="text-base font-bold">Created By</div>
                            <div>@if(isset($activeItem->user)) {{ $activeItem->user->name }} @endif</div>
                        </div>
                        <div>
                            <div class="text-base font-bold">Created On</div>
                            <div>{{ $activeItem->created_at }}</div>
                        </div>
                    </div>
                    @endif
                    {{-- End created by and on --}}

                    {{-- Deadline --}}
                    @if(isset($activeItem->deadline))
                    <div>
                        <div class="text-base font-bold">Deadline</div>
                        @if($editing)
                        <x-jet-input wire:model.defer="activeItem.deadline" type="datetime-local" />
                        @else
                        <div>{{ date('D, d F Y, H:i', strtotime($activeItem->deadline)) }}</div>
                        @endif
                    </div>
                    @endif
                    {{-- End deadline --}}

                    {{-- Assigned to --}}
                    <div>
                        <div class="text-base font-bold">Assigned To</div>
                        @if(isset($activeItem->assignedUsers))
                            @if($editing)
                            <div wire:key="assign-select-edit">
                                <div wire:ignore>
                                    <select class="assign-select-edit" multiple="multiple" style="width:100%;">
                                        @foreach($contributers as $user)
                                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            @else
                            <div>
                                <div class="flex flex-row contributer-container">
                                    @foreach($activeItem->assignedUsers as $index => $user)
                                    <div 
                                        style="transform:translateX(-{{ $index }}rem);"
                                        class="avatar mr-1 shadow-md border-2 border-white w-10 h-10 bg-violet-200 text-base p-2 rounded-full flex items-center justify-center"
                                        >
                                        <span class="font-bold">{{ $this->generateInitials($user->name) }}</span>
                                    </div>
                                    @endforeach
                                </div>        
                            </div>
                            @endif
                        @endif  
                    </div>
                    {{-- End assigned to --}}

                    {{-- Tags --}}
                    <div>
                        <div class="text-base font-bold">Tags</div>
                        @if(isset($activeItem->tags))
                            @if($editing)
                            <div wire:key="tag-select-edit-{{ $iteration }}">
                                <div wire:ignore>
                                    <select class="tag-select-edit" multiple="multiple" style="width:100%;">
                                        @foreach($this->tags as $tag)
                                        <option value="{{ $tag->id }}">{{ $tag->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <a class="cursor-pointer hover:underline text-blue-700" wire:click="$set('showCreateTagModal', true)">Create new</a>
                            @else
                            <div class="space-y-2">
                                <div>
                                    @foreach($activeItem->tags as $tag)
                                    <span class="bg-{{ $tag->color }}-100 font-bold text-sm text-{{ $tag->color }}-900 px-4 py-1 rounded-md">{{ ucfirst($tag->name) }}</span>
                                    @endforeach
                                </div>
                            </div>
                            @endif
                        @endif
                    </div>
                    {{-- End Tags    --}}

                    {{-- Comments --}}
                    @if(!$editing)
                    <div>
                        <div class="font-bold">
                            <span>{{ count($activeItem->comments) }}</span>
                            <span>Comments</span>
                        </div>
                        @can($board->name . '-post comments')
                        <div class="flex flex-col items-end space-y-2 mb-6">
                            <div class="w-full">
                                <x-mention wire:model.defer="newComment.comment" :mentionables="$contributerNames" />
                            </div>
                            <div class="flex justify-end">
                                <x-jet-button wire:click="postComment">Post comment</x-jet-button>
                            </div>
                        </div>
                        @endcan
                        <div class="space-y-4">
                            @foreach($activeItem->comments as $comment)
                            <div class="comment-container flex flex-row items-start space-x-2 border-b border-gray-100 pb-3">
                                <div class="mr-1 shadow-md border-2 border-white w-8 h-8 bg-indigo-200 text-base p-2 rounded-full flex items-center justify-center">
                                    <span class="font-bold text-sm">{{ $this->generateInitials($comment->user->name) }}</span>
                                </div>
                                <div class="flex flex-col">
                                    <div>
                                        <div class="flex flex-row space-x-1 items-center comment-author">
                                            <span class="font-bold">{{ $comment->user->name }}</span>
                                            @if($comment->user_id == Auth::id() || $currentUser->can($board->name . '-delete any comment'))
                                            <div class="cursor-pointer text-red-600 comment-delete-button flex flex-row" wire:click="confirmDeleteComment({{ $comment->id }})">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-trash" width="16" height="16" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                    <line x1="4" y1="7" x2="20" y2="7"></line>
                                                    <line x1="10" y1="11" x2="10" y2="17"></line>
                                                    <line x1="14" y1="11" x2="14" y2="17"></line>
                                                    <path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12"></path>
                                                    <path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3"></path>
                                                </svg>
                                                <span class="text-xs">Delete comment</span>
                                            </div>
                                            @endif
                                        </div>
                                    </div>
                                    <div>@php echo $comment->comment @endphp</div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endif
                    {{-- End comments --}}
                </div>
            @endif
        </div>
        {{-- End board item details --}}
    </div>

    {{-- Colors --}}
    <div>
        <div class="bg-red-100"></div>
        <div class="bg-sky-100"></div>
        <div class="bg-violet-100"></div>

        <div class="bg-violet-200"></div>

        <div class="text-red-900"></div>
        <div class="text-sky-900"></div>
        <div class="text-violet-900"></div>    
    </div>
    {{-- End colors --}}

    {{-- Modals --}}
    <x-modal.confirmation wire:model="showDeleteFileModal">
        <x-slot name="title">Delete File</x-slot>
        <x-slot name="content">Are you sure you would like to delete {{ $selectedFile->file_name }}?</x-slot>
        <x-slot name="footer">
            <x-buttons.cancel-button wire:click="$set('showDeleteFileModal', false)">Cancel</x-buttons.cancel-button>
            <x-buttons.delete-button wire:click="deleteFile">Delete</x-buttons.delete-button>
        </x-slot>
    </x-modal.confirmation>

    <x-modal.dialog wire:model="showAllContributersModal">
        <x-slot name="title">All contributers</x-slot>

        <x-slot name="content">
            @foreach($contributers as $contributer)
            <div>{{ $contributer->name }}</div>
            @endforeach
        </x-slot>

        <x-slot name="footer">
            <x-jet-button wire:click="$set('showAllContributersModal', false)">Close</x-jet-button>
        </x-slot>
    </x-modal.dialog>

    <x-modal.confirmation wire:model="showDeleteCommentModal">
        <x-slot name="title">Delete Comment</x-slot>
        <x-slot name="content">Are you sure you would like to delete this comment?</x-slot>
        <x-slot name="footer">
            <x-buttons.cancel-button wire:click="$set('showDeleteCommentModal', false)">Cancel</x-buttons.cancel-button>
            <x-buttons.delete-button wire:click="deleteComment">Delete</x-buttons.delete-button>
        </x-slot>
    </x-modal.confirmation>

    <x-modal.dialog wire:model="showCreateItemModal">
        <x-slot name="title">
            Create New Task
        </x-slot>

        <x-slot name="content">
            <form class="space-y-4">
                <div>
                    <x-jet-label for="name" value="Name" />
                    <x-jet-input type="text" id="name" wire:model.defer="newItem.name" />
                </div>

                <div>
                    <x-jet-label for="description" value="Description" />
                    <x-textarea rows="5" id="description" wire:model.defer="newItem.description"></x-textarea>
                </div>

                <div>
                    <x-jet-label for="priority" value="Priority" />
                    <x-jet-input type="text" id="priority" wire:model.defer="newItem.priority" />
                </div>

                <div>
                    <x-jet-label for="deadline" value="Deadline" />
                    <x-jet-input type="datetime-local" id="deadline" wire:model.defer="newItem.deadline" />
                </div>

                {{-- <div>
                    <x-jet-label for="tags" value="Tags" />
                    <div wire:ignore>
                        <select class="tag-select" multiple="multiple" style="width: 100%;">
                            @foreach($this->tags as $tag)
                            <option value="{{ $tag->id }}">{{ $tag->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div>
                    <x-jet-label for="assign" value="Assign To" />
                    <div wire:ignore>
                        <select class="assign-select" multiple="multiple" style="width:100%;">
                            @foreach($contributers as $contributer)
                            <option value="{{ $contributer->id }}">{{ $contributer->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div> --}}

                <div>
                    {{-- <x-select2-multiple
                        wire:model="users"
                        :options="$contributers"
                    /> --}}

                    <x-select2-multiple 
                        id="test-select2" 
                        wire:model="users" 
                        multiple 
                        wire:key="lskajwioeiqe" 
                        {{-- initial="{{ join(',', $users) }}" --}}
                        >
                        @foreach($contributers as $contributer)
                        <option value="{{ $contributer->id }}">{{ $contributer->name }}</option>
                        @endforeach
                    </x-select2-multiple>

                    <x-select2-multiple id="test-select2-2" wire:model="var" multiple wire:key="skadjlskajd">
                        @foreach($this->tags as $tag)
                        <option value="{{ $tag->id }}">{{ $tag->name }}</option>
                        @endforeach
                    </x-select2-multiple>
                </div>
            </form>
        </x-slot>

        <x-slot name="footer">
            <div class="flex flex-row items-center justify-end space-x-2">
                <x-buttons.cancel-button wire:click="$set('showCreateItemModal', false)">Cancel</x-buttons.cancel-button>
                <x-create-button wire:click="createItem">Create</x-create-button>
            </div>
        </x-slot>
    </x-modal.dialog>

    <x-modal.dialog wire:model="showCreateTagModal">
        <x-slot name="title">Create Tag</x-slot>

        <x-slot name="content">
            <form>
                <div>
                    <x-jet-label for="tag-name" value="Name" />
                    <x-jet-input type="text" wire:model.defer="newTag.name" />
                </div>

                <div>
                    <x-jet-label for="tag-color" value="Color" />
                    <x-select id="tag-color" wire:model="newTag.color">
                        <option value="">Select a color</option>
                        <option value="red">Red</option>
                        <option value="sky">Sky</option>
                        <option value="violet">Violet</option>
                    </x-select>
                </div>
            </form>
        </x-slot>

        <x-slot name="footer">
            <div class="flex flex-row items-center justify-end">
                <x-buttons.cancel-button wire:click="$set('showCreateTagModal', false)">Cancel</x-buttons.cancel-button>
                <x-create-button wire:click="createTag">Create Tag</x-create-button>
            </div>
        </x-slot>
    </x-modal.dialog>

    <x-modal.confirmation wire:model="showDeleteItemModal">
        <x-slot name="title">Delete Task</x-slot>
        <x-slot name="content">Are you sure you would like to delete this task?</x-slot>
        <x-slot name="footer">
            <x-buttons.cancel-button wire:click="$set('showDeleteItemModal', false)">Cancel</x-buttons.cancel-button>
            <x-buttons.delete-button wire:click="deleteItem">Delete</x-buttons.delete-button>
        </x-slot>
    </x-modal.confirmation>

    <x-modal.dialog wire:model="showFileDetailsModal">
        <x-slot name="title">
            <div class="space-x-4 flex items-center flex-row justify-between">
                <span class="font-bold text-xl">{{ $selectedFile->file_name }}</span>
                @if($editFile)
                <div class="flex flex-row justify-end items-center">
                    <x-buttons.cancel-button wire:click="toggleFileEdit">Cancel</x-buttons.cancel-button>
                    <x-buttons.save-button wire:click="updateFile">Save</x-buttons.save-button>
                </div>
                @else
                <x-buttons.edit-button wire:click="$toggle('editFile')">Edit</x-button.edit-button>
                @endif
                {{-- <x-buttons.edit-button wire:click="$toggle('editFile')">Edit</x-button.edit-button> --}}
            </div>
        </x-slot>

        <x-slot name="content">
            <table class="table-fixed border-separate [border-spacing:0.75rem]">
                <tr>
                    <td class="align-top"><span class="font-bold">File Name</span></td>
                    @if($editFile)
                    <td>
                        <span>@error('selectedFile.file_name') <span class="text-red-500">{{ $message }}</span> @enderror</span>
                        <x-jet-input wire:model.defer="selectedFile.file_name" type="text" />
                    </td>
                    @else
                    <td>{{ $selectedFile->file_name }}</td>
                    @endif
                </tr>
                <tr>
                    <td class="align-top"><span class="font-bold">Uploaded By</span></td>
                    <td>
                        @isset($selectedFile->file_name)
                            @can('view users')
                            <a class="table-link" href="../users/{{ $selectedFile->user()->first()->id }}">{{ $selectedFile->user()->first()->name }}</a>
                            @else
                            <span>{{ $selectedFile->user()->first()->name }}</span>
                            @endcan
                        @endisset
                    </td>
                </tr>
                <tr>
                    <td class="align-top"><span class="font-bold">File Type</span></td>
                    <td>{{ $selectedFile->type }}</td>
                </tr>
                <tr>
                    <td class="align-top"><span class="font-bold">File Size</span></td>
                    <td>{{ $selectedFile->file_size }} KB</td>
                </tr>
                <tr>
                    <td class="align-top"><span class="font-bold">Client Comments</span></td>
                    @if($editFile)
                    <td>
                        <span>@error('selectedFile.client_comments') <span class="text-red-500">{{ $message }}</span> @enderror</span>
                        <x-textarea wire:model.defer="selectedFile.client_comments" rows="4"></x-textarea>
                    </td>
                    @else
                    <td>{{ $selectedFile->client_comments }}</td>
                    @endif
                </tr>
                <tr>
                    <td class="align-top"><span class="font-bold">Reviewer Comments</span></td>
                    @if($editFile)
                    <td>
                        <span>@error('selectedFile.reviewer_comments') <span class="text-red-500">{{ $message }}</span> @enderror</span>
                        <x-textarea wire:model.defer="selectedFile.reviewer_comments" rows="4"></x-textarea>
                    </td>
                    @else
                    <td>{{ $selectedFile->reviewer_comments }}</td>
                    @endif
                </tr>
            </table>
        </x-slot>

        <x-slot name="footer">
            <div class="space-x-2 flex flex-row items-center justify-end">
                <x-jet-button wire:click="$set('showFileDetailsModal', false)" class="bg-transparent hover:bg-transparent active:bg-transparent">
                    <span class="font-bold text-gray-800">Close</span>
                </x-jet-button>
                <x-jet-button class="space-x-1" wire:click="downloadSelected">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-download w-4 h-4" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <desc>Download more icon variants from https://tabler-icons.io/i/download</desc>
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                        <path d="M4 17v2a2 2 0 0 0 2 2h12a2 2 0 0 0 2 -2v-2"></path>
                        <polyline points="7 11 12 16 17 11"></polyline>
                        <line x1="12" y1="4" x2="12" y2="16"></line>
                    </svg>
                    <span>Download</span>
                </x-jet-button>
            </div>
        </x-slot>
    </x-modal.dialog>
    {{-- End Modals --}}

    <script>
        $(document).ready(function() {
            $('.tag-select').select2({
                mulitple: true,
            });
            $('.tag-select').on('change', function() {
                var data = $('.tag-select').select2("val");
                @this.set('selectedTags', data);
            });

            $('.assign-select').select2({
                mulitple: true,
            });
            $('.assign-select').on('change', function() {
                var data = $('.assign-select').select2("val");
                @this.set('selectedContributers', data);
            });

            Livewire.on('show_filters', () => {
                //tag filter
                $('#tagFilter').select2({
                    mulitple: true,
                    placeholder: 'All Tags',
                });

                $('#tagFilter').on('change', function() {
                    var data = $('#tagFilter').select2('val');
                    @this.set('filters.tags', data);
                })
                //end tag filter

                //users filter
                $('#assignedUsersFilter').select2({
                    mulitple: true,
                    placeholder: 'All Users'
                });

                $('#assignedUsersFilter').on('change', function() {
                    var data = $('#assignedUsersFilter').select2('val');
                    @this.set('filters.user', data);
                });
                //end users filter
            })
            
            //clear all filters
            Livewire.on('clear_filters', () => {
                $('#tagFilter').val(null).trigger('change');
                $('#assignedUsersFilter').val(null).trigger('change');
            })

            Livewire.on('edit', (editingData) => {
                // console.log(editingData)

                //assigned users
                $('.assign-select-edit').val(editingData.users)
                
                $('.assign-select-edit').select2({
                    mulitple: true,
                });

                $('.assign-select-edit').on('change', function() {
                    var data = $('.assign-select-edit').select2("val");
                    @this.set('editingData.users', data);
                });

                //tags
                $('.tag-select-edit').val(editingData.tags)
                
                $('.tag-select-edit').select2({
                    mulitple: true,
                });

                $('.tag-select-edit').on('change', function() {
                    var data = $('.tag-select-edit').select2("val");
                    @this.set('editingData.tags', data);
                });
            });

            // Livewire.on('commentPosted', function() {
            //     document.querySelector('#comment-block').innerHTML = '';
            // });
        });
    </script>
    */ ?>
</div>
