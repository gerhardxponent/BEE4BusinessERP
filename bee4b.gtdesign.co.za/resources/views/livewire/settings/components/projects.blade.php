<div>
    <div class="flex flex-row gap-4">
        {{-- Left Panel --}}
        <div class="w-1/4 h-100 bg-white p-4 rounded-md transition-opacity @if($editItem) opacity-50 @endif">
            {{-- New button --}}
            <div class="font-bold text-lg mb-4 px-4 flex flex-row items-center justify-between">
                <div>Default Tasks</div>
                <div class="flex flex-row space-x-1">
                    <div class="relative">
                        <x-jet-dropdown>
                            <x-slot name="trigger">
                                <button 
                                    {{-- @if(!$editItem) wire:click="newTask" @endif --}}
                                    class="
                                    @if(!$editItem) cursor-pointer border-gray-300 active:bg-gray-200 @endif
                                    cursor-default border p-1 rounded-md"
                                    >
                                    <x-icons.plus />
                                </button>
                            </x-slot>
    
                            <x-slot name="content">
                                <div class="space-y-1">
                                    <div
                                        wire:click="$set('showCreateItemModal', true)"
                                        class="flex gap-1 p-2 mx-1 items-center hover:bg-gray-100 active:bg-gray-200 cursor-pointer"
                                        >
                                        <div><x-icons.plus /></div>
                                        <div>New Task</div>
                                    </div>
    
                                    <div 
                                        wire:click="$set('showCreatePhaseModal', true)"
                                        class="flex gap-1 p-2 mx-1 items-center hover:bg-gray-100 active:bg-gray-200 cursor-pointer"
                                        >
                                        <div><x-icons.folder-plus /></div>
                                        <div>New Phase</div>
                                    </div>
                                </div>
                            </x-slot>
                        </x-jet-dropdown>
                    </div>
                </div>
            </div>
            {{-- End new button --}}

            {{-- Tasklist Alpine --}}
            <div class="bg-white max-w-xl mx-auto rounded-lg">
                <ul 
                    wire:sortable-group="updateTaskOrder"
                    wire:sortable="updateGroupOrder" 
                    class="shadow-box space-y-2" 
                    >
                    @foreach($this->phases as $outer => $phase)
                        <li 
                            wire:key="group-{{ $phase->id }}" 
                            wire:sortable.item="{{ $phase->id }}" 
                            class="relative" 
                            x-data="{ selected:{{ isset($activeItem->phase) ? $activeItem->phase->id : 'null' }} }"
                            >
                            <button
                                class="w-full px-6 py-3 text-left bg-gray-100 rounded-lg"
                                @click="selected !== {{ $phase->id }} ? selected = {{ $phase->id }} : selected = null"
                                >
                                <div class="flex items-center justify-between">
                                    <span>
                                        {{ $phase->name }}
                                    </span>
                                    <div class="flex gap-4">
                                        <div wire:sortable.handle class="col-span-1 text-gray-400 cursor-grab">
                                            <x-icons.move width="20" height="20" />
                                        </div>
                                        <div class="text-gray-500">
                                            <div x-show="selected !== {{ $phase->id }}">
                                                <x-icons.chevron-down />
                                            </div>

                                            <div x-show="selected === {{ $phase->id }}">
                                                <x-icons.chevron-up />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </button>

                            <div class="relative overflow-hidden transition-all max-h-0 duration-500"
                                x-ref="container{{ $phase->id }}"
                                x-bind:style="selected == {{ $phase->id }} ? 'max-height: ' + $refs.container{{ $phase->id }}.scrollHeight + 'px' : ''"
                                >
                                <div 
                                    wire:sortable-group.item-group="{{ $phase->id }}" 
                                    class="pt-2 space-y-1" 
                                    >
                                    @forelse($phase->defaultItems->where('parent_id', null)->sortBy('position') as $inner => $item)
                                        <div 
                                            wire:sortable-group.item="{{ $item->id }}"
                                            wire:key="task-{{ $item->id }}"
                                            class=" 
                                                text-gray-600 rounded-md flex justify-between items-center px-4 py-2 space-x-2 mx-2 
                                                @if(isset($activeItem->name) && $activeItem->name == $item->name) bg-blue-600 text-white hover:bg-blue-600 @endif 
                                                @if(!$editItem) hover:bg-gray-200 cursor-pointer active:bg-gray-300 @endif" 
                                            @if(!$editItem) wire:click="setActiveItem('{{ $item->id }}')" @endif
                                            >
                                            <div class="break-all @if($item->status == 'complete') line-through @endif">
                                                {{ $item->name }}
                                            </div>
                                            <div wire:sortable-group.handle class="col-span-1 text-gray-400 cursor-grab">
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

        {{-- Board Item details --}}
        <div
            wire:loading.class="opacity-50"
            wire:target="setActiveItem"
            class="w-3/4 rounded-md transition-opacity"
            >
            @if(!isset($activeItem->name))
            <div class="bg-white h-full p-4 space-y-4 flex items-center justify-center rounded-md">
                <div class="text-xl text-gray-600">No task selected</div>
            </div>
            @else
            <div
                class="h-full p-4 space-y-6 bg-white rounded-md"
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
                                    @if ($activeItem->parent_id != null && $tab == 'subtasks and comments')
                                        <span>Comments</span>
                                    @else
                                        {{ ucfirst($tab) }}
                                    @endif
                                </x-tabs.tab>
                            @endforeach
                        </x-tabs.tab-layout>
                    </div>
                    {{-- End tabs --}}
                </div>

                @if ($currentTab == 'subtasks')
                    <div wire:key="subtask_and_comments" class="space-y-4">
                        {{-- Subtasks --}}
                        @if(!$editItem && $activeItem->parent_id == null)
                        <div wire:key="subtasks-{{ $activeItem->id }}">
                            <div class="flex flex-row items-center justify-between">
                                <div class="text-base font-bold">Subtasks</div>
                                <button 
                                    wire:click="newSubtask"
                                    class="border border-gray-300 p-2 rounded-md active:bg-gray-300 disabled:text-gray-400 disabled:active:bg-white disabled:border-gray-200"
                                    {{-- x-on:click="show_subtasks = !show_subtasks" --}}
                                    >
                                    <div class="flex flex-row space-x-1 items-center">
                                    
                                        <div class='flex flex-row items-center'>
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
                                <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400 border-collapse rounded-lg">
                                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                        <tr>
                                            <th scope="col" class="py-3 px-6">
                                                Task Name
                                            </th>
                                            <th scope="col" class="py-3 px-6">
                                                Priority
                                            </th>
                                            <th scope="col" class="py-3 px-6"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($activeItem->subTasks as $item)
                                        <tr class="bg-white border-b dark:bg-gray-900 dark:border-gray-700">
                                            <th scope="row" class="py-4 px-6 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                                <span
                                                    class="text-blue-600 hover:underline cursor-pointer
                                                    @if($item->status == 'complete') line-through @endif" 
                                                    wire:click="setActiveItem({{ $item->id }})"
                                                    >
                                                    {{ $item->name }}
                                                </span>
                                            </th> 
                                            <td class="py-4 px-6">
                                                {{ isset($item->priorityForeign->name) ?  $item->priorityForeign->name : ''}}
                                            </td>
                                            <td class="py-4 px-6">
                                                <button 
                                                    wire:click="deleteSubtask({{ $item->id }})" 
                                                    class="text-red-500 cursor-pointer hover:underline disabled:opacity-60 transition-opacity"
                                                    wire:loading.attr="disabled"
                                                    >
                                                    Delete
                                                </button>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            @else
                            <div class="flex flex-col flex-wrap items-center justify-center text-gray-600 space-y-2">
                                <div>There are no subtasks for this task yet.</div>
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
                        @endif
                        {{-- End subtasks --}}
                    </div>
                @endif

                @if($currentTab == 'details')
                    <div wire:key="task-details" class="space-y-2">
                        {{-- Item details buttons --}}
                        <div class="flex flex-row justify-between items-center">
                            <div class="flex flex-row w-full justify-between">
                                <div class="flex flex-row justify-start gap-4">
                                    <div class="flex flex-row items-center justify-start flex-wrap gap-2">
                                        <div class="font-bold text-xl">{{ $activeItem->name }}</div>
                                        <div class="flex gap-2">
                                            <div 
                                                class="
                                                px-3 py-1 rounded-2xl font-bold
                                                @if($activeItem->status == 'active') bg-green-100 text-green-900
                                                @elseif($activeItem->status == 'inactive') bg-gray-100 text-gray-900
                                                @elseif($activeItem->status == 'complete') bg-blue-100 text-blue-900
                                                @endif"
                                                >
                                                {{ ucfirst($activeItem->status) }}
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
                                <div class="flex flex-row items-center gap-1">
                                    {{-- Edit/cancel --}}
                                    @can('edit tasks')
                                        <button class="border border-gray-300 p-2 rounded-md active:bg-gray-300" wire:click="toggleEditItem">
                                            @if($editItem)
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
                                            <span class="font-bold">Save</span>
                                        </button>
                                    @endif
                                    {{-- End save --}}
                                    @if(!$editItem)
                                    {{-- Delete button --}}
                                    @can('delete tasks')
                                    <button 
                                        wire:click="$set('showDeleteItemModal', true)"
                                        class="border border-gray-300 p-2 rounded-md active:bg-gray-300" 
                                        >
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
                                    @endcan
                                    {{-- End delete button --}}
                                    @endif
                                </div>
                            </div>
                        </div>
                        {{-- End item details buttons --}}

                        {{-- Title for editing --}}
                        <div wire:key="task-name container">
                            @if($editItem)
                                <div wire:key="task-name-label" class="text-base font-bold">Task Name</div>
                                <x-jet-input wire:key="task-name-input" id="name" type="text" wire:model.defer="activeItem.name" />
                                <x-validation-error field="activeItem.name" />
                            @endif
                        </div>
                        {{-- End title for editing --}}

                        {{-- Description and created on --}}
                        <div class="grid grid-cols-6">
                            <div class="@if($editItem) col-span-6 @else col-span-4 @endif">
                                <div class="text-base font-bold">Description</div>
                                @if($editItem)
                                <x-textarea wire:model.defer="activeItem.description" rows="5"></x-textarea>
                                @else
                                <div>{{ $activeItem->description }}</div>
                                @endif
                            </div>

                            @if(!$editItem)
                            <div class="flex flex-col col-span-2 items-end space-y-2">
                                <div class="flex flex-col items-end">
                                    <div class="text-base font-bold">Created On</div>
                                    <div>{{ Carbon\Carbon::parse($activeItem->created_at)->format('d M Y, H:i') }}</div>
                                </div>
                            </div>
                            @endif
                        </div>
                        {{-- End description and created on --}}

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
                                    @foreach ($allPriorities as $priority)
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
                    </div>
                @endif
            </div>
            @endif
        </div>

    </div>
    {{-- End board item details --}}

    {{-- MODALS --}}
        {{-- Create board item modal --}}
        <x-modal.dialog wire:model="showCreateItemModal">
            <x-slot name="title">Create New Task</x-slot>

            <x-slot name="content">
                <form class="space-y-4">
                    <div>
                        <x-jet-label for="project_settings_phase" value="Phase" />
                        <div wire:key="project_settings_phase">
                            <x-select2-multiple id="project_settings_phase" name="project_settings_phase" wire:model="newItem.phase_id">
                                <option value="">Please select an option</option>
                                @foreach ($this->phases as $phase)
                                    <option value="{{ $phase->id }}">{{ $phase->name }}</option>
                                @endforeach
                            </x-select2-multiple>
                            <x-validation-error field="newItem.phase_id" />
                        </div>
                    </div>

                    <div>
                        <x-jet-label for="name" value="Name" />
                        <x-jet-input type="text" id="name" wire:model.defer="newItem.name" />
                        <x-validation-error field="newItem.name" />
                    </div>

                    <div>
                        <x-jet-label for="description" value="Description" />
                        <x-textarea rows="5" id="description" wire:model.defer="newItem.description"></x-textarea>
                    </div>

                    <div>
                        <x-jet-label for="project_settings_priority" value="Priority" />
                        <div wire:key="project_settings_priority">
                            <x-select2-multiple id="project_settings_priority" wire:model="newItem.priority_id">
                                <option value="">Please select an option</option>
                                @foreach ($allPriorities as $priority)
                                    <option value="{{ $priority->id }}">{{ $priority->name }}</option>
                                @endforeach
                            </x-select2-multiple>
                        </div>
                    </div>
                </form>
            </x-slot>

            <x-slot name="footer">
                <div class="flex flex-row justify-end items-center gap-1">
                    <x-buttons.cancel-button wire:click="cancelCreateItem">Cancel</x-buttons.cancel-button>
                    <x-jet-button wire:click="createItem">Create</x-jet-button>
                </div>
            </x-slot>
        </x-modal.dialog>
        {{-- End create board item modal --}}

        {{-- Delete board item modal --}}
        <x-modal.confirmation wire:model="showDeleteItemModal">
            <x-slot name="title">Delete Task</x-slot>
            <x-slot name="content">Are you sure you would like to delete this task?</x-slot>
            <x-slot name="footer">
                <x-buttons.cancel-button wire:click="$set('showDeleteItemModal', false)">Cancel</x-buttons.cancel-button>
                <x-buttons.delete-button wire:click="deleteItem">Delete</x-buttons.delete-button>
            </x-slot>
        </x-modal.confirmation>
        {{-- End delete board item modal --}}

        {{-- Create phase modal --}}
        <x-jet-dialog-modal wire:model="showCreatePhaseModal">
            <x-slot name="title">Create new phase</x-slot>
            <x-slot name="content">
                <div>
                    <x-jet-label for="phase-name" value="Phase name" />
                    <x-jet-input type="text" id="phase-name" wire:model.defer="newPhase.name" />
                </div>
            </x-slot>
            <x-slot name="footer">
                <div class="flex justify-end items-center gap-1">
                    <x-buttons.cancel-button x-on:click="show = false;">Cancel</x-buttons.cancel-button>
                    <x-create-button wire:click="createPhase">Create</x-create-button>
                </div>
            </x-slot>
        </x-jet-dialog-modal>
        {{-- End create phase modal --}}    
    {{-- END MODALS --}}
</div>
