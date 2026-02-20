<div>
    {{-- <x-back link="/../resources/{{ $resourceCategory->id }}">{{ $resourceCategory->name }}</x-back> --}}

    <x-toast.success-event />

    <div class="flex justify-between items-center">
        <div class="flex flex-row gap-4 mb-4 mt-4">
            <div class="w-20 h-20 bg-amber-400 rounded-md text-white p-4">
                {!! isset($resourceCategory->icon->svg) ? $resourceCategory->icon->svg : '' !!}
            </div>
            <div class="flex flex-col justify-center gap-1">
                <h1 class="text-xl font-bold">{{ $resourceCategory->name }}</h1>
                <p class="text-gray-500 text-sm">{{ count($resourceCategory->resources) }} Resources</p>
            </div>
        </div>

        @can('delete knowledge-panel')
        <div>
            <x-buttons.delete-button wire:click="$set('showConfirmDeleteModal', true)">Delete</x-buttons.delete-button>
        </div>
        @endcan
    </div>

    <div class="grid grid-cols-[8fr_4fr] gap-4">
        <div>
            <div class="w-full bg-white p-8 flex flex-col gap-6 rounded-lg">
                <div class="flex flex-row justify-between items-center gap-4">
                    <div class="w-full">
                        @if ($editing)
                        <div>
                            <x-jet-input type="text" wire:model="resource.title" />
                            <x-validation-error field="resource.title" />
                        </div>
                        @else
                        <div>
                            <div class="text-blue-600 font-bold text-lg">{{ $resource->title }}</div>
                            <div class="text-sm text-gray-500">{{ $resource->created_at != $resource->updated_at ? 'Updated on ' . $resource->updated_at->format('d M Y, H:i') : '' }}</div>
                        </div>
                        @endif
                    </div>
                    @can('edit knowledge-panel')
                    <div class="flex flex-row gap-1 ">
                        @if($editing)
                        <x-button wire:click="update" wire:key="save-button">Save</x-button>
                        @endif
                        <x-button wire:click="$toggle('editing')" wire:key="edit-cancel-button">
                            {{ $editing ? 'Cancel' : 'Edit' }}
                        </x-button>
                    </div>
                    @endcan
                </div>

                <div class="break-all">
                    @if($editing)
                        <x-textarea wire:model="resource.content" rows="10" />
                        <x-validation-error field="resource.content" />
                    @else
                        <div>{!! nl2br($resource->content) !!}</div>
                    @endif
                </div>

                <div class="flex flex-row justify-between">
                    <div class="flex flex-row justify-start items-center gap-1">
                        <div class="text-sm font-bold bg-amber-500 text-white rounded-lg max-w-max px-4 py-1">Created by {{ isset($resource->user) ? $resource->user->name : 'Deleted user' }}</div>
                        <div class="text-sm text-gray-500">{{ $resource->created_at->format('Y/m/d') }}</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="w-full bg-white p-8 rounded-lg">
            <livewire:global-components.comment-section :entity="$resource" />
        </div>
    </div>

    {{-- MODALS --}} 
    <x-jet-confirmation-modal wire:model="showConfirmDeleteModal">
        <x-slot name="title">Delete Topic</x-slot>
        <x-slot name="content">
            <div>
                <div>Are you sure you would like to delete this topic?</div>
                <div class="text-sm text-red-500">This action is irreversible</div>
            </div>            
        </x-slot>
        <x-slot name="footer">
            <div class="flex flex-row justify-end items center gap-1">
                <x-buttons.cancel-button x-on:click="show = false">Cancel</x-buttons.cancel-button>
                <x-buttons.delete-button wire:click="deleteTopic">Delete</x-buttons.delete-button>
            </div>
        </x-slot>
    </x-jet-confirmation-modal>
    {{-- END MODALS --}}
</div>
