<div class="relative">

    {{-- Notifications --}}
    <div class="fixed z-50 top-20 right-5 space-y-4">
        @if (session()->has('message'))
        <x-toast.success message="{{ session('message') }}" />
        @endif

        @if(session()->has('error_flash'))
        <x-toast.success message="{{ session('error_flash') }}" />
        @endif
    </div>
    {{-- End notifications --}}

    {{-- <div class="sential w-full opacity-0 h-0"></div> --}}
    {{-- <div class="back-header mb-6 sticky top-0 left-0 z-[999] p-4 shadow-md transition-all"> --}}
        {{-- <x-back>all Clients</x-back> --}}
    {{-- </div> --}}

    <div>
        <x-details>
            <x-slot name="initials">{{ $this->generateInitials($client->name) }}</x-slot>

            <x-slot name="headerDetails">
                <div class="font-bold text-xl">{{ $client->name }}</div>
                <div class="text-gray-600">{{ $client->email }}</div>
                <div class="text-gray-600">{{ $client->phone }}</div>
            </x-slot>

            <x-slot name="headerButtons">
                @if($currentUser->hasRole('Client') || $currentUser->hasRole('Client Sub User') || $currentUser->can('edit clients'))
                    @if($currentTab === 'overview' && !$editing)
                        <x-buttons.upload wire:click="toggleCertModal">Upload certificate</x-buttons.upload>
                    @endif
                    @if($editing)
                        <x-jet-button wire:key="saveClient" wire:click="update" class="bg-blue-500 hover:bg-blue-700 active:bg-blue-800">Save</x-jet-button>
                    @endif
                    @if($currentTab == 'overview')
                        <x-buttons.edit-button wire:click="setEdit" wire:key="editButton">@if($editing) Cancel @else Edit @endif</x-buttons.edit-button>
                    @endif
                @endcan
                <x-buttons.icon wire:click="$set('showEmailModal', true)" colour="sky">
                    <x-icons.mail-solid size="30" />
                </x-buttons.icon>
                @can('delete clients')
                @if($currentTab === 'overview')
                <x-buttons.icon wire:click="$set('showDeleteModal', true)" colour="red">
                    <x-icons.bin-solid size="30" />
                </x-buttons.icon>
                @endif
                {{-- <x-buttons.flat colour="red">
                    <x-slot name="icon">
                        <x-icons.bin />
                    </x-slot>
                    Delete
                </x-buttons.flat> --}}
                @endcan

                <div class="hidden">
                    <div class="bg-red-50"></div>
                    <div class="bg-red-100"></div>
                    <div class="bg-red-200"></div>
                    <div class="text-sky-600 active:bg-sky-200 hover:bg-sky-100"></div>
                </div>
            </x-slot>

            {{-- <x-slot name="sential">
                <div class="w-20 h-0 bg-red-500 sential"></div>
            </x-slot> --}}

            <x-slot name="tabs">
                @foreach ($tabs as $tab)
                <x-tabs.tab 
                    click="changeTab('{{ $tab }}')" 
                    :current="$currentTab === $tab ? true : false"
                    >
                    {{ ucfirst($tab) }}
                </x-tabs.tab>
                @endforeach
            </x-slot>

            @if($currentTab == 'projects')
                @section('fullWidth')
                    <div wire:loading.class="opacity-50 transition-opacity">
                        {{-- @if($showTaskSettings)
                        <livewire:settings.components.projects />
                        @else --}}
                        <livewire:clients.components.projects clientID="{{ $client->id }}" />
                        {{-- @endif --}}
                    </div>
                @endsection
            @endif

            @if($currentTab == 'overview')
                @section('fullWidth')
                <div wire:loading.class="opacity-50 transition-opacity">
                    <livewire:clients.components.overview clientID="{{  $client->id }}" />
                </div>
                @endsection
            @endif

            @if ($currentTab == 'procurement')
                @section('fullWidth')
                    <div>
                        <x-create-button wire:click="$emit('showCreateProcurementModal')">
                            Create
                        </x-create-button>
                        
                        <livewire:procurement.procurement-table :clientId="$client->id" />
                        <livewire:procurement.create-procurement />  
                    </div>
                @endsection
            @endif

            @can('view contacts')
            @if($currentTab == 'contacts')
                @section('fullWidth')
                <div>
                    <x-button wire:click="$emit('toggleCreateContactModal')">
                        <div class="flex items-center gap-1">
                            <x-icons.plus size="20" />
                            <div>New Contact</div>
                        </div>
                    </x-button>
                </div>

                <div wire:loading.class="opacity-50 transition-opacity">
                    <livewire:clients.client-contacts-table client="{{ $client->id }}"/>
                </div>

                <livewire:contacts.create-contact :client="$client->id" />
                @endsection
            @endif
            @endcan

            @can('view quotes')
            @if($currentTab == 'quotes')
                @section('fullWidth')
                <div wire:loading.class="opacity-50 transition-opacity">
                    <livewire:clients.client-quotes-table client="{{ $client->id }}" />
                </div>
                @endsection
            @endif
            @endcan

            {{-- @if($currentTab == 'invoices')
                @section('fullWidth')
                <div wire:loading.class="opacity-50 transition-opacity"></div>
                @endsection
            @endif --}}

            @can('view consultations')
            @if($currentTab == 'consultations')
                @section('fullWidth')
                <div wire:loading.class="opacity-50 transition-opacity">
                    <livewire:clients.client-consultations-table client="{{ $client->id }}" />
                </div>
                @endsection
            @endif
            @endcan

            @if($currentTab == 'files')
                @section('fullWidth')
                    <livewire:global-components.files-section 
                        :entity="$client" 
                        :model="'App\\Models\\Clients'" 
                        :filePath="'Clients/' . $client->name" 
                    />
                @endsection
            @endif 

            @if($currentTab == 'OneDrive')
                @section('fullWidth')
                    <div wire:loading.class="opacity-50 transition-opacity">
                        @if($client->onedrive_folder == null)
                            <form>
                                <div>
                                    <label for="folderName">Folder Name</label>
                                    <select id="folderName" wire:model="selectedOdFolder">
                                        <option value="">Select a folder</option>
                                        @foreach($this->clientList as $odClient)
                                            <option value="{{ $odClient->getName() }}">{{ $odClient->getName() }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div>
                                    <x-jet-button wire:click.prevent="linkFolder">Link</x-jet-button>
                                </div>
                            </form>
                        @else
                            <div class="space-y-6">
                                {{-- Back and new buttons --}}
                                <div class="flex flex-row ">
                                    <form id="oneDriveFileForm" class="mb-2 space-y-2">
                                        <input wire:model="oneDriveFile" type="file" name="oneDriveFile" id="oneDriveFile" style="display:none;"/>
                                    </form>

                                    <div class="flex flex-row items-center justify-between w-full space-x-2">
                                        {{-- Back button and loading animation --}}
                                        <div class="flex flex-row space-x-2">
                                            <button 
                                                wire:click="previousDir"
                                                @if(count($curDir) == 1) disabled  @endif
                                                class="
                                                    od-button
                                                    flex flex-row items-center rounded-md border border-gray-300 shadow-sm px-4 py-2 text-sm font-medium focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-100 focus:ring-indigo-500
                                                    @if(count($curDir) == 1) bg-slate-100 text-gray-400 cursor-not-allowed @else text-gray-700 bg-white cursor-pointer hover:bg-gray-50 @endif"
                                                >
                                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-chevron-left" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                    <polyline points="15 6 9 12 15 18"></polyline>
                                                </svg>
                                                <span class="font-bold">Back</span>
                                            </button>
                                        </div>
                                        {{-- End back button and loading animation --}}

                                        {{-- Loading animation --}}
                                        {{-- <div class="lds-ellipsis"><div></div><div></div><div></div><div></div></div> --}}

                                        {{-- New File/Folder dropdown --}}
                                        <x-jet-dropdown align="right" triggerClasses="w-full rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-100 focus:ring-indigo-500 cursor-pointer">
                                            <x-slot name="trigger">
                                                <div class="flex justify-center items-center space-x">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-plus" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                        <line x1="12" y1="5" x2="12" y2="19"></line>
                                                        <line x1="5" y1="12" x2="19" y2="12"></line>
                                                    </svg>
                                                    <span class="font-bold">New</span>
                                                </div>
                                            </x-slot>
                                            <x-slot name="content">
                                                <x-jet-dropdown-link>
                                                    <div id="upload-button" class="flex justify-start items-center space-x-2">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-file-upload" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                            <path d="M14 3v4a1 1 0 0 0 1 1h4"></path>
                                                            <path d="M17 21h-10a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h7l5 5v11a2 2 0 0 1 -2 2z"></path>
                                                            <path d="M12 11v6"></path>
                                                            <path d="M9.5 13.5l2.5 -2.5l2.5 2.5"></path>
                                                        </svg>
                                                        <span class="font-bold">Upload File</span>
                                                    </div>
                                                </x-jet-dropdown-link>
                                                <x-jet-dropdown-link class="od-button">
                                                    <div class="flex justify-start items-center space-x-2">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-folder-plus" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                            <path d="M5 4h4l3 3h7a2 2 0 0 1 2 2v8a2 2 0 0 1 -2 2h-14a2 2 0 0 1 -2 -2v-11a2 2 0 0 1 2 -2"></path>
                                                            <line x1="12" y1="10" x2="12" y2="16"></line>
                                                            <line x1="9" y1="13" x2="15" y2="13"></line>
                                                        </svg>
                                                        <span class="font-bold" wire:click="$set('oneDriveNewFolder', true)">Create Folder</span>
                                                    </div>
                                                </x-jet-dropdown-link>
                                            </x-slot>
                                        </x-jet-dropdown>
                                        {{-- End new File/Folder dropdown --}}
                                    </div>
                                </div>
                                {{-- End back and new buttons --}}

                                <x-input.filepond wire:model="oneDriveFile" multiple key="od_files" />

                                {{-- OneDrive breadcrumbs --}}
                                <div class="flex flex-row justify-center">
                                    @foreach($curDir as $index => $dir)
                                    <span class="flex flex-row items-center justify-start">
                                        @if($index != 0)
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-chevron-right" width="18" height="18" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                            <polyline points="9 6 15 12 9 18"></polyline>
                                        </svg>
                                        @endif

                                        @if($index != count($curDir)-1)
                                        <span 
                                            wire:key="{{$index}}" 
                                            wire:click="navigateTo('{{$index}}')"
                                            class="od-button text-blue-600 cursor-pointer text-lg"
                                            >
                                            {{ $dir }}
                                        </span>
                                        @else
                                        <span class="font-bold text-lg">{{ $dir }}</span>
                                        @endif
                                    </span>
                                    @endforeach 
                                </div>
                                {{-- End OneDrive breadcrumbs --}}

                                {{-- Files table --}}
                                <div class="bg-white p-4 rounded-xl transition-opacity" wire:loading.class="opacity-50">
                                    <table class="table table-auto">
                                        <thead class="border-solid border-b border-slate-200 ">
                                            <th class="text-left py-3 text-base" style="text-transform: capitalize;">Name</th>
                                            <th class="text-left py-3 text-base" style="text-transform: capitalize;">Size (KB)</th>
                                            <th class="text-left py-3 text-base" style="text-transform: capitalize;">Created On</th>
                                            <th class="text-left py-3 text-base" style="text-transform: capitalize;">Created By</th>
                                        </thead>
                                        <tbody>
                                        @foreach($this->odFiles as $file)
                                            {{-- FILE --}}
                                            @if(isset($file->getProperties()['@microsoft.graph.downloadUrl']))
                                                <tr>
                                                    <td>
                                                        <a href="{{ $file->getProperties()['@microsoft.graph.downloadUrl'] }}" class="flex flex-row items-center py-2 space-x-2">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-file" width="50" height="50" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                                <desc>Download more icon variants from https://tabler-icons.io/i/file</desc>
                                                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                                <path d="M14 3v4a1 1 0 0 0 1 1h4"></path>
                                                                <path d="M17 21h-10a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h7l5 5v11a2 2 0 0 1 -2 2z"></path>
                                                            </svg>
                                                            <span>{{ $file->getName() }}</span>
                                                        </a>
                                                    </td>
                                                    <td>
                                                        <a href="{{ $file->getProperties()['@microsoft.graph.downloadUrl'] }}">
                                                            <span>{{ round($file->getSize() / 1024, 2) }}</span>
                                                        </a>
                                                    </td>
                                                    <td>
                                                        <a href="{{ $file->getProperties()['@microsoft.graph.downloadUrl'] }}">
                                                            <span>{{ $file->getCreatedDateTime()->format('d-m-Y') }}</span>
                                                        </a>
                                                    </td>
                                                    <td>
                                                        <a href="{{ $file->getProperties()['@microsoft.graph.downloadUrl'] }}">
                                                            <span>{{ $file->getCreatedBy()->getUser()->getDisplayName() }}</span>
                                                        </a>
                                                    </td>
                                                </tr>
                                            {{-- FOLDER --}}
                                            @else
                                                <tr>
                                                    <td>
                                                        <span class="od-button cursor-pointer flex flex-row items-center py-2 space-x-2" wire:click="enterFolder('{{ $file->getName() }}')">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-folder" width="50" height="50" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                                <path d="M5 4h4l3 3h7a2 2 0 0 1 2 2v8a2 2 0 0 1 -2 2h-14a2 2 0 0 1 -2 -2v-11a2 2 0 0 1 2 -2"></path>
                                                            </svg>
                                                        <span>{{ $file->getName() }}</span>
                                                    </span>
                                                    </td>
                                                    <td>
                                                        <span>{{ round($file->getSize() / 1024, 2) }}</span>
                                                    </td>
                                                    <td>
                                                        <span>{{ $file->getCreatedDateTime()->format('d-m-Y') }}</span>
                                                    </td>
                                                    <td>
                                                        <span>{{ $file->getCreatedBy()->getUser()->getDisplayName() }}</span>
                                                    </td>
                                                </tr>
                                            @endif
                                        @endforeach

                                        {{-- <script>
                                            const odButtons = document.querySelectorAll('.od-button');
                                            odButtons.forEach(folder => {
                                                folder.addEventListener('click', function() {
                                                    document.querySelector('.lds-ellipsis').style.display = "inline-block";
                                                });
                                            });
                                        </script> --}}
                                        </tbody>
                                    </table>
                                </div>
                                {{-- End files table --}}
                            </div>
                        @endif
                        <script>
                            //opens file dialog on upload button click
                            if(document.getElementById('upload-button')) {
                                document.getElementById('upload-button').addEventListener('click', () => {
                                    document.getElementById('oneDriveFile').click();
                                    // uploading.style.display = 'block';
                                });
                            }
                        </script>
                    </div>
                @endsection
            @endif

            @if($currentTab == 'activity')
                @section('fullWidth')
                <div wire:loading.class="opacity-50 transition-opacity">
                    {{-- <livewire:clients.components.activity clientID="{{ $this->client->id }}" /> --}}
                    <livewire:global-components.activity 
                        :activities="$client->activities()->with('user')->paginate(5)" 
                        :showPath="true"
                        :model="'App\\Models\\Clients'"
                        entityID="{{ $client->id }}"
                    />
                </div>
                @endsection
            @endif

            @can('view audits')
            @if($currentTab == 'audits')
                @section('fullWidth')
                <div wire:loading.class="opacity-50 transition-opacity">
                    <div>
                        <div class="flex justify-between items-center">
                            <x-tabs.tab-layout>
                                @foreach ($clientAudits as $audit)
                                    <x-tabs.tab 
                                        click="changeAudit('{{ $audit->id }}')" 
                                        :current="$currentAuditID == $audit->id ? true : false"
                                        >
                                        {{ ucfirst($audit->name) }}
                                    </x-tabs.tab>
                                @endforeach
                            </x-tabs.tab-layout>

                            <div>
                                @can('create audits')
                                <x-jet-button wire:click="createAudit">Create Audit</x-jet-button>
                                @endcan
                            </div>
                        </div>
                    </div>
                    @if($currentAuditID)
                    <livewire:audit-management.components.audit-section key="audit-{{ $currentAuditID }}" id="{{ $currentAuditID }}" />
                    @endif
                </div>
                @endsection
            @endif 
            @endcan
        </x-details>
    </div>

    {{-- MODALS --}}
        {{-- Delete Modal --}}
        <div>
            <x-modal.confirmation wire:model="showDeleteModal">
                <x-slot name="title">Delete Client</x-slot>
                <x-slot name="content">
                    <div>
                        Are you sure you would like to delete this client?
                    </div>
                </x-slot>
                <x-slot name="footer">
                    <div class="space-x-2 flex flex-row items-center justify-end">
                        <x-buttons.cancel-button wire:click.prevent="$set('showDeleteModal', false)">Cancel</x-buttons.cancel-button>
                        <x-buttons.delete-button wire:click="delete({{ $client->id }})">Delete</x-buttons.delete-button>
                    </div>
                </x-slot>
            </x-modal.confirmation>
        </div>
        
        {{-- Outlook email modal --}}
        <x-modal.dialog wire:model="showEmailModal">
            <x-slot name="title">
                <div>New Email</div>
                <div class="text-base text-slate-400">From: {{ $msEmail }}</div>
            </x-slot>

            <x-slot name="content">
                <div class="space-y-4">
                    <div>
                        <x-jet-label for="toAddress" value="To"/>
                        <x-jet-input id="toAddress" type="text"  wire:model.defer="emailData.recipient"/>
                    </div>
                    <div>
                        <x-jet-label for="emailSubject" value="Subject" />
                        <x-jet-input id="emailSubject" type="text"  wire:model.defer="emailData.subject"/>
                    </div>
                    <div>
                        <x-jet-label for="emailBody" value="Body" />
                        <x-textarea 
                            id="emailBody"
                            wire:model.defer="emailData.body"
                            class="w-full preserveLines"
                            rows="8"
                            >
                        </x-textarea>
                    </div>
                    @if(count($attachments) > 0)
                    <div>
                        <x-jet-label for="attachments" value="attachments" />
                        <div id="attachments" class="space-y-2">
                            @foreach($attachments as $id => $attachment) 
                            <div class="flex flex-row items-center space-x-1">
                                <span class="cursor-pointer" wire:click="removeAttachment({{ $id }})">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-x" width="20" height="20" viewBox="0 0 24 24" stroke-width="2" stroke="#e11d48" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                        <line x1="18" y1="6" x2="6" y2="18"></line>
                                        <line x1="6" y1="6" x2="18" y2="18"></line>
                                    </svg>
                                </span>
                                <span>{{ $attachment['Name'] }}</span>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endif
                </div>
            </x-slot>

            <x-slot name="footer">
                <div class="flex flex-row justify-end items-center space-x-2">
                    {{-- <button wire:click="$toggle('sending')">TEST</button> --}}
                    <x-buttons.cancel-button wire:click="closeEmailModal">Cancel</x-buttons.cancel-button>
                    <x-buttons.send wire:click="sendOutlook" id="send-button" wire:loading.attr="disabled">Send</x-buttons.send>
                </div>
            </x-slot>
        </x-modal.dialog>

        {{-- Upload certificate modal --}}
        <x-modal.dialog wire:model="showCertUploadModal">
            <x-slot name="title">
                Upload Certificate
            </x-slot>

            <x-slot name="content">
                <div class="space-y-2">
                    <table>
                        <tr>
                            <td class="font-bold">File</td>
                            <td>
                                <input type="file" name="cert_file" id="cert_file" wire:model="cert_file" >
                                {{-- <input type="file" wire:model="cert_file"/> --}}
                            </td>
                        </tr>
                        <tr>
                            <td class="font-bold">File name</td>
                            <td><x-jet-input type="text" wire:model="cert_name" /></td>
                        </tr>
                        <tr>
                            <td class="font-bold">Enter expiry date</td>
                            <td><x-jet-input type="date" wire:model="cert_exp_date" /></td>
                        </tr>
                    </table>

                    <div class="space-y-2">
                        <div class="font-bold">Enter comments</div>
                        <x-textarea class="w-full" rows="6" wire:model.lazy="cert_comments"></x-textarea>
                    </div>
                </div>
            </x-slot>

            <x-slot name="footer">
                <x-buttons.cancel-button wire:click="$toggle('showCertUploadModal')">Cancel</x-buttons.cancel-button>
                <x-buttons.upload wire:click="uploadCertERP">Upload to ERP</x-buttons.upload>
            </x-slot>
        </x-modal.dialog>

        {{-- New OneDrive folder modal --}}
        <form>
            <x-modal.dialog wire:model="oneDriveNewFolder" max-width="sm">
                <x-slot name="title">
                    Create Folder
                </x-slot>
                <x-slot name="content">
                    <div>
                        <x-jet-label for="newFolderName" value="Name" />
                        <span>@error('newFolderName') <span class="text-red-500 text-sm error">Please enter the new folder name</span> @enderror</span>
                        <x-jet-input wire:model="newFolderName" id="newFolderName" type="text" class="w-full"/>
                    </div>
                </x-slot>
                <x-slot name="footer">
                    <div class="flex flex-row justify-end items-center">
                        <x-buttons.cancel-button wire:click.prevent="$set('oneDriveNewFolder', false)">Cancel</x-buttons.cancel-button>
                        <button 
                            class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring focus:ring-gray-300 disabled:opacity-25 transition" 
                            wire:click.prevent="createFolder" 
                            >
                            Create
                        </button>
                    </div>
                </x-slot>
            </x-modal.dialog>
        </form>
    {{-- END MODALS --}}

    {{-- <script>
        const headerEl = document.querySelector('.back-header');
        const sentialEl = document.querySelector('.sential');
        const backTitle = document.querySelector('.back-title');

        const handler = (entries) => {
            if (!entries[0].isIntersecting) {
                headerEl.classList.add('bg-white', 'shadow-md');
                backTitle.classList.remove('hidden');
            } else {
                headerEl.classList.remove('bg-white', 'shadow-md');
                backTitle.classList.add('hidden')
            }
        }

        const observer = new window.IntersectionObserver(handler);
        observer.observe(sentialEl);
    </script> --}}

    <div class="border-y hidden"></div>
</div>
