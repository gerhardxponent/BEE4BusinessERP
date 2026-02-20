<div>
    @if($showTips)
    <div class="mb-4 space-y-2">
        <x-tip>
            <div class="flex">
                <div>Click the</div> 
                <x-icons.filter /> 
                <div>button above to filter tasks.</div>
            </div>
        </x-tip>

        <x-tip>
            <div class="flex">
                <div>Hover on a task, and drag the</div>
                <x-icons.move /> 
                <div class="ml-1">icon to move it.</div>
            </div>
        </x-tip>
    </div>
    @endif
    
    {{-- Filters (unified) --}}
    <div x-data="{ showFilters: false }" x-init="Livewire.on('toggleFilters', () => { showFilters = !showFilters; })">
        <div x-show="showFilters" x-collapse class="rounded-md bg-white w-full max-w-4xl">
            <div class="p-4 space-y-4">
                <div class="font-bold text-lg">Filters</div>

                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <div>
                        <x-jet-label for="typeFilter" value="Type" />
                        <x-select wire:model="typeFilter" id="typeFilter">
                            <option value="">All</option>
                            @foreach ($this->types as $type)
                                <option value="{{ $type }}">{{ $type }}</option>
                            @endforeach
                        </x-select>
                    </div>

                    <div>
                        <x-jet-label for="recordFilter" value="Record" />
                        <x-select :disabled="!$typeFilter" wire:model="recordFilter" id="recordFilter">
                            <option value="">All</option>
                            @foreach ($this->records as $record)
                                <option value="{{ $record->id }}">{{ $record->name }}</option>
                            @endforeach
                        </x-select>
                    </div>

                    <div>
                        <x-jet-label for="boardFilter" value="Board" />
                        <x-select :disabled="!$typeFilter || !$recordFilter" wire:model="boardFilter" id="boardFilter">
                            <option value="">All</option>
                            @foreach ($this->boards as $board)
                                <option value="{{ $board->id }}">{{ $board->name }}</option>
                            @endforeach
                        </x-select>
                    </div>

                    <div>
                        <x-jet-label for="filterUserId" value="User" />
                        <select id="filterUserId" class="border-gray-300 rounded-md shadow-sm w-full" wire:model="filterUserId">
                            @can('view all tasks')
                                <option value="all">All users</option>
                            @endcan
                            @foreach($this->allUsers as $u)
                                <option value="{{ $u->id }}">{{ $u->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <x-jet-label for="dueStart" value="Due from" />
                        <input id="dueStart" type="date" class="border-gray-300 rounded-md shadow-sm w-full" wire:model="dueStart">
                    </div>

                    <div>
                        <x-jet-label for="dueEnd" value="Due to" />
                        <input id="dueEnd" type="date" class="border-gray-300 rounded-md shadow-sm w-full" wire:model="dueEnd">
                    </div>

                    <div class="flex items-end">
                        <button type="button" class="px-3 py-2 rounded-md border border-gray-300 hover:bg-gray-50" wire:click="$set('filterUserId', @js(auth()->user()->can('view all tasks') ? 'all' : auth()->id())); $set('dueStart', null); $set('dueEnd', null); $set('typeFilter',''); $set('recordFilter',''); $set('boardFilter','')">
                            Clear
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- End filters --}}

    <div class="w-full flex justify-end">
        <div wire:click="toggleSort" class="cursor-pointer flex bg-gray-200 hover:bg-gray-300 active:bg-gray-400 p-2 rounded text-sm text-gray-900 font-bold">
            @if ($sortByDate)
                <div class="flex justify-start items-center gap-1">
                    <x-icons.sort size="18" />
                    <div>Sort by position</div>
                </div>
            @else
                <div class="flex justify-start items-center gap-1">
                    <x-icons.sort size="18" />
                    <div>Sort by due date</div>
                </div>
            @endif
        </div>
    </div>

    <div wire:sortable="updateGroupOrder" wire:sortable-group="updateTaskOrder" class="grid grid-cols-3 gap-8 w-full kanban mt-4">
        @foreach ($statuses as $status)
            @php 
                // $currentTasks = $this->tasks->where('status_id', $status->id)->sortBy('status_position')->when($sortByDate, function ($query) {
                //     $query->sortBy('created_at');
                // });

                if ($sortByDate) 
                    $currentTasks = $this->tasks->where('status_id', $status->id)->sortBy(fn ($item) => $item->deadline ?: PHP_INT_MAX);
                else 
                    $currentTasks = $this->tasks->where('status_id', $status->id)->sortBy('status_position');
            @endphp

            <div>
                <div class="px-2 py-4 rounded-md" style="background-color: #eff0f2">
                    <div wire:key="group-{{ $status->id }}">
                        <div class="flex gap-2 items-center">
                            <div class="text-lg font-bold bg-indigo-200 text-indigo-900 w-8 h-8 flex justify-center items-center rounded-full">
                                <div>{{ count($currentTasks) }}</div>
                            </div>
                            <div class="flex justify-between items-center w-full">
                                <div class="font-bold text-lg">{{ $status->name }}</div>
                            </div>
                        </div>
                    </div>

                    <div wire:sortable-group.item-group="{{ $status->id }}" class="flex flex-col gap-2 py-4">
                        @foreach ($currentTasks as $task)
                            <div 
                                wire:key="task-{{ $task->id }}" 
                                wire:sortable-group.item="{{ $task->id }}" 
                                class="bg-white p-4 rounded-md flex justify-between items-center group"
                                x-data="{ 
                                    expanded: false, 
                                    expandText: false,
                                    {{-- summary: '{{ Str::limit($task->description, 5) }}',
                                    fullText: '{{ $task->description }}', --}}
                                }"
                                >
                                <div class="space-y-2">
                                    <div>
                                        <div class="flex gap-2 items-center text-lg font-bold">
                                            <div 
                                                class="w-5 h-5 rounded-full border border-gray-300 flex justify-center items-center cursor-pointer
                                                @if ($task->status_id == 1)     bg-green-500
                                                @elseif ($task->status_id == 2) bg-white
                                                @elseif ($task->status_id == 3) bg-gray-600
                                                @endif" 
                                                wire:click="changeStatus({{ $task->id }})"
                                                >
                                                @if($task->status_id == 3)
                                                <div class="text-white">
                                                    <x-icons.check size="16" />
                                                </div>
                                                @endif
                                            </div>
                                            <div 
                                                class="cursor-pointer hover:text-blue-600 hover:underline" 
                                                wire:click="$emit('taskClicked', '{{ $task->id }}')"
                                                >
                                                {{ $task->name }}
                                            </div>
                                        </div>
                                        <div class="text-gray-600">{{ isset($task->board->boardable) ? $task->board->boardable->name : '' }}</div>
                                    </div>

                                    <div>
                                        {{-- {{ Str::length($task->description) > 5 ? Str::limit($task->description, 5) : $task->description }} --}}
                                        {{-- @if(Str::length($task->description) > 5)
                                            {{ Str::limit($task->description, 5) }} 
                                            <div class="text-sm text-blue-500 hover:underline cursor-pointer">Read more</div>
                                        @else
                                            {{ $task->description }}
                                        @endif --}}
                                        
                                        <div>
                                            <div x-show="!expandText">
                                                {{ Str::limit($task->description, 120) }}
                                                {{-- <x-inline-edit
                                                    :original="$task->description"
                                                    originalPlaceholder="{{ Str::limit($task->description, 120) }}"
                                                    :entityId="$task->id"
                                                    field="description"
                                                    name="task-desc"
                                                    id="{{ $task->id }}-task-desc"
                                                /> --}}
                                            </div>
                                            <div x-show="expandText">
                                                {{ $task->description }}
                                            </div>
                                            @if(Str::length($task->description) > 120)
                                            <button 
                                                x-on:click="expandText = !expandText" 
                                                x-text="expandText ? 'Hide' : 'Read more'"
                                                class="text-blue-500 hover:underline text-sm"
                                                >
                                            </button>
                                            @endif
                                        </div>
                                    </div>

                                    <div>
                                        @if($task->deadline)
                                        <div class="flex gap-1 text-gray-500 text-sm items-center">
                                            <div>Due Date: </div>
                                            {{-- <div>{{ $task->deadline }}</div> --}}
                                            <x-inline-edit
                                                :original="$task->deadline"
                                                :entityId="$task->id"
                                                field="deadline"
                                                name="task-deadline"
                                                type="date"
                                                id="{{ $task->id }}-task-deadline"
                                            />
                                        </div>
                                        @endif

                                        @if($status->id == 3)
                                        <div class="flex gap-1 text-gray-500 text-sm">
                                            <div>Completed on:</div>
                                            <div>{{ $task->completed_at }}</div>
                                        </div>
                                        @endif
                                    </div>

                                    <div>
                                        <x-initials :userNames="$task->assignedUsers->pluck('name')->toArray()" />

                                        {{-- <x-inline-edit
                                            id="{{ $task->id }}-current-task"
                                            type="select2"
                                            :options="$this->AllUsers"
                                            original="Tags"
                                            :initial="$task->assignedUsers->pluck('id')->toArray()"
                                        /> --}}
                                    </div>

                                    <div class="space-y-2">
                                        <div class="flex gap-1 flex-wrap">
                                            @foreach($task->tags as $tag)
                                            <span class="bg-{{ $tag->colour->code }}-100 font-bold text-sm text-{{ $tag->colour->code }}-900 px-4 py-1 rounded-md">
                                                {{ ucfirst($tag->name) }}
                                            </span>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>

                                @if (!$sortByDate)
                                <div wire:sortable-group.handle class="text-gray-400 cursor-grab opacity-0 group-hover:opacity-100 transition-opacity">
                                    <x-icons.move />
                                </div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    {{-- <livewire:global-components.task-details-modal /> --}}
</div>
