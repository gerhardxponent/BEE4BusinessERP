<div>
    <x-jet-dialog-modal wire:model="showFileDetailsModal">
        <x-slot name="title">
            <div class="space-x-4 flex items-center flex-row justify-between">
                <span class="font-bold text-xl">{{ $selectedFile->file_name }}</span>
                @if($editFile)
                <div class="flex flex-row justify-end items-center gap-1">
                    <x-buttons.cancel-button wire:click="toggleFileEdit">Cancel</x-buttons.cancel-button>
                    <x-buttons.save-button wire:click="updateFile">Save</x-buttons.save-button>
                </div>
                @else
                <div class="flex flex-row justify-end items-center gap-1">
                    <a href="../file-viewer/{{ $selectedFile->id }}" target="_blank">
                        <x-button>
                            <div class="flex gap-1 items-center justify-center">
                                <x-icons.eye size="20" />
                                <div>View</div>
                            </div>
                        </x-button>
                    </a>
                    <x-buttons.edit-button wire:click="toggleFileEdit">Edit</x-button.edit-button>
                    <x-buttons.delete-button wire:click="confirmDeleteFile">Delete</x-buttons.delete-button>
                </div>
                @endif
            </div>
        </x-slot>

        <x-slot name="content">
            <table class="table-fixed border-separate [border-spacing:0.75rem]">
                <tr>
                    <td class="align-top"><span class="font-bold">File Name</span></td>
                    @if($editFile)
                    <td>
                        <x-jet-input wire:model.delay="selectedFile.file_name" type="text" />
                        <x-validation-error field="selectedFile.file_name" />
                    </td>
                    @else
                    <td>{{ $selectedFile->file_name }}</td>
                    @endif
                </tr>
                <tr>
                    <td class="align-top"><span class="font-bold">Uploaded By</span></td>
                    <td>
                        @isset($selectedFile->file_name)
                            @can('view users')
                            <a class="table-link" href="../users/{{ $selectedFile->user()->first()->id }}">{{ $selectedFile->user()->first()->name }}</a>
                            @else
                            <span>{{ $selectedFile->user()->first()->name }}</span>
                            @endcan
                        @endisset
                    </td>
                </tr>
                <tr>
                    <td class="align-top"><span class="font-bold">File Type</span></td>
                    <td>{{ $selectedFile->type }}</td>
                </tr>
                <tr>
                    <td class="align-top"><span class="font-bold">File Size</span></td>
                    <td>{{ $selectedFile->file_size }} KB</td>
                </tr>
                <tr>
                    <td class="align-top"><span class="font-bold">Client Comments</span></td>
                    @if($editFile)
                    <td>
                        <x-textarea wire:model.delay="selectedFile.client_comments" rows="4"></x-textarea>
                    </td>
                    @else
                    <td>{{ $selectedFile->client_comments }}</td>
                    @endif
                </tr>
                <tr>
                    <td class="align-top"><span class="font-bold">Reviewer Comments</span></td>
                    @if($editFile)
                    <td>
                        <x-textarea wire:model.delay="selectedFile.reviewer_comments" rows="4"></x-textarea>
                    </td>
                    @else
                    <td>{{ $selectedFile->reviewer_comments }}</td>
                    @endif
                </tr>
                <tr>
                    <td class="align-top"><span class="font-bold">Status</span></td>
                    @if($editFile)
                    <td>
                        <x-jet-input wire:model.delay="selectedFile.status" type="text" />
                    </td>
                    @else
                    <td>{{ $selectedFile->status }}</td>
                    @endif
                </tr>
            </table>
            {{-- <a href="./file-viewer/{{ $selectedFile->id }}">View file</a> --}}
        </x-slot>

        <x-slot name="footer">
            <div class="space-x-2 flex flex-row items-center justify-end">
                <x-jet-button wire:click="$set('showFileDetailsModal', false)" class="bg-transparent hover:bg-transparent active:bg-transparent">
                    <span class="font-bold text-gray-800">Close</span>
                </x-jet-button>
                <x-jet-button class="space-x-1" wire:click="downloadSelected">
                    <x-icons.download />
                    <span>Download</span>
                </x-jet-button>
            </div>
        </x-slot>
    </x-jet-dialog-modal>

    <x-jet-confirmation-modal wire:model="showConfirmDeleteFileModal">
        <x-slot name="title">Delete file</x-slot>
        <x-slot name="content">
            <div>
                <div>Are you sure you would like to delete this file?</div>
                <div class="text-gray-500">This action is irreversible</div>
            </div>
        </x-slot>
        <x-slot name="footer">
            <div class="flex justify-end items-center gap-1">
                <x-buttons.cancel-button x-on:click="show = false">Cancel</x-buttons.cancel-button>
                <x-buttons.delete-button wire:click="deleteFile">Delete</x-buttons.delete-button>
            </div>
        </x-slot>
    </x-jet-confirmation-modal>

    <x-jet-confirmation-modal wire:model="showFileNotFoundModal">
        <x-slot name="title">Error</x-slot>
        <x-slot name="content">The selected file could not be found</x-slot>
        <x-slot name="footer">
            <x-buttons.cancel-button x-on:click="show = false">Close</x-buttons.cancel-button>
        </x-slot>
    </x-jet-confirmation-modal>
</div>
