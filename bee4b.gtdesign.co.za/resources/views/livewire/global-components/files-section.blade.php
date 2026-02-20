<div wire:loading.class="opacity-50 transition-opacity" wire:target="changeTab">
    <x-input.filepond wire:model="files" multiple key="fp_files" />

    <div class="w-full flex flex-row justify-center">
        <button
            wire:click="upload"
            @if(!$enableUpload || count($files) == 0) disabled @endif
            class="flex flex-row space-x-1 items-center px-4 py-2 bg-primary-normal hover:bg-primary-light active:bg-primary-dark border border-transparent rounded-md font-bold text-xs text-white uppercase tracking-widest focus:outline-none focus:border-gray-900 focus:ring focus:ring-gray-300 disabled:opacity-25 transition"
            >
            <x-icons.file-upload />
            <span>Upload Files</span>
        </button>
    </div>

    {{-- Files Table --}}
    <div class="mt-2">
        {{-- <livewire:clients.client-files-table client="{{ $client->id }}"/> --}}
        <livewire:global-components.global-files-table :entity="$entity" />
    </div>

    <livewire:global-components.file-details-modal />

    {{-- File details modal --}}
    {{-- <div>
        <x-modal.dialog wire:model="showFileDetailsModal">
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
                            <span>@error('selectedFile.file_name') <span class="text-red-500">{{ $message }}</span> @enderror</span>
                            <x-jet-input wire:model.delay="selectedFile.file_name" type="text" />
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
                            <span>@error('selectedFile.client_comments') <span class="text-red-500">{{ $message }}</span> @enderror</span>
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
                            <span>@error('selectedFile.reviewer_comments') <span class="text-red-500">{{ $message }}</span> @enderror</span>
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
                            <span>@error('selectedFile.status') <span class="text-red-500">{{ $message }}</span> @enderror</span>
                            <x-jet-input wire:model.delay="selectedFile.status" type="text" />
                        </td>
                        @else
                        <td>{{ $selectedFile->status }}</td>
                        @endif
                    </tr>
                </table>
            </x-slot>

            <x-slot name="footer">
                <div class="space-x-2 flex flex-row items-center justify-end">
                    <x-jet-button wire:click="$set('showFileDetailsModal', false)" class="bg-transparent hover:bg-transparent active:bg-transparent">
                        <span class="font-bold text-gray-800">Close</span>
                    </x-jet-button>
                    <x-jet-button class="space-x-1" wire:click="downloadSelected">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-download w-4 h-4" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <desc>Download more icon variants from https://tabler-icons.io/i/download</desc>
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                            <path d="M4 17v2a2 2 0 0 0 2 2h12a2 2 0 0 0 2 -2v-2"></path>
                            <polyline points="7 11 12 16 17 11"></polyline>
                            <line x1="12" y1="4" x2="12" y2="16"></line>
                        </svg>
                        <span>Download</span>
                    </x-jet-button>
                </div>
            </x-slot>
        </x-modal.dialog>
    </div> --}}

    {{-- Confirm delete file modal --}}
    {{-- <x-jet-confirmation-modal wire:model="showConfirmDeleteFileModal">
        <x-slot name="title">Delete File</x-slot>
        <x-slot name="content">
            <div>
                Are you sure you would like to delete this file?
            </div>
            <div class="text-red-500 text-sm">
                This action is irreversible
            </div>
        </x-slot>
        <x-slot name="footer">
            <div class="flex items center gap-1">
                <x-buttons.cancel-button x-on:click="show = false;">Cancel</x-buttons.cancel-button>
                <x-buttons.delete-button wire:click="deleteFile">Delete</x-buttons.delete-button>
            </div>
        </x-slot>
    </x-jet-confirmation-modal> --}}
</div>