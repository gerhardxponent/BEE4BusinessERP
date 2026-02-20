<div>
    <x-jet-dialog-modal wire:model="showCreateConsultationsModal">
        <x-slot name="title">Create Consultation</x-slot>
        <x-slot name="content">
            <div class="transition-opacity" wire:loading.class="opacity-50" wire:target="submit">
                {{-- <div>{{ $entity->name }}</div> --}}

                <form class="space-y-4">
                    <div>
                        @if (session()->has('message'))
                            <div class="alert alert-success">
                                {{ session('message') }}
                            </div>
                        @endif
                    </div>
                    <div>
                        <x-jet-label for="constultationname" value="Consultation Name" />
                        <x-jet-input wire:model.lazy="consultation.name" id="constultationname" type="text" />
                        <span>@error('consultation.name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror</span>
                    </div>
                    <div wire:ignore>
                        <x-jet-label for="client-name" value="Client" />
                        <x-select2-multiple wire:model.defer="consultation.client_id" wire:key="set-client" id="client-select2">
                            <option value="">Select Client</option>
                            @foreach($clients as $clients)
                            <option value="{{ $clients->id }}">{{ $clients->name }}</option>
                            @endforeach
                        </x-select2-multiple>
                        <span>@error('consultation.client_id') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror</span>
                    </div>
                    <div>
                        <x-jet-label for="emails-input" value="Attendees" />
                        {{-- <div id="emails-input" wire:ignore class="border-none"></div> --}}
                        {{-- <x-input.email-list id="lsakjlskad" wire:model="attendees" /> --}}
                        <x-select2-multiple wire:model.defer="attendees" wire:key="set-client" id="toAddress" multiple tags="true">
                            <option value="">Select Recipients</option>
                            @foreach($attendeeEmails as $email)
                            <option value="{{ $email }}">{{ $email }}</option>
                            @endforeach
                        </x-select2-multiple>
                        <span>@error('attendees') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror</span>
                    </div>
                    <div>
                        <x-jet-label for="consultation-details" value="Details" />
                        <x-textarea id="consultation-details" rows="4" wire:model.lazy="consultation.details"></x-textarea>
                    </div>
                    <div>
                        <x-jet-label for="consultationdate" value="Consultation Date" />
                        <x-jet-input wire:model.lazy="consultation.consultationdate" id="consultationdate" type="date" />
                        <span>@error('consultation.consultationdate') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror</span>
                    </div>
                    <div class="flex flex-row w-full space-x-2">
                        <div class="w-1/2">
                            <x-jet-label for="starttime" value="Start Time" />
                            <x-jet-input wire:model.lazy="consultation.starttime" id="starttime" type="datetime-local" />
                            <span>@error('consultation.starttime') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror</span>
                        </div>
                        <div class="w-1/2">
                            <x-jet-label for="endtime" value="End Time" />
                            <x-jet-input wire:model.lazy="consultation.endtime" id="endtime" type="datetime-local" />
                            <span>@error('consultation.endtime') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror</span>
                        </div>
                    </div>
                    <div class="flex flex-row space-x-2">
                        <x-jet-checkbox id="add-to-ms" wire:model="addToMs" />
                        <x-jet-label for="add-to-ms" value="Add to Outlook Calendar" />
                    </div>
                </form>
            </div>
        </x-slot>
        <x-slot name="footer">
            <div class="space-x-1">
                <x-buttons.cancel-button x-on:click="show = false">Cancel</x-buttons.cancel-button>
                <x-create-button wire:click.prevent="submit">Create</x-create-button>
            </div>
        </x-slot>
    </x-jet-dialog-modal>
</div>
