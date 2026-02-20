<div>
    <div class="text-xl font-bold">Create Audit</div>
    
    <div class="flex justify-between items-center my-8">
        <div class="flex gap-8 items-start w-1/2 bg-white rounded-xl p-8">
            <div class="w-1/2">
                <x-jet-label value="Name" for="name" />
                <x-jet-input wire:model.defer="audit.name" id="name" type="text" />
                <x-validation-error field="audit.name" />
            </div>

            <div class="w-1/2">
                <x-jet-label value="Client" for="client" />
                <select wire:model="audit.client_id" id="client" class="border-gray-300 rounded-md shadow-sm w-full">
                    <option value="">Select Client</option>
                    @foreach($clients as $client)
                        <option value="{{ $client->id }}">{{ $client->name }}</option>
                    @endforeach
                </select>
                <x-validation-error field="audit.client_id" />
            </div>

            @if($audit->client_id)
                <div class="w-1/2">
                    <x-jet-label value="Project" for="project" />
                    @php $projectOptions = ($projects instanceof \Illuminate\Support\Collection) ? $projects : collect($projects); @endphp
                    @if($projectOptions->isNotEmpty())
                        <select wire:model="audit.board_id" id="project" class="border-gray-300 rounded-md shadow-sm w-full">
                            <option value="">Select Project</option>
                            @foreach($projectOptions as $project)
                                <option value="{{ $project->id }}">{{ $project->name }}</option>
                            @endforeach
                        </select>
                        <x-validation-error field="audit.board_id" />
                    @else
                        <div class="border border-dashed border-gray-300 rounded-md px-4 py-2 text-sm text-gray-500 bg-gray-50">
                            No projects found for this client.
                        </div>
                    @endif
                </div>
            @endif
        </div>

        <div class="flex items-center gap-2">
            <x-create-button wire:click="openNewCategoryModal">Add Category</x-create-button>
        </div>
    </div>

    {{-- Load Template --}}
    <div class="flex mb-6">
    <div class="w-1/3">
        <x-jet-label for="template" value="Select from template" />
        <select
        id="template"
        wire:model="selectedTemplate"
        class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-full px-4 py-2 mt-1"
        >
        <option value="">— None —</option>
        @foreach($templates as $template)
            <option value="{{ $template->id }}">{{ $template->name }}</option>
        @endforeach
        </select>
    </div>
    </div>

    <!-- Search Filter & Select/Deselect Buttons -->
    <div class="flex justify-between items-center mb-4">
        <div class="relative w-1/3">
            <input 
                type="text" 
                wire:model.debounce.300ms="searchTerm" 
                class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-full px-4 py-2"
                placeholder="Filter by Top-Level, Category, or File Name..."
            />
        </div>

        <!-- Select/Deselect Buttons -->
        <div class="flex gap-2">
            <x-jet-button wire:click="selectAll">Select All</x-jet-button>
            <x-jet-button wire:click="deselectAll">Deselect All</x-jet-button>
        </div>
    </div>

    <!-- Grouped Categories by Top-Level -->
    <div class="rounded-lg space-y-6">
        @forelse($this->auditData as $topLevel => $categories)
            <div class="bg-gray-200 p-4 rounded">
                <div class="flex justify-between items-center">
                    <h2 class="text-lg font-bold text-gray-700" style="font-size:24px; padding:10px;">{{ $topLevel ?? 'Uncategorized' }}</h2>

                    <!-- Select/Deselect Top-Level Category -->
                    <div class="flex gap-2">
                        <x-jet-button wire:click="selectTopLevel('{{ $topLevel }}')">Select All</x-jet-button>
                        <x-jet-button wire:click="deselectTopLevel('{{ $topLevel }}')">Deselect All</x-jet-button>
                        <x-jet-button
                            type="button"
                            x-data
                            data-top="{{ $topLevel }}"
                            x-on:click="$wire.openNewFolderModal($el.dataset.top)"
                        >New Folder</x-jet-button>
                    </div>
                </div>

                @foreach($categories as $category)
                    <div wire:sortable.item="{{ $category->id }}" class="bg-white rounded-lg shadow-md mb-4" wire:key="table-{{ $category->id }}">
                        <div class="pb-4 rounded-lg" style="box-shadow: inset 0px 0px 0px 1px #E5E7EA;">
                            <div class="bg-gray-600 py-2 mb-4 rounded-tr-lg rounded-tl-lg grid grid-cols-1 sm:grid-cols-3 gap-2 items-center">
                                <div wire:sortable.handle class="text-gray-200 cursor-grab ml-2">
                                    <x-icons.move width="20" height="20" />
                                </div> 

                                <div class="uppercase text-white flex flex-row items-center justify-center gap-1">
                                    {{ $category->name }}
                                </div>

                                <!-- Select/Deselect Individual Category -->
                                <div class="flex justify-end gap-2">
                                    <x-jet-button wire:click="selectCategory({{ $category->id }})">Select All</x-jet-button>
                                    <x-jet-button wire:click="deselectCategory({{ $category->id }})">Deselect All</x-jet-button>
                                    {{-- Removed inline New Folder at folder level per request --}}
                                    <x-jet-button class="mr-2 space-x-1" wire:click="setShowNewReferenceItemModal({{ $category->id }})">
                            <x-icons.plus size="16" />
                            <div>New</div>
                        </x-jet-button>
                                </div>
                            </div>
                            
                            <div class="px-4 pb-4">
                                @if($category->referenceItems->isEmpty())
                                    <div class="text-gray-600 text-sm py-4 text-center">
                                        <div>There are no items in this category.</div>
                                        <div>Click the 'New' button above to add some.</div>
                                    </div>
                                @else
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-2 md:gap-3">
                                        @foreach ($category->referenceItems as $item)
                                            <label
                                                for="item-{{ $item->id }}"
                                                class="flex items-center justify-between bg-gray-50 border border-gray-200 rounded-md px-3 py-2 hover:bg-gray-100 transition cursor-pointer"
                                            >
                                                <div class="truncate pr-3">{{ $item->name }}</div>
                                                <input 
                                                    type="checkbox" 
                                                    class="checkbox-item shrink-0"
                                                    value="{{ $item->id }}" 
                                                    wire:model="selected"
                                                    id="item-{{ $item->id }}"
                                                />
                                            </label>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @empty
            <p class="text-gray-500 text-center text-lg">No results match your search.</p>
        @endforelse
    </div>
    <br/><br/>
    <div class="fixed bottom-0 inset-x-0 z-[9999] bg-white border-t shadow-md">
        <div class="flex justify-end px-6 py-3">
            <x-jet-button class="text-white" style="background-color: rgb(37, 99, 235); border-color: rgb(37, 99, 235);" wire:click="createAudit">
                Create Audit
            </x-jet-button>
        </div>
    </div>

    {{-- MODALS --}}
        {{-- New reference item modal --}}
        <x-jet-dialog-modal wire:model="showNewReferenceItemModal">
            <x-slot name="title">New item</x-slot>

            <x-slot name="content">
                <div>
                    <x-jet-label for="name" value="Name" />
                    <x-jet-input id="name" type="text" wire:model.defer="newAuditRef.name" />
                </div>

                <div class="flex flex-row-reverse items-center justify-end gap-1 mt-2">
                    <x-jet-label for="default" value="Add as default" />
                    <x-jet-checkbox id="default" wire:model.defer="newAuditRef.default" />
                </div>
            </x-slot>

            <x-slot name="footer">
                <div class="flex items-center justify-end">
                    <x-buttons.cancel-button x-on:click="show = false">Cancel</x-buttons.cancel-button>
                    <x-jet-button wire:click="createNewReferenceItem">Create</x-jet-button>
                </div>
            </x-slot>
        </x-jet-dialog-modal>
        {{-- End new reference item modal --}}

    <x-jet-dialog-modal wire:model="showCreateNewFolderModal">
        <x-slot name="title">New folder</x-slot>

            <x-slot name="content">
                <div>
                    <x-jet-label for="name" value="Folder Name" />
                    <x-jet-input type="text" wire:model.defer="newFolder.name" />
                </div>
            </x-slot>

            <x-slot name="footer">
                <div class="flex justify-end items-center gap-1">
                    <x-buttons.cancel-button x-on:click="show = false">Cancel</x-buttons.cancel-button>
                    <x-jet-button wire:click="createFolder">Create Folder</x-jet-button>
                </div>
        </x-slot>
    </x-jet-dialog-modal>
    {{-- Add Category modal --}}
    <x-jet-dialog-modal wire:model="showNewCategoryModal">
        <x-slot name="title">Add Category</x-slot>
        <x-slot name="content">
            <div>
                <x-jet-label for="top-level-name" value="Category Name" />
                <x-jet-input id="top-level-name" type="text" wire:model.defer="newTopLevelName" />
                @error('newTopLevelName') <div class="text-red-600 text-sm mt-1">{{ $message }}</div> @enderror
            </div>
        </x-slot>
        <x-slot name="footer">
            <div class="flex justify-end items-center gap-1">
                <x-buttons.cancel-button x-on:click="show = false">Cancel</x-buttons.cancel-button>
                <x-jet-button wire:click="createTopLevelCategory">Create</x-jet-button>
            </div>
        </x-slot>
    </x-jet-dialog-modal>
    {{-- END MODALS --}}
</div>
