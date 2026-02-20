<div>
    <x-toast.success-event />

    {{-- <x-back>all Contacts</x-back> --}}

    <x-details>
        <x-slot name="initials">
            <div>{{ $this->generateInitials($contact->name) }}</div>
        </x-slot>

        <x-slot name="headerDetails">
            <div class="font-bold text-xl">{{ $contact->name }}</div>
            <div class="text-gray-500">{{ $contact->email }}</div>
            <div class="text-gray-500">{{ $contact->primary_phone }}</div>
        </x-slot>

        <x-slot name="headerButtons">
            <div class="flex items-center gap-1">
                @can('create users')
                    @if($contact->user_id === null)
                    <button 
                        wire:click="$set('showCreateUserModal', true)"
                        class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring focus:ring-gray-300 disabled:opacity-25 transition"
                        @if($contact->user_id !== null) disabled @endif
                        >
                        Convert to user
                    </button>
                    @else
                    <div>
                        <a href="../users/{{ $contact->user_id }}">
                            <x-jet-button>
                                Go to user profile
                            </x-jet-button>
                        </a>
                    </div>
                    @endif
                @endcan
                @can('edit contacts')
                @if($editing)
                <x-jet-button wire:key="saveContact" wire:click="update" class="bg-blue-500 hover:bg-blue-700 active:bg-blue-800">Save</x-jet-button>
                @endif
                <x-buttons.edit-button wire:click="setEdit">@if($editing) Cancel @else Edit @endif </x-buttons.edit-button>
                @endcan
                {{-- <x-buttons.mail-button>Email</x-buttons.mail-button> --}}
                @can('delete contacts')
                <x-buttons.delete-button wire:click="$set('showDeleteModal', true)">Delete</x-buttons.delete-button>
                @endcan
            </div>
        </x-slot>

        <x-slot name="tabs">
            @foreach ($tabs as $tab)
                <x-tabs.tab
                    :current="$currentTab === $tab ? true : false "
                    click="changeTab('{{ $tab }}')"
                    >
                    {{ ucfirst($tab) }}
                </x-tabs.tab>
            @endforeach
        </x-slot>

        @if($currentTab == 'overview')
            @section('fullWidth') 
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <div class="bg-white p-8 rounded-xl">
                        <table class="table-fixed">
                            <tr>
                                <td class="font-bold">Module</td>

                                @if($editing)
                                <td>
                                    <select wire:model="contact.contactable_type" class="disabled:bg-gray-100 disabled:text-gray-400 w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm">
                                        <option value="">Please select a module</option>
                                        @foreach ($contactableModules as $key => $value)
                                            <option value="{{ $key }}">{{ $value }}</option>
                                        @endforeach
                                    </select>
                                    <x-validation-error field="contact.contactable_type" />

                                    {{-- <x-select2-multiple wire:model="contact.contactable_type" wire:key="set-type" id="contact-type">
                                        <option value="">Please select a module</option>
                                        @foreach ($contactableModules as $key => $value)
                                        <option value="{{ $key }}">{{ $value }}</option>
                                        @endforeach
                                    </x-select2-multiple> --}}
                                </td>
                                @else
                                <td>
                                    @if(isset($contact->contactable))
                                        {{ isset($contact->contactable->displayName) ? $contact->contactable->displayName : class_basename($contact->contactable) }}
                                    @else
                                        <div class="text-gray-500">No Module Selected</div>
                                    @endif
                                </td>
                                @endif
                            </tr>

                            {{-- <tr>
                                <td class="font-bold">Record</td>

                                @if($editing)
                                <td>
                                    <select wire:model="contact.contactable_id">
                                        <option value="">Please select a record</option>
                                        @foreach ($contactableModules as $key => $value)
                                            <option value="{{ $key }}">{{ $value }}</option>
                                        @endforeach
                                    </select>
                                </td>
                                @else
                                <td>
                                    {{ isset($contact->contactable->displayName) ? $contact->contactable->displayName : class_basename($contact->contactable) }}
                                </td>
                                @endif
                            </tr> --}}

                            <tr>
                                <td class="font-bold">Record</td>
                                @if ($editing)
                                <td>
                                    {{-- <span>@error('contact.client_id') <span class="text-red-500">{{ $message }}</span> @enderror</span> --}}
                                    {{-- <x-select2-multiple wire:model.defer="contact.client_id" wire:key="set-client" id="client">
                                        <option value="">Select client</option>
                                        @foreach(App\Models\Clients::all() as $client)
                                        <option value="{{ $client->id }}">{{ $client->name }}</option>
                                        @endforeach
                                    </x-select2-multiple> --}}

                                    <select wire:model="contact.contactable_id" class="disabled:bg-gray-100 disabled:text-gray-400 w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm">
                                        <option value="">Please select a record</option>
                                        @foreach ($records as $record)
                                            <option value="{{ $record->id }}">{{ $record->name }}</option>
                                        @endforeach
                                    </select>
                                    <x-validation-error field="contact.contactable_id" />

                                    {{-- <x-select2-multiple wire:model="contact.contactable_id" wire:key="set-record" id="contact-id">
                                        <option value="">Please select a record</option>
                                        @foreach ($records as $record)
                                        <option value="{{ $record->id }}">{{ $record->name }}</option>
                                        @endforeach
                                    </x-select2-multiple> --}}
                                </td>    
                                @else
                                <td>
                                    {{-- <a href="../clients/{{ $contact->contactable->id }}" class="text-blue-600 hover:underline"> --}}
                                        {{ isset($contact->contactable->name) ? $contact->contactable->name : '' }}
                                    {{-- </a> --}}
                                </td>
                                @endif
                            </tr>
                            <tr>
                                <td class="font-bold">Name</td>
                                @if($editing)
                                <td>
                                    <x-jet-input type="text" wire:model.defer="contact.name" />
                                    <x-validation-error field="contact.name" />
                                </td>
                                @else
                                <td>{{ $contact->name }}</td>
                                @endif
                            </tr>

                            <tr>
                                <td class="font-bold">Job title</td>
                                @if($editing)
                                <td>
                                    <x-jet-input type="text" wire:model.defer="contact.jobtitle" />

                                </td>
                                @else
                                <td>{{ $contact->jobtitle }}</td>
                                @endif
                            </tr>

                            <tr>
                                <td class="font-bold">Category</td>
                                @if($editing)
                                <td>
                                    <x-jet-input type="text" wire:model.defer="contact.category" />

                                </td>
                                @else
                                <td>{{ $contact->category }}</td>
                                @endif
                            </tr>

                            <tr>
                                <td class="font-bold">Email</td>
                                @if($editing)
                                <td>
                                    <x-jet-input type="text" wire:model.defer="contact.email" />

                                </td>
                                @else
                                <td>{{ $contact->email }}</td>
                                @endif
                            </tr>

                            <tr>
                                <td class="font-bold">Phone Primary</td>
                                @if($editing)
                                <td>
                                    <x-jet-input type="text" wire:model.defer="contact.phone_primary" />

                                </td>
                                @else
                                <td>{{ $contact->phone_primary }}</td>
                                @endif
                            </tr>

                            <tr>
                                <td class="font-bold">Phone Secondary</td>
                                @if($editing)
                                <td>
                                    <x-jet-input type="text" wire:model.defer="contact.phone_secondary" />

                                </td>
                                @else
                                <td>{{ $contact->phone_secondary }}</td>
                                @endif
                            </tr>
                        </table>
                    </div>
                </div>

                @if (!$editing)
                <div class="p-6 rounded-xl bg-white">
                    <livewire:global-components.comment-section :entity="$contact" />
                </div>
                @endif
            </div>
            @endsection
        @endif

        @if($currentTab == 'files')
            @section('fullWidth')
                <div>
                    <livewire:global-components.files-section 
                        :entity="$contact" 
                        :model="'App\\Models\\Contact'" 
                        :filePath="'Contacts/' . $contact->name" 
                    />
                </div>
            @endsection
        @endif

        @if ($currentTab == 'activity')
            @section('fullWidth')
                <livewire:global-components.activity 
                    :model="'App\\Models\\Contact'"
                    entityID="{{ $contact->id }}"
                    :showPath="false" 
                />
            @endsection
        @endif
    </x-details>

    <div>
        <x-modal.confirmation wire:model="showDeleteModal">
            <x-slot name="title">Delete Contact</x-slot>
            <x-slot name="content">
                <div>
                    Are you sure you would like to delete this contact?
                </div>
            </x-slot>
            <x-slot name="footer">
                <div class="space-x-2 flex flex-row items-center justify-end">
                    <x-buttons.cancel-button wire:click.prevent="$set('showDeleteModal', false)">Cancel</x-buttons.cancel-button>
                    <x-buttons.delete-button wire:click="delete({{ $contact->id }})">Delete</x-buttons.delete-button>
                </div>
            </x-slot>
        </x-modal.confirmation>
    </div>

    <x-jet-dialog-modal wire:model="showCreateUserModal">
    <x-slot name="title">Create User</x-slot>

    <x-slot name="content">
        <table class="border-separate [border-spacing:0.8rem] w-full">
            <tr>
                <td class="w-1/2">
                    <x-jet-label for="name" value="Name" />
                    <x-jet-input
                        id="name"
                        type="text"
                        wire:model.defer="user.name"
                        class="w-full"
                    />
                    <x-validation-error field="user.name" />
                </td>
                <td class="w-1/2">
                    <x-jet-label for="email" value="Email" />
                    <x-jet-input
                        id="email"
                        type="text"
                        wire:model.defer="user.email"
                        class="w-full"
                    />
                    <x-validation-error field="user.email" />
                </td>
            </tr>
            <tr>
                <td class="w-1/2">
                    <x-jet-label for="password" value="Password" />
                    <x-jet-input
                        id="password"
                        type="password"
                        wire:model.defer="user.password"
                        class="w-full"
                    />
                    <x-validation-error field="user.password" />
                </td>
                <td class="w-1/2">
                    <x-jet-label for="client" value="Company" />
                    <select
                        id="client"
                        wire:model.defer="user.client_id"
                        class="w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
                    >
                        <option value="">Select a company</option>
                        @foreach($accessibleClients as $c)
                            <option
                                value="{{ $c->id }}"
                                @if($contact->client_id == $c->id) selected @endif
                            >
                                {{ $c->name }}
                            </option>
                        @endforeach
                    </select>
                    <x-validation-error field="user.client_id" />
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    {{-- fixed role --}}
                    <input
                        type="hidden"
                        wire:model="selectedRole"
                        value="{{ $clientSubUserRoleId }}"
                    />
                    <p class="mt-2 text-sm text-gray-600">
                        Role: <strong>Client Sub User</strong>
                    </p>
                </td>
            </tr>
        </table>
    </x-slot>

    <x-slot name="footer">
        <div class="flex justify-end items-center gap-1">
            <x-buttons.cancel-button
                wire:click="$set('showCreateUserModal', false)"
            >Cancel</x-buttons.cancel-button>
            
             <x-create-button 
     type="button"
     wire:click="createUser"
 >Create User</x-create-button>
        </div>
    </x-slot>
</x-jet-dialog-modal>

</div>
