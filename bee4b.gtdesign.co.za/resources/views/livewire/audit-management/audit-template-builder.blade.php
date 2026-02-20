<div>
    {{-- Header --}}
    
    {{-- Template selector + Name --}}
    <div class="flex justify-between items-center my-8">

    <div class="mb-8 text-2xl space-y-2">
            <div>Audit Template Builder</div>
    </div>

        

        {{-- New Folder button --}}
        <div>
            <x-create-button wire:click="setShowCreateNewFolderModal">
                New Folder
            </x-create-button>
        </div>
    </div>

    <div class="flex gap-8 items-start w-full bg-white rounded-xl p-8">
            
            <div
                x-data="{ show:false, text:'' }"
                x-on:template-saved.window="text = $event.detail.message; show = true; setTimeout(() => show = false, 3000)"
                x-show="show"
                x-transition
                class="fixed top-5 right-5 bg-green-600 text-white px-4 py-2 rounded shadow-lg"
                style="display:none;"
                >
                <span x-text="text"></span>
            </div>

            {{-- Template dropdown --}}
            <div class="w-1/2">
                <x-jet-label for="template" value="Template" />
                <select
                    id="template"
                    wire:model="selectedTemplate"
                    class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-full px-4 py-2"
                >
                    <option value="">— New Template —</option>
                    @foreach($templates as $template)
                        <option value="{{ $template->id }}">{{ $template->name }}</option>
                    @endforeach
                </select>
            </div>

            {{-- Template name --}}
            <div class="w-1/2">
                <x-jet-label for="name" value="Template Name" />
                <x-jet-input
                    id="name"
                    type="text"
                    wire:model.defer="name"
                    class="w-full mt-1"
                />
                <x-validation-error field="name" />
            </div>
        </div>

    {{-- Search & Bulk Actions --}}
    <div class="flex justify-between items-center mb-4" style="margin-top:30px;">
        <div class="relative w-1/3">
            <input 
                type="text" 
                wire:model.debounce.300ms="searchTerm" 
                class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-full px-4 py-2"
                placeholder="Filter by Top-Level, Category, or Item name..."
            />
        </div>

        <div class="flex gap-2">
            <x-jet-button wire:click="selectAll">Select All</x-jet-button>
            <x-jet-button wire:click="deselectAll">Deselect All</x-jet-button>
        </div>
    </div>

    {{-- Grouped Categories by Top-Level --}}
    <div class="rounded-lg space-y-6">
        @forelse($categories as $topLevel => $cats)
            <div class="bg-gray-200 p-4 rounded">
                <div class="flex justify-between items-center">
                    <h2 class="text-lg font-bold text-gray-700" style="font-size:24px; padding:10px;">
                        {{ $topLevel ?? 'Uncategorized' }}
                    </h2>

                    {{-- Top-Level Select/Deselect --}}
                    <div class="flex gap-2">
                        <x-jet-button wire:click="selectTopLevel('{{ $topLevel }}')">
                            Select All
                        </x-jet-button>
                        <x-jet-button wire:click="deselectTopLevel('{{ $topLevel }}')">
                            Deselect All
                        </x-jet-button>
                    </div>
                </div>

                @foreach($cats as $category)
                    <div
                        wire:sortable.item="{{ $category->id }}"
                        class="bg-white rounded-lg shadow-md mb-4"
                        wire:key="cat-{{ $category->id }}"
                    >
                        <div class="pb-4 rounded-lg" style="box-shadow: inset 0px 0px 0px 1px #E5E7EA;">
                            <div
                                class="bg-gray-600 py-2 mb-4 rounded-tr-lg rounded-tl-lg grid grid-cols-1 sm:grid-cols-3 gap-2 items-center"
                            >
                                {{-- Drag handle --}}
                                <div wire:sortable.handle class="text-gray-200 cursor-grab ml-2">
                                    <x-icons.move width="20" height="20" />
                                </div> 

                                {{-- Category Name --}}
                                <div class="uppercase text-white flex items-center justify-center gap-1">
                                    {{ $category->name }}
                                </div>

                                {{-- Category Select/Deselect + New Item --}}
                                <div class="flex justify-end gap-2">
                                    <x-jet-button wire:click="selectCategory({{ $category->id }})">
                                        Select All
                                    </x-jet-button>
                                    <x-jet-button wire:click="deselectCategory({{ $category->id }})">
                                        Deselect All
                                    </x-jet-button>
                                    <x-jet-button
                                        class="mr-2 space-x-1"
                                        wire:click="setShowNewReferenceItemModal({{ $category->id }})"
                                    >
                                        <x-icons.plus size="16" />
                                        <div>New</div>
                                    </x-jet-button>
                                </div>
                            </div>
                            
                            {{-- Items --}}
                            <div class="px-4 pb-4">
                                @if($category->referenceItems->isEmpty())
                                    <div class="text-gray-600 text-sm py-4 text-center">
                                        <div>There are no items in this category.</div>
                                        <div>Click ‘New’ above to add one.</div>
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
                                                    id="item-{{ $item->id }}"
                                                    class="checkbox-item shrink-0"
                                                    wire:model="checked.{{ $item->id }}"
                                                    value="1"
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
            <p class="text-gray-500 text-center text-lg">
                No results match your filter.
            </p>
        @endforelse
    </div>

    {{-- Save Template (docked) --}}
    <div class="fixed bottom-0 inset-x-0 z-[9999] bg-white border-t shadow-md">
        <div class="flex justify-end px-6 py-3">
            <x-jet-button class="text-white" style="background-color: rgb(37, 99, 235); border-color: rgb(37, 99, 235);" wire:click="saveTemplate">SAVE TEMPLATE</x-jet-button>
        </div>
    </div>

    {{-- New Item Modal --}}
    <x-jet-dialog-modal wire:model="showNewReferenceItemModal">
        <x-slot name="title">New Item</x-slot>
        <x-slot name="content">
            <div>
                <x-jet-label for="name" value="Name" />
                <x-jet-input
                    id="name"
                    type="text"
                    wire:model.defer="newAuditRef.name"
                    class="w-full mt-1"
                />
            </div>
            <div class="flex items-center justify-end gap-2 mt-4">
                <x-jet-label for="default" value="Default" />
                <x-jet-checkbox id="default" wire:model.defer="newAuditRef.default" />
            </div>
        </x-slot>
        <x-slot name="footer">
            <div class="flex justify-end items-center gap-2">
                <x-buttons.cancel-button x-on:click="$set('showNewReferenceItemModal', false)">
                    Cancel
                </x-buttons.cancel-button>
                <x-jet-button wire:click="createNewReferenceItem">Create</x-jet-button>
            </div>
        </x-slot>
    </x-jet-dialog-modal>

    {{-- New Folder Modal --}}
    <x-jet-dialog-modal wire:model="showCreateNewFolderModal">
        <x-slot name="title">New Folder</x-slot>
        <x-slot name="content">
            <div>
                <x-jet-label for="folder-name" value="Folder Name" />
                <x-jet-input
                    id="folder-name"
                    type="text"
                    wire:model.defer="newFolder.name"
                    class="w-full mt-1"
                />
            </div>
        </x-slot>
        <x-slot name="footer">
            <div class="flex justify-end items-center gap-2">
                <x-buttons.cancel-button x-on:click="$set('showCreateNewFolderModal', false)">
                    Cancel
                </x-buttons.cancel-button>
                <x-jet-button wire:click="createFolder">Create Folder</x-jet-button>
            </div>
        </x-slot>
    </x-jet-dialog-modal>
</div>
