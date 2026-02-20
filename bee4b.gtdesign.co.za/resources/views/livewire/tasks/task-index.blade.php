<div>

    {{-- Filters moved into Kanban’s unified panel (toggle with top filter button) --}}
    {{-- <div class="flex flex-row justify-between mb-8 mt-4">
        <div class="text-2xl">{{ $title }}</div>
        <div>
            @can('view all tasks')
            <x-jet-button wire:click="toggleViewAll">{{ $viewAll ? 'View My Tasks' : 'View All Tasks' }}</x-jet-button>
            @endcan
            @can('create tasks')
            <x-jet-button wire:click="$set('showCreateItemModal', true)">New Task</x-jet-button>
            @endcan
        </div>
    </div> --}}

    <div wire:loading.class="opacity-50 transition-opacity">
        {{-- <livewire:tasks.task-table/> --}}
    </div>

      {{-- Unified Kanban with filters (receives initial props) --}}
    <livewire:global-components.kanban
        :filterUserId="$filterUserId"
        :dueStart="$filterDueStart"
        :dueEnd="$filterDueEnd"
    />

    {{-- MODALS --}}
        {{-- Task details modal --}}
        <x-jet-dialog-modal wire:model="showTaskDetailsModal">
            <x-slot name="title">
                <div class="flex flex-row justify-between">
                    <div>{{ $currentTask->name }}</div>
                    <div class="flex items-center gap-1">
                        @if($currentTab == 'details')
                            @can('edit tasks')
                            <div>
                                @if($editing)
                                <x-jet-button wire:click="updateTask">Save</x-jet-button>
                                @endif
                                <x-jet-button wire:click="$toggle('editing')">{{ $editing ? 'Cancel' : 'Edit' }}</x-jet-button>
                            </div>
                            @endcan

                            @can('delete tasks')
                                <x-buttons.delete-button wire:click="$set('showConfirmDeleteModal', true)">Delete</x-buttons.delete-button>
                            @endcan
                        @endif
                    </div>
                </div>
            </x-slot>

            <x-slot name="content">
                <div class="flex w-full justify-center mb-4">
                    <div class="bg-gray-200 px-1.5 py-2 rounded-lg">
                        @foreach($tabs as $tab)
                        <span
                            wire:click="changeTab('{{ $tab }}')"
                            class="tab-container transition-colors text-gray-500 @if($currentTab == $tab) active-tab shadow-md @endif rounded-md px-5 py-1 font-bold cursor-pointer"
                            >
                            <a class="tab-a text-sm">{{ ucfirst($tab) }}</a>
                        </span>
                        @endforeach
                    </div>
                </div>

                @if($currentTab == 'details')
                    <div>
                        <table class="table-fixed">
                            <tr>
                                <td class="font-bold">Project</td>
                                <td>
                                    @if(isset($currentTask->board))
                                    <a href="../boards/{{ $currentTask->board_id }}" class="table-link">
                                        {{ $currentTask->board->name }}
                                    </a>
                                    @endif
                                </td>
                            </tr>

                            <tr>
                                <td class="font-bold">Name</td>
                                @if($editing)
                                <td><x-jet-input type="text" wire:model.defer="currentTask.name" /></td>
                                @else
                                <td>{{ $currentTask->name }}</td>
                                @endif
                            </tr>

                            <tr>
                                <td class="font-bold">Description</td>
                                @if($editing)
                                <td><x-textarea wire:model.defer="currentTask.description" rows="4"></x-textarea></td>
                                @else
                                <td>{{ $currentTask->description }}</td>
                                @endif
                            </tr>

                            <tr>
                                <td class="font-bold">Priority</td>
                                @if($editing)
                                <td>
                                    <x-select2-multiple wire:model.defer="currentTask.priority" wire:key="current_task_priority" id="current-task-priority">
                                        @foreach(App\Models\Priority::all() as $priority)
                                        <option value="{{ $priority->id }}">{{ $priority->name }}</option>
                                        @endforeach
                                    </x-select2-multiple>
                                </td>
                                @else
                                <td>{{ $currentTask->priority }}</td>
                                @endif
                            </tr>

                            <tr>
                                <td class="font-bold">Deadline</td>
                                @if($editing)
                                <td>
                                    <x-jet-input type="date" wire:model.defer="currentTask.deadline" />
                                </td>
                                @else
                                <td>{{ $currentTask->deadline }}</td>
                                @endif
                            </tr>

                            <tr>
                                <td class="font-bold">Tags</td>
                                {{-- <td>
                                    <x-inline-edit
                                        id="{{ $currentTask->id }}-current-task"
                                        type="select2"
                                        :options="$this->allTags"
                                        original="Tags"
                                        :initial="$currentTags"
                                    />
                                </td> --}}
                                @if($editing)
                                <td>
                                    <div wire:key="tag_select">
                                        <x-select2-multiple
                                            wire:model.defer="currentTags"
                                            multiple
                                            id="tag-select"
                                            >
                                            @foreach ($this->allTags as $tag)
                                                <option value="{{ $tag->id }}">{{ $tag->name }}</option>
                                            @endforeach
                                        </x-select2-multiple>
                                    </div>
                                </td>
                                @else
                                <td>
                                    @foreach($currentTask->tags as $tag)
                                    <div>
                                        {{ $tag->name }}
                                    </div>
                                    @endforeach
                                </td>
                                @endif
                            </tr>

                            <tr>
                                <td class="font-bold">Assigned Users</td>
                                @if($editing)
                                <td>
                                    <div wire:key="edit_assigned">
                                        <x-select2-multiple
                                            id="edit-assigned"
                                            wire:model="assignedUsers"
                                            multiple
                                            >
                                            @foreach ($this->allUsers as $user)
                                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                                            @endforeach
                                        </x-select2-multiple>
                                    </div>
                                </td>
                                @else
                                <td>
                                    @foreach($currentTask->assignedUsers as $user)
                                    <div>
                                        {{ $user->name }}
                                    </div>
                                    @endforeach
                                </td>
                                @endif
                            </tr>
                        </table>
                    </div>
                @endif

                @if ($currentTab == 'files')
                    <div>
                        <div class="flex flex-col justify-center mb-4">
                            <x-input.filepond wire:model="files" multiple key="task_file_upload" />
                            <div class="flex items-center justify-center">
                                <button
                                    wire:click="uploadFiles"
                                    class="inline-flex items-center space-x-1 px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring focus:ring-gray-300 disabled:opacity-25 transition"
                                    @if(!$enableUpload) disabled @endif
                                    >
                                    <x-icons.file-upload />
                                    <span>Upload</span>
                                </button>
                            </div>
                        </div>

                        @if(count($currentTask->files) > 0)
                        <div
                            style="box-shadow: 0px 0px 0px 1px var(--color-gray-200);"
                            class="overflow-x-auto relative sm:rounded-lg shadow-xl"
                            >
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
                                    @foreach($currentTask->files as $index => $file)
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
                        <div class="flex items-center justify-center text-gray-500 py-8">
                            There are no files for this task yet
                        </div>
                        @endif
                    </div>
                @endif

                @if ($currentTab == 'comments')
                    @php /*
                    <div>
                        <div class="font-bold">
                            <span>{{ count($currentTask->comments) }}</span>
                            <span>Comments</span>
                        </div>
                        <div class="flex flex-col items-end space-y-2 mb-6">
                            <div class="w-full">
                                <x-mention wire:model.defer="itemComment.body" :mentionables="$usersForComment" />
                            </div>
                            <div class="flex justify-end">
                                <x-jet-button wire:click="postComment">Post comment</x-jet-button>
                            </div>
                        </div>
                        <div class="space-y-4">
                            @foreach($currentTask->comments as $comment)
                            <div class="comment-container flex flex-row items-start space-x-2 border-b border-gray-100 pb-3">
                                <div class="mr-1 shadow-md border-2 border-white w-8 h-8 bg-indigo-200 text-base p-2 rounded-full flex items-center justify-center">
                                    <span class="font-bold text-sm">{{ $this->generateInitials($comment->user->name) }}</span>
                                </div>
                                <div class="flex flex-col">
                                    <div>
                                        <div class="flex flex-row space-x-1 items-center comment-author">
                                            <span class="font-bold">{{ $comment->user->name }}</span>
                                            {{-- <div wire:click="confirmDeleteComment({{ $comment->id }})" class="cursor-pointer text-red-600 comment-delete-button flex flex-row">
                                                <x-icons.bin />
                                                <span class="text-xs">Delete comment</span>
                                            </div> --}}
                                        </div>
                                    </div>
                                    <div>{!! $comment->body !!}</div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    */ @endphp

                    <livewire:global-components.comment-section :entity="$currentTask" />
                @endif

                @if ($currentTab == 'subtasks')
                    <div wire:key="subtasks-{{ $currentTask->id }}">
                        <div class="flex flex-row items-center justify-between">
                            <div class="text-base font-bold">Subtasks</div>
                            @can('create tasks')
                            <button
                                wire:click="newSubtask"
                                class="border border-gray-300 p-2 rounded-md active:bg-gray-300 disabled:text-gray-400 disabled:active:bg-white disabled:border-gray-200"
                                >
                                <div class="flex flex-row space-x-1 items-center">

                                    <div class='flex flex-row items-center'>
                                        <x-icons.plus />
                                        <span class="font-bold">New</span>
                                    </div>
                                </div>
                            </button>
                            @endcan
                        </div>

                        @if(count($currentTask->subTasks) > 0)
                        <div
                            style="box-shadow: 0px 0px 0px 1px var(--color-gray-200);"
                            class="w-full overflow-x-auto relative sm:rounded-lg shadow-xl mt-2">
                            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400 border-collapse rounded-lg">
                                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                    <tr>
                                        <th scope="col" class="py-3 px-6">
                                        </th>
                                        <th scope="col" class="py-3 px-6">
                                            Task Name
                                        </th>
                                        <th scope="col" class="py-3 px-6">
                                            Due Date
                                        </th>
                                        <th scope="col" class="py-3 px-6">
                                            Priority
                                        </th>
                                        <th scope="col" class="py-3 px-6">
                                            Responsible Person
                                        </th>
                                        <th scope="col" class="py-3 px-6"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($currentTask->subTasks as $item)
                                    <tr class="bg-white border-b dark:bg-gray-900 dark:border-gray-700">
                                        <td class="py-4 px-6">
                                            <div
                                                wire:click="setCompleted({{ $item->id }})"
                                                style="width: 20px; height: 20px"
                                                class="
                                                flex justify-center items-center rounded-md border border-gray-300  transition-colors cursor-pointer
                                                @if($item->status == 'active') bg-green-600
                                                @elseif($item->status == 'inactive') bg-white
                                                @elseif($item->status == 'complete') bg-gray-600
                                                @endif"
                                                >
                                                @if($item->status == 'complete')
                                                    <span class="text-white -translate-x-px">
                                                        <x-icons.check width="16" height="16" />
                                                    </span>
                                                @else
                                                    <div></div>
                                                @endif
                                            </div>
                                        </td>
                                        <th scope="row" class="py-4 px-6 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                            <span
                                                class="text-blue-600 hover:underline cursor-pointer
                                                @if($item->status == 'complete') line-through @endif"
                                                wire:click="taskClicked({{ $item->id }})"
                                                >
                                                {{ $item->name }}
                                            </span>
                                        </th>
                                        <td class="py-4 px-6">
                                            {{-- {{ date('d/m/Y', strtotime($currentTask->deadline)) }} --}}
                                            {{ Carbon\Carbon::parse($currentTask->deadline)->format('d M y') }}
                                        </td>
                                        <td class="py-4 px-6">
                                            {{ isset($item->priorityForeign->name) ?  $item->priorityForeign->name : ''}}
                                        </td>
                                        <td class="py-4 px-6">
                                            {{ isset($item->getResponsiblePerson->name) ?  $item->getResponsiblePerson->name : ''}}
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
            </x-slot>

            <x-slot name="footer">
                <x-jet-button wire:click="$set('showTaskDetailsModal', false)">Close</x-jet-button>
            </x-slot>
        </x-jet-dialog-modal>
        {{-- End Task details modal --}}

        {{-- Confirm delete modal --}}
        <x-jet-confirmation-modal wire:model="showConfirmDeleteModal">
            <x-slot name="title">Delete Task</x-slot>
            <x-slot name="content">
                <div>
                    Are you sure you would like to delete this task?
                </div>
            </x-slot>
            <x-slot name="footer">
                <div class="flex justify-end items-center gap-1">
                    <x-buttons.cancel-button x-on:click="show = false;">Cancel</x-buttons.cancel-button>
                    <x-buttons.delete-button wire:click="deleteTask">Delete</x-buttons.delete-button>
                </div>
            </x-slot>
        </x-jet-confirmation-modal>
        {{-- End confirm delete modal --}}

        {{-- Create task modal --}}
        <x-jet-dialog-modal wire:model="showCreateItemModal">
            <x-slot name="title">Create New @if($isSubtask) Subtask @else Task @endif</x-slot>

            <x-slot name="content">
                <form class="space-y-4">
                    <div>
                        <x-jet-label for="client-name" value="Client" />
                        <x-select2-multiple id="client-name" wire:model="newItemClient">
                            <option value="">Select Client</option>
                            @foreach ($this->allClients as $client)
                                <option value="{{ $client->id }}">{{ $client->name }}</option>
                            @endforeach
                        </x-select2-multiple>
                        <x-validation-error field="newItemClient" />
                    </div>

                    <div x-data="{ showNew: false }">
                        <div class="flex gap-1">
                            <x-jet-label for="select-board" value="Project" />
                            @if($newItemClient)
                            <div
                                x-on:click="() => {
                                    showNew = !showNew;
                                    showNew && setTimeout(() => $refs.newProjectName.focus(), 120);
                                }"
                                class="text-sm text-blue-600 hover:underline cursor-pointer"
                                >
                                New...
                            </div>
                            @endif
                        </div>

                        <div x-show="showNew" x-collapse class="flex flex-col">
                            <div class="flex gap-2 py-2 px-1">
                                <x-jet-input x-ref="newProjectName" type="date" wire:model="newBoard.name" />
                                <x-jet-button wire:click.prevent="createBoard">Create</x-jet-button>
                            </div>
                            <x-validation-error field="newBoard.name" />
                        </div>

                        <x-select id="select-board" wire:model="newItemBoard" disabled="{{ $newItemClient == '' ? 'disabled' : '' }}">
                            <option value="">Select Project</option>
                            @if(isset($clientBoards) && !empty($clientBoards))
                                @foreach ($clientBoards as $board)
                                    <option value="{{ $board->id }}">{{ $board->name }}</option>
                                @endforeach
                            @endif
                        </x-select>
                        <x-validation-error field="newItemBoard" />
                    </div>

                    <div>
                        <x-jet-label for="phase" value="Phase" />
                        <x-select id="phase" wire:model="newItemPhase" disabled="{{ $newItemBoard == null ? 'disabled' : '' }}">
                            <option value="">Select a phase</option>
                            @foreach ($this->phases as $phase)
                                <option value="{{ $phase->id }}">{{ $phase->name }}</option>
                            @endforeach
                        </x-select>
                        <x-validation-error field="newItem.phase_id" />
                    </div>

                    <div>
                        <x-jet-label for="parent-task" value="Parent Task" />
                        <x-select
                            id="parent-task"
                            wire:model.defer="newItem.parent_id"
                            disabled="{{ $newItemPhase == null || $boardTasks->isEmpty() ? 'disabled' : '' }}"
                            >
                            <option value="">Select a task</option>
                            @foreach ($boardTasks as $task)
                                <option value="{{ $task->id }}">{{ $task->name }}</option>
                            @endforeach
                        </x-select>
                    </div>

                    <div>
                        <x-jet-label for="name" value="Task Name" />
                        <x-jet-input type="text" id="name" wire:model.defer="newItem.name" />
                        <x-validation-error field="newItem.name" />
                    </div>

                    <div>
                        <x-jet-label for="newTask-responsiblePerson" value="Responsible Person" />
                        <div wire:key="newTask-responsible-person">
                            <x-select2-multiple id="responsible-person-new" wire:model.defer="newItem.responsible_person">
                                @foreach ($this->allUsers as $user)
                                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                                @endforeach
                            </x-select2-multiple>
                        </div>
                        {{-- <x-validation-error field="newItem.responsible_person" /> --}}
                    </div>

                    <div>
                        <x-jet-label for="description" value="Description" />
                        <x-textarea rows="5" id="description" wire:model.defer="newItem.description"></x-textarea>
                    </div>

                    <div>
                        <x-jet-label for="deadline" value="Due Date" />
                        <x-jet-input type="date" id="deadline" wire:model.defer="newItem.deadline" />
                    </div>

                    <div>
                        <x-jet-label for="priority_new_item" value="Priority" />
                        <x-select2-multiple id="priority_new_item" wire:model="newItem.priority_id" name="priority_new_item">
                            @foreach ($this->priorities as $priority)
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
                            @foreach ($this->allTags as $tag)
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
                            @foreach ($this->allUsers as $user)
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
        {{-- End Create task modal --}}

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
                                        @foreach ($this->colours as $colour)
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

        {{-- <x-access-denied-modal wire:model="accessDeniedModal" /> --}}
    {{-- END MODALS --}}

    <div class="hidden bg-green-500"></div>
</div>
