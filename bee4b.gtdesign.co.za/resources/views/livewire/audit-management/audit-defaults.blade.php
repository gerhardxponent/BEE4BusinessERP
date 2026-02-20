<div>
    {{-- <x-back link="./audits">all Audits</x-back> --}}

    <div class="flex justify-between items-center">
        <div class="mb-8 text-2xl space-y-2">
            <div>Default Audit Fields</div>
            <div class="flex gap-1 text-gray-600 text-base items-center">
                <x-icons.info size="20" />
                <div>Click on an item to rename it</div>
            </div>
        </div>

        <div>
            <x-jet-button class="flex " wire:click="openNewCategoryModal">
                <x-icons.plus />
                <div>Add Category</div>
            </x-jet-button>

            <a href="/public/settings/audit-templates"><x-jet-button class="flex " >
                <x-icons.vertical-dots />
                <div>Manage Audit Templates</div>
            </x-jet-button></a>
        </div>
    </div>

   <!-- Search Filter Input -->
    <div class="flex justify-between items-center mb-4">
        <div class="relative w-1/3">
            <input 
                type="text" 
                wire:model.debounce.300ms="searchTerm" 
                class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-full px-4 py-2"
                placeholder="Filter by Top-Level, Category, or File Name..."
            />
            
        </div>
    </div>

<!-- Display the Filtered Results -->
<div wire:sortable="updateCategoryOrder" class="rounded-lg space-y-4">
    @forelse($this->auditCategories as $topLevel => $categories)
        <div class="bg-gray-200 p-4 mb-4 rounded">
            <div class="flex items-center justify-between">
                <h2 class="text-lg font-bold text-gray-700" style="font-size:40px; padding:15px;">
                    {{ $topLevel ?? 'Uncategorized' }}
                </h2>
                <div class="flex items-center gap-2">
                    <x-jet-secondary-button type="button" onclick="renameCategoryPrompt('{{ addslashes($topLevel) }}')">Rename</x-jet-secondary-button>
                    <x-jet-button type="button" class="mr-2 space-x-1" x-data data-top-raw="{{ $topLevel }}" x-on:click="quickCreateDefaultsFolder($el.getAttribute('data-top-raw'), $el)">
                        <x-icons.plus size="16" />
                        <div>New Folder</div>
                    </x-jet-button>
                    <x-buttons.delete-button
                        class="mr-2"
                        onclick="deleteCategory('{{ addslashes($topLevel) }}', this); return false;"
                    >Delete Category</x-buttons.delete-button>
                </div>
            </div>

            @forelse($categories as $category)
                <div wire:sortable.item="{{ $category->id }}" class="bg-white rounded-lg" wire:key="table-{{ $category->id }}">
                    <div class="pb-4 rounded-lg" style="box-shadow: inset 0px 0px 0px 1px #E5E7EA;">
                        <div class="bg-gray-600 py-2 mb-4 rounded-tr-lg rounded-tl-lg grid grid-cols-4 justify-items-between items-center">
                            <div wire:sortable.handle class="text-gray-200 cursor-grab ml-2">
                                <x-icons.move width="20" height="20" />
                            </div> 

                            <div class="uppercase text-white flex flex-row items-center justify-center gap-1">
                                <livewire:global-components.inline-edit 
                                    :model="'\\App\\Models\\AuditReferenceCategory'"
                                    :entity="$category"
                                    :field="'name'"
                                    :key="'audit-category-'.$category->id"
                                    permission='edit audits'
                                />
                            </div>

                            <div class="flex justify-end">
                                <x-jet-button class="mr-2 space-x-1" wire:click="showCreateReferenceItemModal({{ $category->id }})">
                                    <x-icons.plus size="16" />
                                    <div>New</div>
                                </x-jet-button>
                                <x-buttons.delete-button
                                    class="mr-2"
                                    wire:click="hideFolder({{ $category->id }})"
                                    title="Hide this folder and all its items"
                                >Delete Folder</x-buttons.delete-button>
                            </div>

                        </div>

                        <div class="px-4 pb-4">
                            @if($category->referenceItems->isNotEmpty())
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-2 md:gap-3">
                                    @foreach ($category->referenceItems as $item)
                                        <div class="flex items-center justify-between bg-gray-50 border border-gray-200 rounded-md px-3 py-2 hover:bg-gray-100 transition">
                                            <div class="min-w-0 flex-1">
                                                <livewire:global-components.inline-edit
                                                    :model="'\\App\\Models\\AuditReference'"
                                                    :entity="$item"
                                    :field="'name'"
                                                    :key="'reference-item-'.$item->id"
                                                    lineID="audit-item-{{ $item->id }}"
                                                />
                                            </div>
                                            <div class="ml-3 shrink-0">
                                                <x-buttons.delete-button
                                                    size="xs"
                                                    wire:click="hideReference({{ $item->id }})"
                                                    title="Hide this field"
                                                >Delete</x-buttons.delete-button>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <p class="text-gray-500 text-sm text-center">No files found in this category.</p>
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                <p class="text-gray-500 text-sm text-center">No categories found.</p>
            @endforelse
        </div>
    @empty
        <p class="text-gray-500 text-center text-lg">No results match your search.</p>
    @endforelse
