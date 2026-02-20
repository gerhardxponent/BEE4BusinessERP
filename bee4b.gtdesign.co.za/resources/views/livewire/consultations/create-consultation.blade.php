<div>
    {{-- <x-header>
        <x-slot name="title">Create Consultations</x-slot>
    </x-header> --}}
    <x-header :breadcrumbs="$breadcrumbs" />

    <div>
        <form class="space-y-4 w-1/2">
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
                <span>@error('selectedClient') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror</span>
                <x-jet-label for="client-name" value="Client" />
                <select id="client-name" wire:model="selectedClient" class="client-select" name="state" style="width: 100%;">
                    <option value="">Select Client</option>
                    @foreach($clients as $client)
                    <option value="{{ $client->id }}">{{ $client->name }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <x-jet-label for="emails-input" value="Attendees" />
                {{-- <div id="emails-input" wire:ignore class="border-none"></div> --}}
                <x-input.email-list id="lsakjlskad" wire:model="attendees" />
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

            <x-create-button wire:click.prevent="submit">Create</x-create-button>
        </form>
    </div>

    <script>
        $(document).ready(function() {
            //select2
            $('.client-select').select2();
            $('.client-select').on('change', function() {
                var data = $('.client-select').select2("val");
                @this.set('selectedClient', data);
            });

            //multi-email input
            // const inputContainerNode = document.querySelector('#emails-input');
            // const emailsInput = EmailsEditor(inputContainerNode, () => {
            //     @this.set('attendees', emailsInput.getEmails());
            // });
        });
    </script>
</div>