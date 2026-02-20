<div x-data="{ show: false, show_subtasks: false, newSubtask: false, }">
    <x-toast.success-event />

    <div class="flex flex-row space-x-2 mb-4 items-center justify-between">
        @unless ($showArchived)
        <x-tabs.tab-layout>
            @foreach ($this->clientBoards as $index => $board)
                <x-tabs.tab 
                    {{-- click="changeTab('{{ $tab }}')" --}}
                    click="setActiveBoard({{ $board->id }})"
                    :current="(($activeBoard !== null) && ($activeBoard->id === $board->id)) ? true : false"
                    >
                    {{ $board->name }}
                </x-tabs.tab>
            @endforeach
        </x-tabs.tab-layout>
        @else
        <div>
            <button 
                wire:click="toggleShowArchived"
                class="border border-gray-300 p-2 rounded-md active:bg-gray-300"
            >
                <div class="flex flex-row space-x-1 items-center">
                    <x-icons.left-arrow />
                    <span class="font-bold">Back to all projects</span>
                </div>
            </button>
        </div>
        @endunless

        <div class="flex items-center gap-2">
            @if(
                (Auth::user()->hasPermissionTo('view all projects') || Auth::id() == $client->manager || Auth::id() == $client->analyst) &&
                (!$showArchived) &&
                ($activeBoardID !== null)
            )
            <div wire:click="archiveBoard" class="relative group p-2 hover:bg-indigo-100 active:bg-indigo-200 text-indigo-900 rounded-lg cursor-pointer">
                <x-icons.archive-filled size="30" />
                <div class="absolute hidden group-hover:block bottom-[110%] -translate-x-1/2 left-1/2 bg-indigo-100 rounded-md px-2 font-bold text-indigo-900 whitespace-nowrap">Archive</div>
            </div>
            @endif
            @if (!$showArchived && $activeBoardID !== null)
            <div>
                <div wire:click="$toggle('showKanban')" class="relative group p-2 hover:bg-sky-100 active:bg-sky-200 text-sky-900 rounded-lg cursor-pointer">
                    <x-icons.kanban-filled size="30" />
                    <div class="absolute hidden group-hover:block bottom-[110%] -translate-x-1/2 left-1/2 bg-sky-100 rounded-md px-2 font-bold text-sky-900 whitespace-nowrap">Board</div>
                </div>
            </div>
            @endif
            @if(
                (Auth::user()->hasPermissionTo('view all projects') || Auth::id() == $client->manager || Auth::id() == $client->analyst) &&
                (!$showArchived)
            )

            @if($currentBoard)
            <div class="mb-3 flex items-center justify-between" style="margin-bottom:0px;">
                <h2 class="text-lg font-semibold">
                @if($currentBoard->red_flagged)
                    <span class="ml-2 inline-flex items-center rounded bg-red-100 px-1.5 py-0.5 text-[10px] font-medium text-red-600">
                    Red flagged
                    </span>
                @endif
                </h2>

                {{-- the toggle --}}
                <livewire:boards.red-flag
                    :boardId="$currentBoard->id"
                    :initial="$currentBoard->red_flagged"
                    :key="'flag-'.$currentBoard->id"
                />
            </div>
            @endif

            <div>
                <div wire:click="$set('showCreateBoardModal', true)" class="relative group p-2 hover:bg-green-100 active:bg-green-200 text-green-900 rounded-lg cursor-pointer">
                    <x-icons.square-plus-filled size="30" />
                    <div class="absolute hidden group-hover:block bottom-[110%] -translate-x-1/2 left-1/2 bg-green-100 rounded-md px-2 font-bold text-green-900 whitespace-nowrap">New Project</div>
                </div>
            </div>
            @endif
            {{-- <div>
                @if ($client->boardsMorph->last())
                <x-jet-button wire:click="$set('showProjectRenameModal', true)">Rename Project</x-jet-button>
                @endif
            </div> --}}
            {{-- <div>
                <x-jet-button wire:click="$emit('configureDefaultTasks')" class="">Configure Default Tasks</x-jet-button>
            </div> --}}

            <x-jet-dropdown align="right">
                <x-slot name="trigger">
                    <div class="cursor-pointer hover:bg-gray-200 active:bg-gray-300 p-1 rounded-lg">
                        <x-icons.vertical-dots />
                    </div>
                </x-slot>

                <x-slot name="content">
                    @if(Auth::user()->hasPermissionTo('view all projects') || Auth::id() == $client->manager || Auth::id() == $client->analyst)
                    <div wire:click="toggleShowArchived" class="flex items-center gap-1 p-2 hover:bg-gray-100 cursor-pointer">
                        <x-icons.archive size="18" />
                        <div>@unless ($showArchived) Archived @else All projects @endunless</div>
                    </div>
                    @endif
                    @if ($client->boardsMorph->last() && !$showArchived)
                    <div wire:click="$set('showProjectRenameModal', true)" class="flex items-center gap-1 p-2 hover:bg-gray-100 cursor-pointer">
                        <x-icons.pencil size="18" />
                        <div>Rename project</div>
                    </div>
                    @endif
                    <div wire:click="settingsRedirect" class="flex items-center gap-1 p-2 hover:bg-gray-100 cursor-pointer">
                        <x-icons.settings-gear size="18" />
                        <div>Settings</div>
                    </div>
                </x-slot>
            </x-jet-dropdown>
        </div>
    </div>

    @if (!$client->boardsMorph->last() && !$showArchived)
        <div class="w-full py-20 flex flex-col justify-center items-center gap-2 text-lg text-gray-400">
            <div>There are currently no projects for this client</div>
            <div>Click the 'New Project' button above to create one</div>
        </div>
    @endif

    {{-- Team --}}
    @isset($activeBoard->name)
        @unless($showArchived)
        <div class="grid grid-cols-3 gap-4 pb-4" wire:key="team">
            {{-- Consultant --}}
            <div
                wire:loading.class="opacity-50"
                wire:target="setTeamMember('consultant')"
                class="bg-white rounded-lg px-4 py-2 border-l-4 border-violet-500 flex flex-row justify-between items-center transition-opacity"
                >
                <div class="flex flex-row items-center space-x-2 w-full">
                    @if($changeConsultant)
                    <div class="flex flex-row items-center space-x-2 w-full" wire:key="change-consultant-block">
                        <div class="flex flex-col grow">
                            <div class="text-gray-400">Consultant</div>
                            <x-select2-multiple
                                wire:model.defer="activeBoard.consultant_id"
                                wire:key="set-consultant"
                                id="consultant-select2"
                                :options="$allUsers"
                                placeholder="Select Consultant"
                            />
                        </div>
        
                        <x-buttons.flat wire:click="setTeamMember('consultant')">
                            <x-slot name="icon">
                                <x-icons.check width="16" height="16" />
                            </x-slot>
                            Set
                        </x-buttons.flat>
                    </div>
                    @else
                    <div class="flex flex-row items-center justify-between w-full" wire:key="consultant-block">
                        <div class="flex flex-row space-x-2 items-center">
                            <div class="mr-1 shadow-md border-2 border-white w-10 h-10 bg-violet-200 text-base p-2 rounded-full flex items-center justify-center">
                                <span class="font-bold">{{ isset($activeBoard->consultant->name) ? $this->generateInitials($activeBoard->consultant->name) : '' }}</span>
                            </div>
                            <div class="flex flex-col">
                                <div class="text-gray-400">Consultant</div>
                                <div class="text-lg font-bold">{{  isset($activeBoard->consultant->name) ? $activeBoard->consultant->name : ''  }}</div>
                            </div>
                        </div>

                        <x-buttons.flat wire:click="$set('changeConsultant', 'true')">
                            <x-slot name="icon">
                                <x-icons.pencil width="16" height="16" />
                            </x-slot>
                            Change
                        </x-buttons.flat>
                    </div>
                    @endif
                </div>
            </div>
            {{-- End Consultant --}}

            {{-- Analyst --}}
            <div
                wire:loading.class="opacity-50"
                wire:target="setTeamMember('analyst')" 
                class="bg-white rounded-lg px-4 py-2 border-l-4 border-purple-500 flex flex-row justify-between items-center transition-opacity"
                >
                <div class="flex flex-row items-center space-x-2 w-full">
                    @if($changeAnalyst)
                    <div class="flex flex-row items-center space-x-2 w-full" wire:key="change-analyst-block">
                        <div class="flex flex-col grow">
                            <div class="text-gray-400">Analyst</div>
                            <x-select2-multiple
                                wire:model.defer="activeBoard.analyst_id"
                                wire:key="set-analyst"
                                id="analyst-select2"
                                :options="$allUsers"
                                placeholder="Select Analyst"
                            />
                        </div>
        
                        <x-buttons.flat wire:click="setTeamMember('analyst')">
                            <x-slot name="icon">
                                <x-icons.check width="16" height="16" />
                            </x-slot>
                            Set
                        </x-buttons.flat>
                    </div>
                    @else
                    <div class="flex flex-row items-center justify-between w-full" wire:key="analyst-block">
                        <div class="flex flex-row space-x-2 items-center">
                            <div class="mr-1 shadow-md border-2 border-white w-10 h-10 bg-purple-200 text-base p-2 rounded-full flex items-center justify-center">
                                <span class="font-bold">{{ isset($activeBoard->analyst->name) ? $this->generateInitials($activeBoard->analyst->name) : '' }}</span>
                            </div>
                            <div class="flex flex-col">
                                <div class="text-gray-400">Analyst</div>
                                <div class="text-lg font-bold">{{ isset($activeBoard->analyst->name) ? $activeBoard->analyst->name : '' }}</div>
                            </div>
                        </div>

                        <x-buttons.flat wire:click="$set('changeAnalyst', 'true')">
                            <x-slot name="icon">
                                <x-icons.pencil width="16" height="16" />
                            </x-slot>
                            Change
                        </x-buttons.flat>
                    </div>
                    @endif
                </div>
            </div>
            {{-- End Analyst --}}

            {{-- Jnr Analyst --}}
            <div
                wire:loading.class="opacity-50"
                wire:target="setTeamMember('jnrAnalyst')" 
                class="bg-white rounded-lg px-4 py-2 border-l-4 border-pink-500 flex flex-row justify-between items-center transition-opacity"
                >
                <div class="flex flex-row items-center space-x-2 w-full">
                    @if($changeJnrAnalyst)
                    <div class="flex flex-row items-center space-x-2 w-full" wire:key="change-jnrAnalyst-block">
                        <div class="flex flex-col grow">
                            <div class="text-gray-400">Jnr. Analyst</div>
                            <x-select2-multiple
                                wire:model.defer="activeBoard.jnrAnalyst_id"
                                wire:key="set-jnrAnalyst"
                                id="jnrAnalyst-select2"
                                :options="$allUsers"
                                placeholder="Select Jnr. Analyst"
                            />
                        </div>
        
                        <x-buttons.flat wire:click="setTeamMember('jnrAnalyst')">
                            <x-slot name="icon">
                                <x-icons.check width="16" height="16" />
                            </x-slot>
                            Set
                        </x-buttons.flat>
                    </div>
                    @else
                    <div class="flex flex-row items-center justify-between w-full" wire:key="jnrAnalyst-block">
                        <div class="flex flex-row space-x-2 items-center">
                            <div class="mr-1 shadow-md border-2 border-white w-10 h-10 bg-pink-200 text-base p-2 rounded-full flex items-center justify-center">
                                <span class="font-bold">{{ isset($activeBoard->jnrAnalyst->name) ? $this->generateInitials($activeBoard->jnrAnalyst->name) : '' }}</span>
                            </div>
                            <div class="flex flex-col">
                                <div class="text-gray-400">Jnr. Analyst</div>
                                <div class="text-lg font-bold">{{ isset($activeBoard->jnrAnalyst->name) ? $activeBoard->jnrAnalyst->name : '' }}</div>
                            </div>
                        </div>

                        <x-buttons.flat wire:click="$set('changeJnrAnalyst', 'true')">
                            <x-slot name="icon">
                                <x-icons.pencil width="16" height="16" />
                            </x-slot>
                            Change
                        </x-buttons.flat>
                    </div>
                    @endif
                </div>
            </div>
            {{-- End Jnr Analyst --}}
        </div>
        @endunless
    @endif
    {{-- End team --}}

    {{-- @if(isset($activeBoard->id)) --}}
        @if (isset($activeBoard->id) && !$showArchived && !$showKanban)
        <div class="grid grid-cols-[1fr_3fr_1fr] gap-4">
            {{-- Left Panel --}}
            <div class="w-full h-100 bg-white p-4 rounded-md transition-opacity @if($editItem) opacity-50 @endif">
                {{-- New and Filter buttons --}}
                @can('create tasks')
                <div class="font-bold text-lg mb-4 px-4 flex flex-row items-center justify-between">
                    <div>Tasks</div>
                    <div class="flex flex-row space-x-1">
                        <div class="relative">
                            <button 
                                @if(!$editItem) wire:click="newTask" @endif
                                class="
                                @if(!$editItem) cursor-pointer border-gray-300 active:bg-gray-200 @endif
                                cursor-default border p-1 rounded-md"
                                >
                                <x-icons.plus />
                            </button>
                        </div>
                    </div>
                </div>
                @endcan
                {{-- End new and filter buttons --}}

                {{-- Tasklist Alpine --}}
                <div class="bg-white max-w-xl mx-auto rounded-lg">
                    <ul class="shadow-box space-y-2">
                        @foreach($this->phases as $outer => $phase)
                            <li class="relative" x-data="{ selected:{{ isset($activeItem->phase) ? $activeItem->phase->id : 'null' }} }">
                                <button
                                    class="w-full px-6 py-3 text-left bg-gray-100 rounded-lg"
                                    @click="selected !== {{ $phase->id }} ? selected = {{ $phase->id }} : selected = null"
                                    >
                                    <div class="flex items-center justify-between">
                                        <span>
                                            {{ $phase->name }}
                                        </span>
                                        <div class="text-gray-500">
                                            <div x-show="selected !== {{ $phase->id }}">
                                                <x-icons.chevron-down />
                                            </div>

                                            <div x-show="selected === {{ $phase->id }}">
                                                <x-icons.chevron-up />
                                            </div>
                                        </div>
                                    </div>
                                </button>

                                <div class="relative overflow-hidden transition-all max-h-0 duration-500"
                                    x-ref="container{{ $phase->id }}"
                                    x-bind:style="selected == {{ $phase->id }} ? 'max-height: ' + $refs.container{{ $phase->id }}.scrollHeight + 'px' : ''"
                                    >
                                    <div class="pt-2 space-y-1" wire:sortable="updateTaskOrder" >
                                        @forelse($phase->items->sortBy('id')->sortBy('position') as $inner => $item)
                                            <div 
                                                wire:sortable.item="{{ $item->id }}"
                                                wire:key="item-{{ $item->id }}"
                                                class=" 
                                                    text-gray-600 rounded-md grid grid-cols-7 px-4 py-2 items-center space-x-2 mx-2 
                                                    @if(isset($activeItem->name) && $activeItem->name == $item->name) bg-blue-600 text-white hover:bg-blue-600 @endif 
                                                    @if(!$editItem) hover:bg-gray-200 cursor-pointer active:bg-gray-300 @endif" 
                                                wire:key="itemName-{{ $inner }}"
                                                @if(!$editItem) wire:click="setActiveItem('{{ $item->id }}')" @endif
                                                >
                                                <div 
                                                    wire:click="setCompleted({{ $item->id }})"
                                                    style="width: 20px; height: 20px"
                                                    class="
                                                    flex justify-center items-center rounded-full border border-gray-300 transition-colors
                                                    @if($item->status_id == 1) bg-green-600 
                                                    @elseif($item->status_id == 2) bg-white
                                                    @elseif($item->status_id == 3) bg-gray-600
                                                    @elseif($item->status_id == 4) bg-red-600
                                                    @endif"
                                                    >
                                                    @if($item->status_id == 3)
                                                        <span class="text-white -translate-x-px">
                                                            <x-icons.check width="16" height="16" />
                                                        </span>
                                                    @else
                                                        <div></div>
                                                    @endif
                                                </div>
                                                <div class="break-all col-span-5 @if($item->status_id == 3) line-through @endif">
                                                    {{ $item->name }}
                                                </div>
                                                <div wire:sortable.handle class="col-span-1 text-gray-400 cursor-grab">
                                                    <x-icons.move width="20" height="20" />
                                                </div>
                                            </div>
                                        @empty
                                            <div class="text-gray-400 text-center">
                                                <div>There are no tasks in this category.</div>
                                                <div>Click the plus button above to create one.</div>
                                            </div>
                                        @endforelse
                                    </div>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
                {{-- End Tasklist Alpine --}}
            </div>
            {{-- End left panel --}}

            {{-- Subtasks and files --}}
            <div
                wire:loading.class="opacity-50"
                wire:target="setActiveItem"
                class="rounded-md transition-opacity"
                >
                @if(!isset($activeItem->name))
                <div class="bg-white h-full p-4 space-y-4 flex items-center justify-center rounded-md">
                    <div class="text-xl text-gray-600">No task selected</div>
                </div>
                @else
                <div class="flex gap-4">
                    <div
                        class="h-full w-full p-4 space-y-6 bg-white rounded-md"
                        >
                        <div class="grid grid-cols-2">
                            {{-- Back button --}}
                            <div>
                                @if($activeItem->parent_id != null && !$editItem)
                                    <button 
                                        wire:click="setActiveItem({{ $activeItem->parent_id }})"
                                        class="border border-gray-300 p-2 rounded-md active:bg-gray-300"
                                    >
                                        <div class="flex flex-row space-x-1 items-center">
                                            <x-icons.left-arrow />
                                            <span class="font-bold">Back</span>
                                        </div>
                                    </button>
                                @endif
                            </div>
                            {{-- End back button --}}

                            {{-- Tabs --}}
                            <div class="flex w-full justify-center mb-4" style="transform: translateX(-50%);">
                                <x-tabs.tab-layout>
                                    @foreach ($tabs as $tab)
                                        <x-tabs.tab 
                                            click="changeTab('{{ $tab }}')"
                                            :current="$currentTab === $tab ? true : false"
                                            >
                                            @if ($activeItem->parent_id != null && $tab == 'subtasks')
                                                <span>Comments</span>
                                            @else
                                                {{ ucfirst($tab) }}
                                            @endif
                                        </x-tabs.tab>
                                    @endforeach
                                </x-tabs.tab-layout>
                            </div>
                            {{-- End tabs --}}
                            <div>
                                {{-- <x-button id="expand-button">Expand</x-button> --}}
                            </div>
                        </div>

                        @if ($currentTab == 'subtasks')
                            <div wire:key="subtask_and_comments" class="space-y-4">
                                {{-- Consultations --}}
                                <div wire:key="consultations-{{ $activeItem->id }}">
                                    <div class="flex flex-row items-center justify-between">
                                        <div class="text-base font-bold">Consultations</div>
                                        <button 
                                            wire:click="newConsultation"
                                            class="border border-gray-300 p-2 rounded-md active:bg-gray-300 disabled:text-gray-400 disabled:active:bg-white disabled:border-gray-200"
                                            >
                                            <div class="flex flex-row space-x-1 items-center">
                                            
                                                <div class='flex flex-row items-center'>
                                                    <x-icons.plus />
                                                    <span class="font-bold">New</span>
                                                </div>
                                            </div>
                                        </button>
                                    </div>

                                    <livewire:consultations.components.create-consultation-modal 
                                        :clientId="$this->client->id" 
                                        :entity="$this->activeItem" 
                                    />

                                    @if(count($activeItem->consultable) > 0)
                                        <div 
                                            style="box-shadow: 0px 0px 0px 1px var(--color-gray-200);"
                                            class="w-full overflow-x-auto relative sm:rounded-lg shadow-xl mt-2">
                                            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400 border-collapse rounded-lg">
                                                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                                    <tr>
                                                        <th scope="col" class="py-3 px-6">
                                                            Name
                                                        </th>
                                                        <th scope="col" class="py-3 px-6">
                                                            Start Time
                                                        </th>
                                                        <th scope="col" class="py-3 px-6">
                                                            End Time
                                                        </th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($activeItem->consultable as $consult)
                                                    <tr class="bg-white border-b dark:bg-gray-900 dark:border-gray-700">
                                                        <td scope="row" class="py-4 px-6 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                                            <a
                                                                href="../consultations/{{ $consult->id }}"
                                                                class="text-blue-600 hover:underline cursor-pointer"
                                                                >
                                                                {{ $consult->name }}
                                                            </a>
                                                        </td> 
                                                        <td class="py-4 px-6">
                                                            {{ date('d/m/Y H:i', strtotime($consult->starttime)) }}
                                                        </td>
                                                        <td class="py-4 px-6">
                                                            {{ date('d/m/Y H:i', strtotime($consult->endtime)) }}
                                                        </td>
                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    @else
                                        <div class="flex flex-col flex-wrap items-center justify-center text-gray-600 space-y-2">
                                            <div>There are no consultations for this task yet.</div>
                                            <div class="flex flex-row items-center ">
                                                <div>Click the</div> 
                                                <div class="flex flex-row border border-gray-300 p-2 rounded-md mx-2">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-plus" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                        <line x1="12" y1="5" x2="12" y2="19"></line>
                                                        <line x1="5" y1="12" x2="19" y2="12"></line>
                                                    </svg>
                                                    <span>New</span>
                                                </div> 
                                                <div>button above to add some</div>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                                {{-- End consultations --}}
                                
                                {{-- Subtasks --}}
                                @if(!$editItem && $activeItem->parent_id == null)
                                <div wire:key="subtasks-{{ $activeItem->id }}">
                                    <div class="flex flex-row items-center justify-between">
                                        <div class="text-base font-bold">Subtasks</div>
                                        <button 
                                            wire:click="newSubtask"
                                            class="border border-gray-300 p-2 rounded-md active:bg-gray-300 disabled:text-gray-400 disabled:active:bg-white disabled:border-gray-200"
                                            {{-- x-on:click="newSubtask = !newSubtask" --}}
                                            >
                                            <div class="flex flex-row space-x-1 items-center">
                                                <div class="flex flex-row items-center">
                                                    <x-icons.plus />
                                                    <span class="font-bold">New</span>
                                                </div>
                                            </div>
                                        </button>
                                    </div>

                                    @if(count($activeItem->subTasks) > 0)
                                    <div 
                                        style="box-shadow: 0px 0px 0px 1px var(--color-gray-200);"
                                        class="w-full overflow-x-auto relative sm:rounded-lg shadow-xl mt-2">
                                        <table class="table w-full text-sm text-left text-gray-500 dark:text-gray-400 border-collapse rounded-lg">
                                            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                                <tr>
                                                    <th scope="col" style="max-width: 10%;" class="py-3 px-6">
                                                    </th>
                                                    <th scope="col" style="max-width: 40%;" class="py-3 px-6">
                                                        Task Name
                                                    </th>
                                                    <th scope="col" style="max-width: 25%;" class="py-3 px-6">
                                                        Due Date
                                                    </th>
                                                    <th scope="col" style="max-width: 25%;" class="py-3 px-6">
                                                        Assigned To
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($activeItem->subTasks as $item)
                                                <tr class="bg-white border-b dark:bg-gray-900 dark:border-gray-700">
                                                    <td class="py-4 px-6">
                                                        <div 
                                                            wire:click="setCompleted({{ $item->id }})"
                                                            style="width: 20px; height: 20px"
                                                            class="
                                                            flex justify-center items-center rounded-full border border-gray-300  transition-colors cursor-pointer
                                                            @if($item->status_id == 1) bg-green-600 
                                                            @elseif($item->status_id == 2) bg-white
                                                            @elseif($item->status_id == 3) bg-gray-600
                                                            @endif"
                                                            >
                                                            @if($item->status_id == 3)
                                                                <span class="text-white -translate-x-px">
                                                                    <x-icons.check width="16" height="16" />
                                                                </span>
                                                            @else
                                                                <div></div>
                                                            @endif
                                                        </div>
                                                    </td>
                                                    <td scope="row" class="py-4 px-6  font-medium text-gray-900 dark:text-white">
                                                        <div
                                                            class="text-blue-600 hover:underline cursor-pointer break-words
                                                            @if($item->status_id == 3) line-through @endif" 
                                                            wire:click="setActiveItem({{ $item->id }})"
                                                            >
                                                            {{ $item->name }}
                                                        </div>
                                                    </td> 
                                                    <td class="py-4 px-6">
                                                        {{ Carbon\Carbon::parse($activeItem->deadline)->format('d M y') }}
                                                    </td>
                                                    <td class="py-4 px-6">
                                                        <x-initials :userNames="$item->assignedUsers->pluck('name')->toArray()" max="3" />
                                                    </td>
                                                </tr>
                                                @endforeach
                                                {{-- <tr x-show="newSubtask">
                                                    <td></td>
                                                    <td class="py-2 px-2">
                                                        <x-jet-input type="text" />
                                                    </td>
                                                    <td class="py-2 px-2">
                                                        <x-input.flatpickr id="flatpickr-subtask-deadline" wire:model.defer="" />
                                                    </td>
                                                    <td class="py-2 px-2">
                                                        <div style="width: 200px;">
                                                            <x-select2-multiple wire:model.defer="" wire:key="set-assigned-to-subtask" id="subtask-assigned-to-select2" multiple>
                                                                <option value="">Select User</option>
                                                                @foreach(App\Models\User::all() as $user)
                                                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                                                                @endforeach
                                                            </x-select2-multiple>
                                                        </div>
                                                    </td>
                                                </tr> --}}
                                            </tbody>
                                        </table>
                                    </div>
                                    @else
                                    <div class="flex flex-col flex-wrap items-center justify-center text-gray-600 space-y-2">
                                        <div>There are no subtasks for this task yet.</div>
                                        <div class="flex flex-row items-center ">
                                            <div>Click the</div> 
                                            <div class="flex flex-row border border-gray-300 p-2 rounded-md mx-2">
                                                <x-icons.plus />
                                                <span>New</span>
                                            </div> 
                                            <div>button above to add some</div>
                                        </div>
                                    </div>
                                    @endif
                                </div>
                                @endif
                                {{-- End subtasks --}}
                            
                                {{-- Comments --}}
                                <livewire:global-components.comment-section 
                                    key="project-item-comments-{{ $activeItem->id }}"  
                                    :activityEntity="$client"
                                    :activityData="$this->commentActivityData"
                                    :entity="$activeItem" 
                                    :location="'Clients / ' . $client->name . ' / ' . $activeBoard->name"
                                />
                                {{-- End comments --}}
                            </div>
                        @endif

                        @if($currentTab == 'files')
                            {{-- Task Files --}}
                            @if(!$editItem)
                            <div wire:key="task-files">
                                <div class="mb-5">
                                    <div class="text-base font-bold flex flex-row justify-between items-center mb-2">
                                        <div>Files</div>
                                        <div>
                                            {{-- Email selected files  --}}
                                            <button 
                                                @if(count($selectedFiles) == 0) disabled @endif
                                                class="border border-gray-300 p-2 rounded-md active:bg-gray-300 disabled:text-gray-400 disabled:active:bg-white disabled:border-gray-200"
                                                wire:click="emailFiles"
                                                >
                                                <div class="flex flex-row space-x-1 items-center">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-mail" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                        <rect x="3" y="5" width="18" height="14" rx="2"></rect>
                                                        <polyline points="3 7 12 13 21 7"></polyline>
                                                    </svg>
                                                    <span class="font-bold">
                                                        Email Selected Files
                                                    </span>
                                                </div>
                                            </button>
                                            {{-- End email selected files --}}

                                            {{-- Email all files button --}}
                                            <button 
                                                class="border border-gray-300 p-2 rounded-md active:bg-gray-300" 
                                                wire:click="emailAllFiles"
                                                >
                                                <div class="flex flex-row space-x-1 items-center">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-mail" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                        <rect x="3" y="5" width="18" height="14" rx="2"></rect>
                                                        <polyline points="3 7 12 13 21 7"></polyline>
                                                    </svg>
                                                    <span class="font-bold">Email All Files</span>
                                                </div>
                                            </button>
                                            {{-- End email all files button --}}

                                            @can('create tasks')
                                            <button 
                                                x-on:click="show = !show"
                                                class="border border-gray-300 p-2 rounded-md active:bg-gray-300"
                                                >
                                                <div class="flex flex-row space-x-1 items-center">
                                                    <span 
                                                        x-html="
                                                            show ? 
                                                            '<div class=\'flex flex-row items-center\'><svg xmlns=\'http://www.w3.org/2000/svg\' class=\'icon icon-tabler icon-tabler-x\' width=\'24\' height=\'24\' viewBox=\'0 0 24 24\' stroke-width=\'2\' stroke=\'currentColor\' fill=\'none\' stroke-linecap=\'round\' stroke-linejoin=\'round\'><path stroke=\'none\' d=\'M0 0h24v24H0z\' fill=\'none\'></path><line x1=\'18\' y1=\'6\' x2=\'6\' y2=\'18\'></line><line x1=\'6\' y1=\'6\' x2=\'18\' y2=\'18\'></line></svg><span>Close</span></div>' : 
                                                            '<div class=\'flex flex-row items-center\'><svg xmlns=\'http://www.w3.org/2000/svg\' class=\'icon icon-tabler icon-tabler-plus\' width=\'24\' height=\'24\' viewBox=\'0 0 24 24\' stroke-width=\'2\' stroke=\'currentColor\' fill=\'none\' stroke-linecap=\'round\' stroke-linejoin=\'round\'><path stroke=\'none\' d=\'M0 0h24v24H0z\' fill=\'none\'></path><line x1=\'12\' y1=\'5\' x2=\'12\' y2=\'19\'></line><line x1=\'5\' y1=\'12\' x2=\'19\' y2=\'12\'></line></svg><span>New</span></div>'
                                                            "
                                                            class="font-bold"
                                                        >
                                                    </span>
                                                </div>
                                            </button>
                                            @endcan
                                        </div>
                                    </div>

                                    <div x-show="show" class="flex flex-col w-full justify-center"
                                        x-transition:enter="ease-out duration-300"
                                        x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0"
                                        x-transition:enter-end="opacity-100 translate-y-0"
                                        x-transition:leave="ease-in duration-200"
                                        x-transition:leave-start="opacity-100 translate-y-0"
                                        x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0"
                                        >
                                        <x-input.filepond key="taskFiles" wire:model="taskFiles" multiple />
                                        <div class="flex flex-row justify-center">
                                            {{-- <x-jet-button wire:click="uploadTaskFiles" disabled="@if(!$enableUpload) true @endif" >Upload files</x-jet-button> --}}
                                            <button
                                                wire:click="uploadTaskFiles"
                                                class="inline-flex items-center space-x-1 px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring focus:ring-gray-300 disabled:opacity-25 transition"
                                                @if(!$enableUpload)
                                                disabled
                                                @endif
                                                >
                                                <x-icons.file-upload />
                                                <span>Upload</span>
                                            </button>
                                        </div>
                                    </div>
                                </div>

                                {{-- Task files table --}}
                                @if(count($activeItem->files) > 0)
                                <div 
                                    style="box-shadow: 0px 0px 0px 1px var(--color-gray-200);"
                                    class="overflow-x-auto relative sm:rounded-lg shadow-xl">
                                    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400 border-collapse rounded-lg">
                                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                            <tr>
                                                <th scope="col" class="py-3 px-6">
                                                    <x-jet-checkbox wire:model="selectAll" />
                                                </th>
                                                <th scope="col" class="py-3 px-6">
                                                    File name
                                                </th>
                                                <th scope="col" class="py-3 px-6">
                                                    Type
                                                </th>
                                                <th scope="col" class="py-3 px-6">
                                                    Size(KB)
                                                </th>
                                                <th scope="col" class="py-3 px-6">
                                                    Status
                                                </th>
                                                <th scope="col" class="py-3 px-6">
                                                    Action
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($activeItem->files as $index => $file)
                                            <tr class="bg-white border-b dark:bg-gray-900 dark:border-gray-700">
                                                <td class="py-4 px-6">
                                                    <x-jet-checkbox wire:model="selectedFiles" value="{{ $file->id }}" />
                                                </td>
                                                <th scope="row" class="py-4 px-6 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                                    <span class="text-blue-600 hover:underline cursor-pointer" wire:click="$emit('openFileDetails', '{{ $file->id }}')">{{ $file->file_name }}</span>
                                                </th> 
                                                <td class="py-4 px-6">
                                                    {{ $file->type }}
                                                </td>
                                                <td class="py-4 px-6">
                                                    {{ $file->file_size }}
                                                </td>
                                                <td class="py-4 px-6">
                                                    {{ $file->status}}
                                                </td>
                                                <td class="py-4 px-6">
                                                    <a wire:click="selectAndDownload({{ $file->id }})" class="cursor-pointer font-medium text-blue-600 dark:text-blue-500 hover:underline">Download</a>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                @else
                                <div class="flex flex-col flex-wrap items-center justify-center text-gray-600 space-y-2">
                                    <div>There are no files for this task yet.</div>
                                    <div class="flex flex-row items-center ">
                                        <div>Click the</div> 
                                        <div class="flex flex-row border border-gray-300 p-2 rounded-md mx-2">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-plus" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                <line x1="12" y1="5" x2="12" y2="19"></line>
                                                <line x1="5" y1="12" x2="19" y2="12"></line>
                                            </svg>
                                            <span>New</span>
                                        </div> 
                                        <div>button above to upload some</div>
                                    </div>
                                </div>
                                @endif
                                {{-- End task files table --}}
                            </div>
                            @endif
                            {{-- End task files --}}
                        @endif
                    </div>
                </div>
                @endif
            </div>
            {{-- End subtasks and files --}}

            {{-- Task details --}}
            <div 
                class="w-full bg-white rounded-lg p-4 task-details-section" 
                wire:loading.class="opacity-50"
                wire:target="setActiveItem"
                >
                @if(!isset($activeItem->name))
                <div class="bg-white h-full p-4 space-y-4 flex items-center justify-center rounded-md">
                    <div class="text-xl text-gray-600">No task selected</div>
                </div>
                @else
                <div wire:key="task-details" class="space-y-2">
                    {{-- Item details buttons --}}
                    <div class="flex flex-row justify-between items-center">
                        <div>
                            <div class="flex flex-row justify-start gap-4">
                                <div class="flex flex-col justify-start items-start gap-2">
                                    <div class="font-bold text-xl">{{ $activeItem->name }}</div>
                                    <div class="flex gap-1 flex-wrap">
                                        <div 
                                            class="
                                            px-3 py-1 rounded-2xl font-bold
                                            @if($activeItem->status_id == 1) bg-green-100 text-green-900
                                            @elseif($activeItem->status_id == 2) bg-gray-100 text-gray-900
                                            @elseif($activeItem->status_id == 3) bg-blue-100 text-blue-900
                                            @endif"
                                            >
                                            {{ isset($activeItem->getStatus) ? ucfirst($activeItem->getStatus->name) : '' }}
                                        </div>
                                        <div>
                                            @if($activeItem->overdue === 1)
                                                <div class="px-3 py-1 rounded-2xl font-bold bg-red-100 text-red-900">
                                                    Overdue
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>                                        
                            </div>

                            {{-- Right side buttons --}}
                            <div class="flex gap-1 mt-2">
                                {{-- Edit/cancel --}}
                                @can('edit tasks')
                                    <button class="border border-gray-300 p-2 rounded-md active:bg-gray-300" wire:click="toggleEditItem">
                                        @if($editItem)
                                        <div class="flex flex-row space-x-1 items-center">
                                            <x-icons.close />
                                        </div>
                                        @else
                                        <div class="flex flex-row space-x-1 items-center">
                                            <x-icons.pencil />
                                        </div>
                                        @endif
                                    </button>
                                @endcan
                                {{-- End edit/cancel --}}
                                {{-- Save --}}
                                @if($editItem)
                                    <button wire:click="saveItem" class="space-x-1 border border-gray-300 p-2 rounded-md active:bg-gray-300 flex flex-row items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-device-floppy" width="20" height="20" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                            <path d="M6 4h10l4 4v10a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2v-12a2 2 0 0 1 2 -2"></path>
                                            <circle cx="12" cy="14" r="2"></circle>
                                            <polyline points="14 4 14 8 8 8 8 4"></polyline>
                                        </svg>
                                    </button>
                                @endif
                                {{-- End save --}}
                                @if(!$editItem)
                                {{-- Email all files button --}}
                                <button 
                                    class="border border-gray-300 p-2 rounded-md active:bg-gray-300" 
                                    wire:click="emailAllFiles"
                                    >
                                    <div class="flex flex-row space-x-1 items-center">
                                        <x-icons.mail />
                                    </div>
                                </button>
                                {{-- End email all files button --}}

                                {{-- Delete button --}}
                                @can('delete tasks')
                                <button 
                                    wire:click="$set('showDeleteItemModal', true)"
                                    class="border border-gray-300 p-2 rounded-md active:bg-gray-300" 
                                    >
                                    <div class="flex flex-row space-x-1 items-center">
                                        <x-icons.bin />
                                    </div>
                                </button>
                                @endcan
                                {{-- End delete button --}}
                                @endif
                            </div>
                        </div>
                    </div>
                    {{-- End item details buttons --}}

                    <div class="space-y-4">
                        {{-- Title for editing --}}
                        <div wire:key="task-name container">
                            @if($editItem)
                                <div wire:key="task-name-label" class="text-base font-bold">Task Name</div>
                                <x-jet-input wire:key="task-name-input" id="name" type="text" wire:model.defer="activeItem.name" />
                                <x-validation-error field="activeItem.name" />
                            @endif
                        </div>
                        {{-- End title for editing --}}

                        {{-- Description --}}
                        <div class="@if($editItem) col-span-6 @else col-span-4 @endif">
                            <div class="text-base font-bold">Description</div>
                            @if($editItem)
                            <x-textarea wire:model.defer="activeItem.description" rows="5"></x-textarea>
                            @else
                            <div>{{ $activeItem->description }}</div>
                            @endif
                        </div>
                        {{-- End description --}}

                        {{-- Created by/on --}}
                        @if(!$editItem)
                        <div class="">
                            <div class="">
                                <div class="text-base font-bold">Created By</div>
                                <a href="../users/{{ $currentUser->id }}" class="text-blue-600 hover:underline">@if(isset($activeItem->user)) {{ $activeItem->user->name }} @endif</a>
                            </div>
                            <div class="">
                                <div class="text-base font-bold">Created On</div>
                                <div>{{ $activeItem->created_at }}</div>
                            </div>
                        </div>
                        @endif
                        {{-- End created by/on --}}

                        {{-- Responsible person --}}
                        {{-- <div>
                            <div class="text-base font-bold">Responsible Person</div>
                            @if($editItem)
                            <div wire:key="responsible-person_editor">
                                <x-select2-multiple id="responsible-person-edit" wire:model.defer="activeItem.responsible_person">
                                    <option value="">Please select an option</option>
                                    @foreach ($allUsers as $user)
                                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                                    @endforeach
                                </x-select2-multiple>
                            </div>
                            @else
                            <div>{{ isset($activeItem->getResponsiblePerson->name) ? $activeItem->getResponsiblePerson->name : '' }}</div>
                            @endif
                        </div> --}}
                        {{-- End responsible person --}}

                        {{-- Deadline --}}
                        <div>
                            <div class="text-base font-bold">Deadline</div>
                            @if($editItem)
                            {{-- <x-jet-input wire:model.defer="activeItem.deadline" type="date" /> --}}
                            <div wire:key="flatpickr-activeItem-deadline-key">
                                <x-input.flatpickr id="flatpickr-activeItem-deadline" wire:model.defer="activeItem.deadline" />
                            </div>
                            @else
                            <div>{{ Carbon\Carbon::parse($activeItem->deadline)->format('d M Y') }}</div>
                            @endif
                        </div>
                        {{-- End deadline --}}

                        {{-- Priority --}}
                        {{-- @if(isset($activeItem->priority_id)) --}}
                        <div>
                            <div class="text-base font-bold">Priority</div>
                            @if($editItem)
                            {{-- <x-jet-input wire:model.defer="activeItem.deadline" type="datetime-local" /> --}}
                            {{-- <x-select2 id="priority" wire:model="activeItem.priority_id" :options="$allPriorities" /> --}}
                            <div wire:key="priority_editor">
                                <x-select2-multiple id="priority_edit" wire:model="activeItem.priority_id">
                                    <option value="">Please select an option</option>
                                    @foreach ($this->allPriorities as $priority)
                                        <option value="{{ $priority->id }}">{{ $priority->name }}</option>
                                    @endforeach
                                </x-select2-multiple>
                            </div>
                            @else
                            <div>{{ isset($activeItem->priorityForeign->name) ? $activeItem->priorityForeign->name : '' }}</div>
                            @endif
                        </div>
                        {{-- @endif --}}
                        {{-- End priority --}}

                        {{-- Assigned to --}}
                        <div>
                            <div class="text-base font-bold">Assigned To</div>
                            @if(isset($activeItem->assignedUsers))
                                @if($editItem)
                                <div wire:key="assigned-to-select2">
                                    <x-select2-multiple
                                        id="assignedUserSelect"
                                        wire:model="contributers"
                                        multiple
                                        wire:key="assignedUserSelect"
                                        >
                                        @foreach ($allUsers as $user)
                                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                                        @endforeach
                                    </x-select2-multiple>
                                </div>
                                @else
                                <div>
                                    <div class="flex flex-row contributer-container">
                                        @foreach($activeItem->assignedUsers as $index => $user)
                                        <div class="avatar mr-1 shadow-md border-2 border-white w-10 h-10 bg-violet-200 text-base p-2 rounded-full flex items-center justify-center">
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
                                @if($editItem)
                                <div wire:key="tag-select">
                                    <x-select2-multiple
                                        wire:model="activeTags"
                                        multiple
                                        id="tagEditSelect2"
                                        >
                                        @foreach ($allTags as $tag)
                                            <option value="{{ $tag->id }}">{{ $tag->name }}</option>
                                        @endforeach
                                    </x-select2-multiple>
                                </div>
                                <a class="cursor-pointer hover:underline text-blue-700" wire:click="$set('showCreateTagModal', true)">Create Tag</a>
                                @else
                                <div class="space-y-2">
                                    <div class="space-x-1">
                                        @foreach($activeItem->tags as $tag)
                                        <span class="bg-{{ $tag->colour->code }}-100 font-bold text-sm text-{{ $tag->colour->code }}-900 px-4 py-1 rounded-md">
                                            {{ ucfirst($tag->name) }}
                                        </span>
                                        @endforeach
                                    </div>
                                </div>
                                @endif
                            @endif
                        </div>
                        {{-- End Tags --}}
                    </div>
                </div>
                @endif
            </div>
            {{-- End task details --}}
        </div>
        @elseif ($showArchived)
            <livewire:clients.components.archived-projects type="App\Models\Clients" :entityId="$client->id" />
        @elseif ($showKanban && isset($activeBoard->id))
            <livewire:global-components.kanban 
                :boardFilter="$activeBoardID" 
                :showTips="false" 
                :viewAllTasks="Auth::user()->hasPermissionTo('view all tasks') ? true : false" 
            />
        @endif
    {{-- @endif --}}

    {{-- MODALS --}}
        {{-- Create board modal --}}
        <x-jet-dialog-modal wire:model="showCreateBoardModal">
            <x-slot name="title">Create new project</x-slot>

            <x-slot name="content">
                <div class="space-y-4">
                    <div>
                        <x-jet-label for="board-name" value="Financial Year End" />
                        <x-input.flatpickr id="flatpickr-newBoard-name" wire:model.defer="newBoard.name" />
                        <x-validation-error field="newBoard.name" />
                    </div>

                    <div class="flex flex-row-reverse justify-end gap-1 items-center">
                        <x-jet-label for="include-defaults" value="Include default tasks" />
                        <x-jet-checkbox id="include-defaults" type="checkbox" wire:model.defer="includeDefaults" />
                    </div>
                </div>
            </x-slot>

            <x-slot name="footer">
                <div class="flex flex-row items-center">
                    <x-buttons.cancel-button wire:click="$set('showCreateBoardModal', false)">Cancel</x-buttons.cancel-button>
                    <x-jet-button wire:click="createBoard">Create</x-jet-button>
                </div>
            </x-slot>
        </x-jet-dialog-modal>

        {{-- Delete board item modal --}}
        <x-modal.confirmation wire:model="showDeleteItemModal">
            <x-slot name="title">Delete Task</x-slot>
            <x-slot name="content">Are you sure you would like to delete this task?</x-slot>
            <x-slot name="footer">
                <x-buttons.cancel-button wire:click="$set('showDeleteItemModal', false)">Cancel</x-buttons.cancel-button>
                <x-buttons.delete-button wire:click="deleteItem">Delete</x-buttons.delete-button>
            </x-slot>
        </x-modal.confirmation>

        {{-- Create board item modal --}}
        <x-jet-dialog-modal wire:model="showCreateItemModal">
            <x-slot name="title">Create New Task</x-slot>

            <x-slot name="content">
                <form class="space-y-4">
                    <div>
                        <x-jet-label for="phase" value="Phase" />
                        <x-select id="phase" wire:model.defer="newItem.phase_id" disabled="{{ $isSubtask ? 'disabled' : '' }}">
                            <option value="">Select a phase</option>
                            @foreach ($this->allPhases as $phase)
                                <option value="{{ $phase->id }}">{{ $phase->name }}</option>
                            @endforeach
                        </x-select>
                        <x-validation-error field="newItem.phase_id" />
                    </div>
                    
                    <div>
                        <x-jet-label for="name" value="Task Name" />
                        <x-jet-input type="text" id="name" wire:model.defer="newItem.name" />
                        <x-validation-error field="newItem.name" />
                    </div>

                    <div>
                        <x-jet-label for="description" value="Description" />
                        <x-textarea rows="5" id="description" wire:model.defer="newItem.description"></x-textarea>
                    </div>

                    <div>
                        <x-jet-label for="deadline" value="Due Date" />
                        {{-- <x-jet-input type="date" id="deadline" wire:model.defer="newItem.deadline" /> --}}
                        <div wire:key="flatpickr-newItem-deadline-key">
                            <x-input.flatpickr id="flatpickr-newItem-deadline" wire:model.defer="newItem.deadline" />
                        </div>
                        <x-validation-error field="newItem.deadline" />
                    </div>

                    <div>
                        <x-jet-label for="priority_new_item" value="Priority" />
                        <x-select2-multiple id="priority_new_item" wire:model="newItem.priority_id" name="priority_new_item" placeholder="Select Priority">
                                <option value="">Select priority</option>
                            @foreach ($this->allPriorities as $priority)
                                <option value="{{ $priority->id }}">{{ $priority->name }}</option>
                            @endforeach
                        </x-select2-multiple>
                        <x-validation-error field="newItem.priority_id" />
                        <a class="cursor-pointer hover:underline text-blue-700" wire:click="$set('showCreatePriorityModal', true)">Create Priority</a>
                    </div>

                    <div>
                        <x-jet-label for="tagSelect-item-creation" value="Tags" />
                        <x-select2-multiple 
                            id="tagSelect-item-creation"
                            wire:model="newItemTags"
                            multiple
                            name="tagSelect-item-creation"
                            >
                            @foreach ($allTags as $tag)
                                <option value="{{ $tag->id }}">{{ $tag->name }}</option>
                            @endforeach
                        </x-select2-multiple>
                        <a class="cursor-pointer hover:underline text-blue-700" wire:click="$set('showCreateTagModal', true)">Create Tag</a>
                    </div>

                    <div>
                        <x-jet-label for="assign-item-creation" value="Assign To" />
                        <x-select2-multiple
                            id="assign-item-creation"
                            wire:model="newItemUsers"
                            multiple
                            >
                            @foreach ($allUsers as $user)
                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                            @endforeach
                        </x-select2-multiple>
                    </div>
                </form>
            </x-slot>

            <x-slot name="footer">
                <div class="flex flex-row justify-end items-center gap-1">
                    <x-buttons.cancel-button wire:click="$set('showCreateItemModal', false)">Cancel</x-buttons.cancel-button>
                    <x-jet-button wire:click="createItem">Create</x-jet-button>
                </div>
            </x-slot>
        </x-jet-dialog-modal>

        {{-- Create tag modal --}}
        <x-jet-dialog-modal wire:model="showCreateTagModal">
            <x-slot name="title">Create Tag</x-slot>

            <x-slot name="content">
                <form class="space-y-2 pb-20">
                    <div>
                        <x-jet-label for="tag-name" value="Name" />
                        <x-jet-input type="text" wire:model.defer="newTag.name" />
                    </div>

                    <div>
                        <x-jet-label for="tag-color" value="Color" />
                        <div class="flex flex-row gap-2">
                            <div class="w-10 rounded-md bg-{{ $newTag->colour->code }}-400"></div>
                            <x-jet-dropdown align="left" width="100">
                                <x-slot name="trigger">
                                    <x-jet-button wire:click.prevent="">Change Colour</x-jet-button>
                                </x-slot>

                                <x-slot name="content">
                                    <div class="z-100 flex flex-row gap-2 p-2">
                                        @foreach ($colours as $colour)
                                            <div 
                                                wire:click="setTagColour({{ $colour->id }})"
                                                class="w-10 h-10 rounded-full bg-{{ $colour->code }}-400 cursor-pointer" 
                                                >
                                            </div>
                                        @endforeach
                                    </div>
                                </x-slot>
                            </x-jet-dropdown>
                        </div>
                    </div>
                </form>
            </x-slot>

            <x-slot name="footer">
                <div class="flex flex-row items-center justify-end">
                    <x-buttons.cancel-button wire:click="$set('showCreateTagModal', false)">Cancel</x-buttons.cancel-button>
                    <x-create-button wire:click="createTag">Create Tag</x-create-button>
                </div>
            </x-slot>
        </x-jet-dialog-modal>

        {{-- Create priority modal --}}
        <x-jet-dialog-modal wire:model="showCreatePriorityModal">
            <x-slot name="title">Create Priority</x-slot>

            <x-slot name="content">
                <form class="space-y-2 pb-20">
                    <div>
                        <x-jet-label for="priority-name" value="Priority Name" />
                        <x-jet-input type="text" wire:model.defer="newPriority.name" />
                    </div>
                </form>
            </x-slot>

            <x-slot name="footer">
                <div class="flex flex-row items-center justify-end">
                    <x-buttons.cancel-button wire:click="$set('showCreatePriorityModal', false)">Cancel</x-buttons.cancel-button>
                    <x-create-button wire:click="createPriority">Create Priority</x-create-button>
                </div>
            </x-slot>
        </x-jet-dialog-modal>

        {{-- Rename Project --}}
        <x-jet-dialog-modal wire:model="showProjectRenameModal">
            <x-slot name="title">Rename Project</x-slot>
            <x-slot name="content">
                <div>
                    <x-jet-label for="project-name" value="Financial Year End" />
                    <x-input.flatpickr id="flatpickr-activeBoard-name" wire:model.defer="activeBoard.name" />
                </div>
            </x-slot>
            <x-slot name="footer">
                <div class="flex justify-end items-center gap-1">
                    <x-buttons.cancel-button x-on:click="show = false;">Cancel</x-buttons.cancel-button>
                    <x-jet-button wire:click="updateBoard">Save</x-jet-button>
                </div>
            </x-slot>
        </x-jet-dialog-modal>

        <x-jet-dialog-modal wire:model="showUnarchiveModal">
            <x-slot name="title">
                <div class="flex justify-between items-center">
                    <div>Restore or Delete</div>
                    <div x-on:click="show = false" class="cursor-pointer">
                        <x-icons.close />
                    </div>
                </div>
            </x-slot>
            <x-slot name="content">
                <div>
                    Would you like to <span class="font-bold">restore</span> or 
                    <span class="font-bold">permanently delete</span> 
                    this record
                </div>

                <div class="text-sm text-red-500 mt-4">
                    Warning: Permanently deleting this project will remove all tasks, subtasks and files assosicated with it. 
                    This action is irreversible
                </div>
            </x-slot>
            <x-slot name="footer">
                <div class="flex gap-1 items-center justify-end">
                    <x-button wire:click="restore">Restore</x-button>
                    <x-button wire:click="permanentlyDelete" class="bg-red-500">Delete</x-button>
                </div>
            </x-slot>
        </x-jet-dialog-modal>

        {{-- Task details --}}
        {{-- <livewire:global-components.task-details-modal :task="$activeItem" /> --}}
    {{-- END MODALS --}}

    <div class="hidden">
        <div class="bg-pink-400"></div>
        <div class="bg-pink-600"></div>
        <div class="bg-pink-500"></div>
        <div class="bg-pink-100"></div>
        <div class="bg-pink-900 text-pink-900"></div>
        <div class="bg-violet-400"></div>
        <div class="bg-sky-400 text-sky-900"></div>
        <div class="bg-green-400 text-green-900"></div>
        <div class="bg-sky-100"></div>
    </div>
</div>
