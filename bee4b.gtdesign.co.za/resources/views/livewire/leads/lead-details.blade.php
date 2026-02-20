<div class="relative">
    {{-- Notifications --}}
        <x-toast.success-event />
    {{-- End notifications --}}

    <div class="space-y-6">
        <x-details>
            <x-slot name="initials">
                <div wire:ignore>
                    {{ $this->generateInitials() }}
                </div>
            </x-slot>

            <x-slot name="headerDetails">
                <div class="font-bold text-xl flex gap-1 items-center">
                    @switch($lead->lead_status_id)
                        @case(1)
                            <div wire:click="$emit('changeLeadStatus')" class="cursor-pointer rounded-full w-6 h-6 bg-green-500 border-2 border-gray-300"></div>
                            @break
                        @case(2)
                            <div wire:click="$emit('changeLeadStatus')" class="cursor-pointer rounded-full w-6 h-6 bg-amber-500 border-2 border-gray-300"></div>
                            @break
                        @case(3)
                            <div wire:click="$emit('changeLeadStatus')" class="cursor-pointer rounded-full w-6 h-6 bg-red-500 border-2 border-gray-300"></div>
                            @break
                        @default
                            <div wire:click="$emit('changeLeadStatus')" class="cursor-pointer rounded-full w-6 h-6 bg-white border-2 border-gray-300"></div>                            
                    @endswitch
                    <div>{{ $lead->name }}</div>
                </div>
                <div class="text-gray-600">{{ $lead->email_address }}</div>
                <div class="text-gray-600">{{ $lead->primary_phone }}</div>
            </x-slot>
    
            <x-slot name="headerButtons">
                @if(!$editing)
                    {{-- <x-jet-button wire:click="sendOutlookEmail">Send intro email</x-jet-button> --}}
                    @if (isset($lead->client) || isset($lead->contact))
                        @if(isset($lead->client))
                            <a href="../clients/{{ $lead->client->id }}">
                                <x-jet-button>Go to client</x-jet-button>
                            </a>
                        @else
                            <x-jet-button wire:click="createClient">Create client</x-jet-button>
                        @endif

                        @if(isset($lead->contact))
                        <a href="../contacts/{{ $lead->contact->id }}">
                            <x-jet-button>Go to contact</x-jet-button>
                        </a>
                        @else
                        <x-jet-button wire:click="createContact">Create contact</x-jet-button>
                        @endif
                    @else
                        <x-jet-button wire:click="convertLead">Convert Lead</x-jet-button>
                    @endif
                @endif
                {{-- <x-jet-button wire:click="toggleEdit">@if($editing) Cancel @else Edit @endif</x-jet-button> --}}
                @if (!$editing)
                <x-buttons.icon wire:click="$set('showEmailApplicationModal', true)" colour="green">
                    <x-icons.mail-solid size="40" />
                </x-buttons.icon>

                <x-jet-dialog-modal wire:model="showEmailApplicationModal">
                    <x-slot name="title">Send Application Form</x-slot>

                    <x-slot name="content">
                        <div>
                            <x-jet-label for="emailTo" value="To" />
                            <x-jet-input id="emailTo" type="email" class="w-full" wire:model="emailTo" />
                        </div>

                        <div class="mt-3">
                            <x-jet-label for="emailSubject" value="Subject" />
                            <x-jet-input id="emailSubject" type="text" class="w-full" wire:model="emailSubject" />
                        </div>

                        <div class="mt-3">
                            <x-jet-label for="emailBody" value="Message" />
                            <textarea id="emailBody" class="w-full border-gray-300 rounded-md shadow-sm" rows="5" wire:model="emailBody"></textarea>
                        </div>

                        <div class="mt-3">
                            <x-jet-label value="Attachment" />
                            <div class="text-gray-600">Application_Form.pdf</div>
                        </div>
                    </x-slot>

                    <x-slot name="footer">
                        <x-buttons.cancel-button wire:click="$set('showEmailApplicationModal', false)">Cancel</x-buttons.cancel-button>
                        <x-jet-button wire:click="sendApplicationFormEmail" wire:loading.attr="disabled">
                            <span wire:loading.remove>Send</span>
                            <span wire:loading>Sending...</span>
                        </x-jet-button>
                    </x-slot>
                </x-jet-dialog-modal>

                <x-buttons.icon wire:click="$set('showDeleteConfirmModal', true)" colour="rose">
                    <x-icons.archive-filled size="30" />
                </x-buttons.icon>
                @endif
            </x-slot>

            <x-slot name="tabs">
                @foreach ($tabs as $tab)
                    <x-tabs.tab 
                        :current="$currentTab === $tab ? true : false"
                        click="changeTab('{{ $tab }}')"
                        >
                        {{ ucfirst($tab) }}
                    </x-tabs.tab>
                @endforeach
            </x-slot>

            @if($currentTab == 'overview')
                @section('fullWidth')
                    <livewire:leads.components.overview :lead="$lead" />
                @endsection
            @endif

            @if ($currentTab == 'consultations')
                @section('fullWidth')
                    <div>
                        <x-button wire:click="newConsultation">New Consultation</x-button>
                    </div>
                    <livewire:leads.components.consultations-table :lead="$lead" />
                @endsection
            @endif

            @if ($currentTab == 'projects')
                @section('fullWidth')
                    <livewire:global-components.projects :entity="$lead" />
                @endsection
            @endif

            @if($currentTab == 'files')
                @section('fullWidth')
                    <livewire:global-components.files-section 
                        :entity="$lead" 
                        :model="'App\\Models\\Lead'" 
                        :filePath="'Leads/' . $lead->firstname . '_' . $lead->lastname" 
                    />
                @endsection
            @endif

            @if($currentTab == 'activity')
                @section('fullWidth')
                <livewire:global-components.activity 
                    :activities="$lead->activities()->with('user')->get()"
                    :showPath="false"
                    :model="'App\\Models\\Lead'"
                    entityID="{{ $lead->id }}"
                />
                @endsection
            @endif
        </x-details>
    </div>

    {{-- Modals --}}
    <x-jet-confirmation-modal wire:model="showDeleteConfirmModal">
        <x-slot name="title">Archive Lead</x-slot>
        <x-slot name="content">
            Are you sure you would like to archive this lead?
        </x-slot>
        <x-slot name="footer">
            <div class="flex justify-end items-center gap-1">
                <x-buttons.cancel-button x-on:click="show = false">Cancel</x-buttons.cancel-button>
                <x-buttons.delete-button wire:click="delete">Archive</x-buttons.delete-button>
            </div>
        </x-slot>
    </x-jet-confirmation-modal>

    <livewire:global-components.outlook-email />

    <livewire:consultations.components.create-consultation-modal 
        :clientId="null" 
        :entity="$this->lead" 
    />

    <x-jet-confirmation-modal wire:model="showConversionErrorModal">
        <x-slot name="title">Error</x-slot>
        <x-slot name="content">
            <div>
                To convert the following lead, please ensure the <span class="font-bold">Company name</span> and <span class="font-bold">Email address</span> fields are filled in
            </div>
        </x-slot>
        <x-slot name="footer">
            <x-jet-button x-on:click="show = false">Ok</x-jet-button>
        </x-slot>
    </x-jet-confirmation-modal>
    {{-- End modals --}}
</div>

<script>
    window.addEventListener('notify-success', event => {
        alert(event.detail.message); // Simple alert popup
    });
</script>