</div>

<script>
  // Override helpers to always target the AuditDefaults component via emitTo
  function openFolder(topLevel, el) {
    Livewire.emitTo('audit-management.audit-defaults','open-folder-modal', topLevel);
  }
  
  function deleteCategory(topLevel, el) {
    if (!confirm('Delete this category and hide all its folders and items?')) return;
    Livewire.emitTo('audit-management.audit-defaults','delete-top-level', topLevel);
  }
  
  function quickCreateDefaultsFolder(topLevel, el) {
    var name = window.prompt('Folder name for "' + topLevel + '"');
    if (!name) return;
    Livewire.emitTo('audit-management.audit-defaults','quick-create-folder', topLevel, name);
  }
  
  function renameCategoryPrompt(topLevel) {
    var newName = window.prompt('Rename category "' + topLevel + '" to:', topLevel);
    if (!newName || newName.trim() === '' || newName === topLevel) return;
    
    console.log('Renaming from:', topLevel, 'to:', newName.trim());
    Livewire.emitTo('audit-management.audit-defaults', 'rename-top-level-quick', topLevel, newName.trim());
  }
</script>


    {{-- MODALS --}}
        {{-- New reference item modal --}}
        <x-jet-dialog-modal wire:model="showNewReferenceItemModal">
            <x-slot name="title">New item</x-slot>

            <x-slot name="content">
                <div>
                    <x-jet-label for="name" value="Name" />
                    <x-jet-input id="name" type="text" wire:model.defer="newAuditRef.name" />
                    <x-validation-error field="newAuditRef.name" />
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

        {{-- New folder modal (within a Category) --}}
        <x-jet-dialog-modal wire:model="showNewFolderModal">
            <x-slot name="title">New folder</x-slot>

            <x-slot name="content">
                <div>
                    <x-jet-label for="name" value="Folder Name" />
                    <x-jet-input id="name" type="text" wire:model.defer="newAuditFolder.name" />
                    <x-validation-error field="newAuditFolder.name" />
                </div>
            </x-slot>

            <x-slot name="footer">
                <div class="flex items-center justify-end">
                    <x-buttons.cancel-button x-on:click="show = false">Cancel</x-buttons.cancel-button>
                    <x-jet-button wire:click="createNewFolder">Create</x-jet-button>
                </div>
            </x-slot>
        </x-jet-dialog-modal>

        {{-- Add Category (Top-Level) modal --}}
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
                <div class="flex items-center justify-end">
                    <x-buttons.cancel-button x-on:click="show = false">Cancel</x-buttons.cancel-button>
                    <x-jet-button wire:click="createTopLevelCategory">Create</x-jet-button>
                </div>
            </x-slot>
        </x-jet-dialog-modal>
    {{-- END MODALS --}}
    {{-- Rename Category (Top-Level) modal --}}
    <x-jet-dialog-modal wire:model="showRenameCategoryModal">
        <x-slot name="title">Rename Category</x-slot>
        <x-slot name="content">
            <div class="space-y-2">
                <div>
                    <x-jet-label for="rename-from" value="Current" />
                    <x-jet-input id="rename-from" type="text" class="w-full mt-1" wire:model.defer="renameFrom" disabled />
                </div>
                <div>
                    <x-jet-label for="rename-to" value="New Name" />
                    <x-jet-input id="rename-to" type="text" class="w-full mt-1" wire:model.defer="renameTo" />
                    @error('renameTo') <div class="text-red-600 text-sm mt-1">{{ $message }}</div> @enderror
                </div>
            </div>
        </x-slot>
        <x-slot name="footer">
            <div class="flex items-center justify-end gap-2">
                <x-buttons.cancel-button x-on:click="$set('showRenameCategoryModal', false)">Cancel</x-buttons.cancel-button>
                <x-jet-button wire:click="renameTopLevel">Rename</x-jet-button>
            </div>
        </x-slot>
    </x-jet-dialog-modal>
</div>