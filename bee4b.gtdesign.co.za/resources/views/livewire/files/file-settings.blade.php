<div>
    <div class="font-bold text-xl">File Settings</div>

    {{-- <x-jet-button wire:click="test">Test</x-jet-button> --}}

    <div>
        <div class="font-bold text-lg">Files</div>
        @foreach($fileCategories as $category)
        <div wire:click="setActiveCategory({{ $category->id }})">{{ $category->name }}</div>
        @endforeach
        
        {{-- @foreach($files as $file)
        <div>
            <div wire:click="setActiveFile({{ $file->id }})">{{ $file->file_name }}</div>
        </div>
        @endforeach --}}

        {{-- <div class="font-bold text-lg">Categories</div>
        @foreach($fileCategories as $category)
        <div class="bg-white mb-4">
            <div class="cursor-pointer hover:underline" wire:click="setActiveCategory({{ $category->id }})">
                <span class="font-bold">Name: </span>{{ $category->name }}
            </div>
            @json($category->attributes);
        </div>
        @endforeach --}}
    </div>

    <x-jet-dialog-modal wire:model="showCreateAttributeModal">
        <x-slot name="title">Create Attribute</x-slot>

        <x-slot name="content">
            <div>
                <x-jet-label for="attributeName" value="Name" />
                <x-jet-input wire:model.defer="newAttribute.name" id="attributeName" type="text" />
            </div>
        </x-slot>

        <x-slot name="footer">
            <div>
                <x-jet-button wire:click="createAttribute">Create</x-jet-button>
            </div>
        </x-slot>
    </x-jet-dialog-modal>

    <x-jet-dialog-modal wire:model="showFileDetailsModal">
        <x-slot name="title">File Details</x-slot>

        <x-slot name="content">
            <table>
                @foreach($activeFile->attributes as $index => $attribute)
                <tr>
                    <td class="font-bold">{{ $attribute->attribute->name }}</td>
                    @if($editing)
                    <td><x-jet-input type="text" wire:model="attributes.{{ $index }}.value" /></td>
                    @else
                    <td><div>{{ $attribute->value }}</div></td>
                    @endif
                </tr>
                @endforeach
            </table>
            <x-jet-button wire:click="toggleChangeCategoryModal">Change Category</x-jet-button>
            {{-- <x-select wire:model="activeCategory">
                <option value="">Select an option</option>
                @foreach($fileCategories as $cat)
                <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                @endforeach
            </x-select> --}}
        </x-slot>

        <x-slot name="footer">
            <x-jet-button wire:click="save">Save</x-jet-button>
        </x-slot>
    </x-jet-dialog-modal>

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
            <x-jet-button wire:click="changeCategory">Save</x-jet-button>
        </x-slot>
    </x-jet-dialog-modal>

    <x-jet-dialog-modal wire:model="showCategoryDetailsModal">
        <x-slot name="title">
            <div class="flex flex-row justify-between">
                <div>Category Details</div>
                <x-jet-button wire:click="toggleCreateAttribute">Create Attribute</x-jet-button>
            </div>
        </x-slot>

        <x-slot name="content">
            <div class="font-bold">Category Attributes:</div>
            @foreach($activeCategory->attributes as $attr)
            <div>{{ $attr->name }}</div>
            @endforeach
        </x-slot>
        
        <x-slot name="footer"></x-slot>
    </x-jet-dialog-modal>

    {{-- <x-modal.dialog wire:model="showCreateAttributeModal">
        <x-slot name="title">New Attribute</x-slot>

        <x-slot name="content">
            <div class="space-y-4">
                <div>
                    <x-jet-label for="attributeName" value="Attribute Name" />
                    <x-jet-input type="text" wire:model="newAttribute.attribute" />
                </div>
            </div>
        </x-slot>

        <x-slot name="footer">
            <div class="flex flex-row justify-end items-center">
                <x-buttons.cancel-button wire:click="closeAttributeModal">Cancel</x-buttons.cancel-button>
                <x-jet-button wire:click="createAttribute">Create</x-jet-button>
            </div>
        </x-slot>
    </x-modal.dialog> --}}
</div>
