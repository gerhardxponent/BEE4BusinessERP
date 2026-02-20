<div class="space-y-4">
    <x-header>
        <x-slot name="title">Files</x-slot>
    </x-header>

    {{-- <x-jet-button wire:click="settings">File Categories</x-jet-button> --}}

    <livewire:files.files-table/>

    <x-jet-dialog-modal wire:model="showFileModal">
        <x-slot name="title">
            <div class="flex flex-row justify-between">
                <div>{{ $selectedFile->file_name }}</div>
                <x-jet-button wire:click="$toggle('editing')">@if($editing) Cancel @else Edit @endif</x-jet-button>
            </div>
        </x-slot>

        <x-slot name="content">
            <div class="space-y-8">
                <div>
                    <table class="table-fixed">
                        <tr>
                            <td class="font-bold">File Name</td>
                            @if($editing)
                            <td><x-jet-input type="text" wire:model="selectedFile.file_name" /></td>
                            @else
                            <td>{{ $selectedFile->file_name }}</td>
                            @endif
                        </tr>

                        @if(!$editing)
                        <tr>
                            <td class="font-bold">File Type</td>
                            <td>{{ $selectedFile->type }}</td>
                        </tr>
                        @endif

                        @if(!$editing)
                        <tr>
                            <td class="font-bold">File Size</td>
                            <td>{{ $selectedFile->file_size }}</td>
                        </tr>
                        @endif

                        <tr>
                            <td class="font-bold">Client Comments</td>
                            @if($editing)
                            <td><x-textarea wire:model="selectedFile.client_comments"></x-textarea></td>
                            @else
                            <td>{{ $selectedFile->client_comments }}</td>
                            @endif
                        </tr>

                        <tr>
                            <td class="font-bold">Reviewer Comments</td>
                            @if($editing)
                            <td><x-textarea wire:model="selectedFile.reviewer_comments"></x-textarea></td>
                            @else
                            <td>{{ $selectedFile->reviewer_comments }}</td>
                            @endif
                        </tr>

                        <tr>
                            <td class="font-bold">Status</td>
                            @if($editing)
                            <td><x-jet-input type="text" wire:model="selectedFile.status" /></td>
                            @else
                            <td>{{ $selectedFile->status }}</td>
                            @endif
                        </tr>

                        @if(!$editing)
                        <tr>
                            <td class="font-bold">Module</td>
                            <td>
                                {{ isset($selectedFile->fileable_type) && isset($selectedFile->fileable_type::make()->displayName) ? $selectedFile->fileable_type::make()->displayName : class_basename($selectedFile->fileable_type) }}
                            </td>
                        </tr>

                        <tr>
                            <td class="font-bold">Record</td>
                            <td>
                                @if(isset($selectedFile->fileable) && isset($selectedFile->fileable->name))
                                    {{ $selectedFile->fileable->name }}
                                @elseif(isset($selectedFile->fileable) && isset($selectedFile->fileable->firstname))
                                    {{ $selectedFile->fileable->firstname }} {{ $selectedFile->fileable->lastname }}
                                @else
                                    {{ explode('/', $selectedFile->file_path)[array_key_last(explode('/', $selectedFile->file_path))] }}
                                    <span class="text-red-500 text-xs uppercase  font-bold rounded-full">Deleted</span>
                                @endif
                            </td>
                        </tr>

                        <tr>
                            <td class="font-bold">Path</td>
                            <td>
                                {{ str_replace('/', ' / ', trim($selectedFile->file_path, 'uploads/')) }}
                            </td>
                        </tr>
                        @endif
                    </table>
                </div>

                {{-- <div class="border-t border-gray-300 pt-6 space-y-2">
                    <div class="flex flex-row justify-between items-center">
                        <div class="font-bold text-lg">Custom Attributes</div>
                        <div>
                            <x-jet-button wire:click="newAttribute">New</x-jet-button>
                            <x-jet-button wire:click="toggleChangeCategory">Change Category</x-jet-button>
                        </div>
                    </div>
                    
                    @if(count($selectedFile->attributes) > 0)
                        <table class="table-fixed">
                            @foreach($selectedFile->attributes as $index => $attribute)
                            <tr>
                                <td class="font-bold">{{ $attribute->attribute->name }}</td>
                                @if($editing)
                                <td><x-jet-input type="text" wire:model="attributes.{{ $index }}.value"/></td>
                                @else
                                <td>{{ $attribute->value }}</td>
                                @endif
                            </tr>
                            @endforeach
                        </table>
                    @else
                        <div class="flex flex-row items-center justify-center py-4 text-gray-500 text-center">
                            <div>There are no custom attributes for this file,<br> click the 'New' button above to add one</div>
                        </div>
                    @endif
                </div> --}}
            </div>
        </x-slot>

        <x-slot name="footer">
            <div class="flex flex-row justify-end items-center">
                <x-buttons.cancel-button wire:click="$set('showFileModal', false)">Close</x-buttons.cancel-button>
                <x-jet-button wire:click="save">Save</x-jet-button>
            </div>
        </x-slot>
    </x-jet-dialog-modal>

    <x-modal.dialog wire:model="showAttributeModal">
        <x-slot name="title">New Attribute</x-slot>

        <x-slot name="content">
            <div class="space-y-4">
                <div>
                    <x-jet-label for="attributeName" value="Attribute Name" />
                    <x-jet-input type="text" wire:model="newAttribute.attribute" />
                </div>

                <div>
                    <x-jet-label for="attributeValue" value="Attribute Value" />
                    <x-jet-input type="text" wire:model="newAttribute.value" />
                </div>
            </div>
        </x-slot>

        <x-slot name="footer">
            <div class="flex flex-row justify-end items-center">
                <x-buttons.cancel-button wire:click="closeAttributeModal">Cancel</x-buttons.cancel-button>
                <x-jet-button wire:click="createAttribute">Create</x-jet-button>
            </div>
        </x-slot>
    </x-modal.dialog>

    <x-jet-dialog-modal wire:model="showCategoryModal">
        <x-slot name="title">Choose Category</x-slot>

        <x-slot name="content">
            <x-select wire:model="activeCategory">
                <option value="">Select an option</option>
                @foreach($fileCategories as $cat)
                <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                @endforeach
            </x-select>
        </x-slot>

        <x-slot name="footer">
            <div class="flex flex-row justify-end items-center">
                <x-buttons.cancel-button wire:click="cancelCategory">Cancel</x-buttons.cancel-button>
                <x-jet-button wire:click="changeCategory">Save</x-jet-button>
            </div>
        </x-slot>
    </x-jet-dialog-modal>
</div>
