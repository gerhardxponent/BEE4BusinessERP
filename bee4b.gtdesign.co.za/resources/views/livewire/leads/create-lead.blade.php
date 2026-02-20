<div class="relative">
    <div class="bg-white rounded-lg px-20 py-10 space-y-4">
        <div class="text-xl font-bold">Lead Details</div>

        <div class="grid grid-cols-2 gap-20">
            <div class="space-y-6">
                <div>
                    <x-jet-label for="name" value="Name" />
                    <x-jet-input type="text" id="name" wire:model.defer="lead.name" tabindex="1"/>
                    <div>
                        @error('lead.primary_phone')
                            <x-validation-error field="lead.name" />
                        @else
                            <div class="text-sm text-gray-500">Required</div>
                        @enderror
                    </div>
                </div>

                <div>
                    <x-jet-label for="fName" value="Primary Phone" />
                    <x-jet-input type="text" id="fName" wire:model.defer="lead.primary_phone" tabindex="3" />
                    <div>
                        @error('lead.primary_phone') 
                            <span class="text-rose-600 text-sm error">{{ $message }}</span> 
                        @else
                            <div class="text-sm text-gray-500">Required</div>
                        @enderror
                    </div>
                </div>

                <div>
                    <x-jet-label for="email" value="Email Address" />
                    <x-jet-input type="text" id="email" wire:model.defer="lead.email_address" tabindex="5" />
                    <span>@error('lead.email_address') <span class="text-rose-600 text-sm error">{{ $message }}</span> @enderror</span>
                </div>

                <x-jet-label for="assignedTo" value="Assigned To" />
                <select id="assignedTo"
                        class="w-full border-gray-300 rounded-md shadow-sm"
                        wire:model.defer="lead.assigned_to"
                        tabindex="7">
                    <option value="">Select user</option>
                    @foreach($users as $user)
                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                    @endforeach
                </select>
                <span>@error('lead.assigned_to') <span class="text-rose-600 text-sm error">{{ $message }}</span> @enderror</span>


                <div>
                    <x-jet-label for="source" value="Source" />
                    <x-jet-input type="text" id="source" wire:model.defer="lead.source" tabindex="9" />
                </div>
            </div>

            <div class="space-y-6">
                {{-- <div>
                    <x-jet-label for="lName" value="Last Name" />
                    <x-jet-input type="text" id="lName" wire:model.defer="lead.last_name" tabindex="2" />
                    <div>
                        @error('lead.last_name') 
                            <span class="text-rose-600 text-sm error">{{ $message }}</span> 
                        @else
                            <div class="text-sm text-gray-500">Required</div>
                        @enderror
                    </div>
                </div> --}}

                <div>
                    <x-jet-label for="secondaryPhone" value="Secondary Phone" />
                    <x-jet-input type="text" id="secondaryPhone" wire:model.defer="lead.secondary_phone" tabindex="4" />
                </div>

                <div>
                    <x-jet-label for="enquiry" value="Enquiry" />
                    <x-jet-input type="text" id="enquiry" wire:model.defer="lead.enquiry" tabindex="6" />
                </div>

                <div>
                    <x-jet-label for="description" value="Description" />
                    <x-textarea id="description" wire:model.defer="lead.description" rows="4" tabindex="8"></x-textarea>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg mt-8 px-20 py-10 space-y-4">
        <div class="text-xl font-bold">Application Details</div>

        <div class="grid grid-cols-2 gap-20">
            <div class="space-y-6">
                <div>
                    <x-jet-label for="company" value="Company Name" />
                    <x-jet-input type="text" id="company" wire:model.defer="lead.company_name" tabindex="10" />
                    <span>@error('lead.company_name') <span class="text-rose-600 text-sm error">{{ $message }}</span> @enderror</span>
                </div>

                <div>
                    <x-jet-label for="sector" value="Sector" />
                    <x-select2-multiple wire:model.defer="lead.sector_id" wire:key="set-sector" id="sector" tabindex="12">
                        <option value="">Select sector</option>
                        @foreach($sectors as $sector)
                        <option value="{{ $sector->id }}">{{ $sector->name }}</option>
                        @endforeach
                    </x-select2-multiple>
                </div>
            </div>

            <div class="space-y-6">
                <div>
                    <x-jet-label for="website" value="Website" />
                    <x-jet-input type="text" id="website" wire:model.defer="lead.website" tabindex="11" />
                </div>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg mt-8 px-20 py-10 space-y-4">
        <div class="text-xl font-bold">Address Details</div>
    
        <div class="grid grid-cols-2 gap-20">
            <div class="space-y-3">
                <div>
                    <x-jet-label for="address" value="Address" />
                    <x-jet-input type="text" id="address" wire:model.defer="lead.address" tabindex="13" />
                </div>

                <div>
                    <x-jet-label for="province" value="Province" />
                    <x-jet-input type="text" id="province" wire:model.defer="lead.province" tabindex="15" />
                </div>
            </div>

            <div class="space-y-3">
                <div>
                    <x-jet-label for="city" value="City" />
                    <x-jet-input type="text" id="city" wire:model.defer="lead.city" tabindex="14" />
                </div>

                <div>
                    <x-jet-label for="country" value="Country" />
                    <x-jet-input type="text" id="country" wire:model.defer="lead.country" tabindex="16" />
                </div>
            </div>
        </div>
    </div>

    <div class="mt-6">
        <x-jet-button wire:click="createLead" tabindex="17">Create Lead</x-jet-button>
    </div>
</div>
