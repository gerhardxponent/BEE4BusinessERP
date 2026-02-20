<div>
    <x-jet-dialog-modal wire:model="showModal">
        <x-slot name="title">
            {{-- {{ $task->name }} --}}

            <div class="flex flex-row justify-between">
                <div>{{ $task->name }}</div>
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
            <div>
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
                                    @if(isset($task->board))
                                    <a href="../boards/{{ $task->board_id }}" class="table-link">
                                        {{ $task->board->name }}
                                    </a>
                                    @endif
                                </td>
                            </tr>

                            <tr>
                                <td class="font-bold">Name</td>
                                @if($editing)
                                <td><x-jet-input type="text" wire:model.defer="task.name" /></td>
                                @else
                                <td>{{ $task->name }}</td>
                                @endif
                            </tr>

                            <tr>
                                <td class="font-bold">Description</td>
                                @if($editing)
                                <td><x-textarea wire:model.defer="task.description" rows="4"></x-textarea></td>
                                @else
                                <td>{{ $task->description }}</td>
                                @endif
                            </tr>

                            <tr>
                                <td class="font-bold">Priority</td>
                                @if($editing)
                                <td>
                                    <x-select2-multiple wire:model.defer="task.priority" wire:key="current_task_priority" id="current-task-priority">
                                        @foreach(App\Models\Priority::all() as $priority)
                                        <option value="{{ $priority->id }}">{{ $priority->name }}</option>
                                        @endforeach
                                    </x-select2-multiple>
                                </td>
                                @else
                                <td>{{ $task->priority }}</td>
                                @endif
                            </tr>

                            <tr>
                                <td class="font-bold">Deadline</td>
                                @if($editing)
                                <td>
                                    <x-jet-input type="date" wire:model.defer="task.deadline" />
                                </td>
                                @else
                                <td>{{ $task->deadline }}</td>
                                @endif
                            </tr>

                            <tr>
                                <td class="font-bold">Tags</td>
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
                                    @foreach($task->tags as $tag)
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
                                    @foreach($task->assignedUsers as $user)
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
                    {{-- <div>
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

                        @if(count($task->files) > 0)
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
                                    @foreach($task->files as $index => $file)
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
                    </div> --}}
                @endif

                @if ($currentTab == 'comments')
                    <livewire:global-components.comment-section :entity="$task" />
                @endif

                @if ($currentTab == 'subtasks')
                    <div wire:key="subtasks-{{ $task->id }}">
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

                        @if(count($task->subTasks) > 0)
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
                                    @foreach($task->subTasks as $item)
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
                                            {{-- {{ date('d/m/Y', strtotime($task->deadline)) }} --}}
                                            {{ Carbon\Carbon::parse($task->deadline)->format('d M y') }}
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
                                    <x-icons.plus />
                                    <span>New</span>
                                </div> 
                                <div>button above to add some</div>
                            </div>
                        </div>
                        @endif
                    </div>
                @endif
            </div>
        </x-slot>
        <x-slot name="footer">
            <x-buttons.cancel-button x-on:click="show = false">Cancel</x-buttons.cancel-button>
        </x-slot>
    </x-jet-dialog-modal>
</div>
