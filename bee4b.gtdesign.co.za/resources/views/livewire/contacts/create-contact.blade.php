<div>
    <x-jet-dialog-modal wire:model="showCreateContactModal">
        <x-slot name="title">New Contact</x-slot>
        <x-slot name="content">
            <div class="grid grid-cols-2 gap-2">
                <div class="flex flex-col gap-2">
                    {{-- Module --}}
                    <div>
                        <x-jet-label for='module' value="Module" />
                        <select 
                            wire:model="selectedModule" 
                            {{ isset($client) ? 'disabled' : '' }}
                            class="disabled:bg-gray-100 disabled:text-gray-400 w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
                            tabindex="1"
                            >
                            <option value="">Please select a module</option>
                            @foreach ($contactableModules as $key => $value)
                                <option value="{{ $key }}">{{ $value }}</option>
                            @endforeach
                        </select>
                        <x-validation-error field="selectedModule" />
                    </div>
                    {{-- End module --}}

                    {{-- First name --}}
                    <div>
                        <x-jet-label for="name" value="Name" />
                        <x-jet-input wire:model.lazy="contact.name" id="name" type="text" tabindex="3" />
                        <x-validation-error field="contact.name" />
                    </div>
                    {{-- End first name --}}

                    {{-- Job title --}}
                    <div>
                        <x-jet-label for="jobtitle" value="Job Title" />
                        <x-jet-input wire:model.lazy="contact.jobtitle" id="jobtitle" type="text" tabindex="5" />
                        {{-- <x-validation-error field="contact.jobtitle" /> --}}
                    </div>
                    {{-- End job title --}}

                    {{-- Phone primary --}}
                    <div>
                        <x-jet-label for="phone-primary" value="Phone Primary" />
                        <x-jet-input wire:model.lazy="contact.phone_primary" id="phone-primary" type="text" tabindex="7" />
                        {{-- <x-validation-error field="contact.phone_primary" /> --}}
                    </div>
                    {{-- End phone primary --}}

                    <div>
                        <x-jet-label for="category" value="Category" />
                        <x-jet-input id="category" type="text" class="w-full" wire:model.defer="contact.category" placeholder="e.g. Finance, HR, IT" />
                        <x-validation-error field="contact.category" />
                    </div>
                </div>

                <div class="flex flex-col gap-2">
                    {{-- Record --}}
                    <div>
                        <x-jet-label for="record" value="Record" />
                        <select 
                            wire:model="selectedRecord" 
                            {{ $selectedModule === null || isset($client) ? 'disabled' : '' }} 
                            class="disabled:bg-gray-100 disabled:text-gray-400 w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
                            tabindex="2"
                            >
                            <option value="">Please select a record</option>
                            @foreach ($records as $record)
                            <option value="{{ $record->id }}">{{ $record->name }}</option>
                            @endforeach
                        </select>
                        <x-validation-error field="selectedRecord" />
                    </div>
                    {{-- End record --}}

                    {{-- Email --}}
                    <div>
                        <x-jet-label for="email" value="Email" />
                        <x-jet-input wire:model.lazy="contact.email" id="email" type="text" tabindex="6" />
                        <x-validation-error field="contact.email" />
                    </div>
                    {{-- End email --}}

                    {{-- Secondary phone  --}}
                    <div>
                        <x-jet-label for="phone-secondary" value="Phone Secondary" />
                        <x-jet-input wire:model.lazy="contact.phone_secondary" id="phone-secondary" type="text" tabindex="8" />
                        {{-- <x-validation-error field="contact.phone_secondary" /> --}}
                    </div>
                    {{-- End secondary phone --}}
                </div>
            </div>
        </x-slot>
        <x-slot name="footer">
            <div class="flex justify-end items-center">
                <x-buttons.cancel-button x-on:click="show = false">Cancel</x-buttons.cancel-button>
                <x-create-button wire:click="submit">Create</x-create-button>
            </div>
        </x-slot>
    </x-jet-dialog-modal>

    <?php /*
    <div>
        <form class="space-y-2 w-1/4">
            <div>
                <x-jet-label for='module' value="Module" />
                <x-select wire:model="selectedModule">
                    <option value="">Please select a module</option>
                    @foreach ($contactableModules as $key => $value)
                        <option value="{{ $key }}">{{ $value }}</option>
                    @endforeach
                </x-select>
                <x-validation-error field="selectedModule" />
            </div>

            <div>
                <x-jet-label for="record" value="Record" />
                <select wire:model="selectedRecord" {{ $selectedModule === null ? 'disabled' : '' }} class="disabled:bg-gray-100 disabled:text-gray-400 w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm">
                    <option value="">Please select a record</option>
                    @foreach ($records as $record)
                    <option value="{{ $record->id }}">{{ $record->name }}</option>
                    @endforeach
                </select>
                <x-validation-error field="selectedRecord" />
            </div>

            {{-- <div>
                <x-jet-label for="client" value="Client" />
                <select wire:model="contact.client_id" id="client" class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm">
                    <option value="">Select Client</option>
                    @foreach($clients as $client)
                    <option value="{{ $client->id }}">{{ $client->name }}</option>
                    @endforeach
                </select>
            </div> --}}

            <div>
                <x-jet-label for="firstname" value="First Name" />
                <x-jet-input wire:model.lazy="contact.firstname" id="firstname" type="text" />
                <x-validation-error field="contact.firstname" />
            </div>

            <div>
                <x-jet-label for="lastname" value="Last Name" />
                <x-jet-input wire:model.lazy="contact.lastname" id="lastname" type="text" />
                <x-validation-error field="contact.lastname" />
            </div>

            <div>
                <x-jet-label for="jobtitle" value="Job Title" />
                <x-jet-input wire:model.lazy="contact.jobtitle" id="jobtitle" type="text" />
                <x-validation-error field="contact.jobtitle" />
            </div>

            <div>
                <x-jet-label for="email" value="Email" />
                <x-jet-input wire:model.lazy="contact.email" id="email" type="text" />
                <x-validation-error field="contact.email" />
            </div>

            <div>
                <x-jet-label for="phone-primary" value="Phone Primary" />
                <x-jet-input wire:model.lazy="contact.phone_primary" id="phone-primary" type="text" />
                <x-validation-error field="contact.phone_primary" />
            </div>

            <div>
                <x-jet-label for="phone-secondary" value="Phone Secondary" />
                <x-jet-input wire:model.lazy="contact.phone_secondary" id="phone-secondary" type="text" />
                <x-validation-error field="contact.phone_secondary" />
            </div>

            <x-create-button wire:click.prevent="submit">Create</x-create-button>
        </form>
    </div>
    */ ?>
</div>
