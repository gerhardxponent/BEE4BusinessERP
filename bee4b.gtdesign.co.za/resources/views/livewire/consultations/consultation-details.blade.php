<div class="relative">
    {{-- <x-header :breadcrumbs="$breadcrumbs" /> --}}

    {{-- @json($consultation) --}}

    <div class="fixed z-50 top-20 right-5 space-y-4">
    @if (session()->has('message'))
    <x-toast.success message="{{ session('message') }}"></x-toast.success>
    @endif
    </div>

    <x-details>
        <x-slot name="bgColor">bg-indigo-400</x-slot>
        <x-slot name="initials">
            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-alarm" width="65" height="65" viewBox="0 0 24 24" stroke-width="2" stroke="white" fill="none" stroke-linecap="round" stroke-linejoin="round">
                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                <circle cx="12" cy="13" r="7"></circle>
                <polyline points="12 10 12 13 14 13"></polyline>
                <line x1="7" y1="4" x2="4.25" y2="6"></line>
                <line x1="17" y1="4" x2="19.75" y2="6"></line>
            </svg>
        </x-slot>

        <x-slot name="headerDetails">
            <div class="font-bold text-xl">{{ $consultation->name }}</div>
            <div class="text-gray-600">{{ $consultation->consultationdate }}</div>
        </x-slot>

        <x-slot name="column1">
            <div class=" p-8 bg-white rounded-xl">
                <table class="table">
                    <tr>
                        <td class="font-bold">Name</td>
                        <td>{{ $consultation->name }}</td>
                    </tr>
                    <tr>
                        <td class="font-bold">Client</td>
                        <td>
                            @isset($consultation->client->id)
                            <a class="text-blue-500 hover:underline" href="../clients/{{ $consultation->client->id }}">
                                {{ $consultation->client->name }}
                            </a>
                            @endisset
                        </td>
                    </tr>
                    <tr>
                        <td class="font-bold">Start Time</td>
                        <td>{{ $consultation->starttime }}</td>
                    </tr>
                    <tr>
                        <td class="font-bold">End Time</td>
                        <td>{{ $consultation->endtime }}</td>
                    </tr>
                    {{-- <tr>
                        <td class="font-bold align-top">Attendees</td>
                        <td>
                            @foreach(explode(';', $consultation->attendees) as $attendee)
                            <div>{{ $attendee }}</div>
                            @endforeach
                        </td>
                    </tr> --}}
                </table>
            </div>
        </x-slot>

        <x-slot name="column2">
            <div class="p-8 bg-white rounded-xl space-y-2">
                <div class="font-bold text-lg">Attendees</div>
                <div>
                    @foreach(explode(';', $consultation->attendees) as $attendee)
                    <div 
                        class="text-blue-500 hover:underline cursor-pointer"
                        wire:click="openModal('{{ $attendee }}')"
                        >
                        {{ $attendee }}
                    </div>
                    @endforeach
                </div>
            </div>
        </x-slot>

        <x-slot name="column3">
            <div class="p-8 bg-white rounded-xl space-y-2">
                <div class="font-bold text-lg">Details</div>
                <div>{{ $consultation->details }}</div>
            </div>
        </x-slot>
    </x-details>


    {{-- Email modal --}}
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
            </div>
        </x-slot>

        <x-slot name="footer">
            <div class="flex flex-row justify-end items-center space-x-2">
                {{-- <button wire:click="$toggle('sending')">TEST</button> --}}
                <x-buttons.cancel-button wire:click="closeEmailModal">Cancel</x-buttons.cancel-button>
                <x-buttons.send wire:click="sendOutlook" id="send-button">Send</x-buttons.send>
            </div>
        </x-slot>
    </x-modal.dialog>
</div>
