<div class="relative">
    <x-toast.success-event />

    <x-header>
        <x-slot name="title">Create Client</x-slot>
    </x-header>

    <div>
        <form class="space-y-2 w-full">
            <div class="w-full space-y-8">
                {{-- Client details --}}
                <div class="bg-white rounded-lg px-20 py-10 space-y-4">
                    <div class="text-xl font-bold">Client Details</div>

                    <div class="grid grid-cols-2 gap-20">
                        <div class="space-y-6">
                            <div>
                                <x-jet-label for="name" value="Client Name" />
                                <x-jet-input wire:model.lazy="client.name" id="name" type="text" tabindex="1" />
                                <span>@error('client.name') <span class="text-rose-600 text-sm error">{{ $message }}</span> @enderror</span>
                            </div>

                            <div>
                                <x-jet-label for="email" value="Email Address" />
                                <x-jet-input wire:model.lazy="client.email" id="email" type="text" tabindex="3" />
                                <span>@error('client.email') <span class="text-rose-600 text-sm error">{{ $message }}</span> @enderror</span>
                            </div>

                            <div>
                                <x-jet-label for="phone" value="Phone" />
                                <x-jet-input wire:model.lazy="client.phone" id="phone" type="text" tabindex="5" />
                                <span>@error('client.phone') <span class="text-rose-600 text-sm error">{{ $message }}</span> @enderror</span>
                            </div>

                            <div>
                                <x-jet-label for="engagement" value="Engagement Type" />
                                <x-jet-input id="engagement" wire:model.lazy="client.engagement_type" type="text" tabindex="7" />
                                <span>@error('client.engagement_type') <span class="text-rose-600 text-sm error">{{ $message }}</span> @enderror</span>
                            </div>

                            <div>
                                <x-jet-label for="vat" value="VAT Number" />
                                <x-jet-input id="vat" wire:model.lazy="client.vat_number" type="text" tabindex="9" />
                            </div>
                        </div>

                        <div class="space-y-6">
                            <div>
                                <x-jet-label for="address" value="Address" />
                                <x-jet-input wire:model.lazy="client.address" id="address" type="text" tabindex="2" />
                                <span>@error('client.address') <span class="text-rose-600 text-sm error">{{ $message }}</span> @enderror</span>
                            </div>

                            <div>
                                <x-jet-label for="city" value="City" />
                                <x-jet-input wire:model.lazy="client.city" id="city" type="text" tabindex="4" />
                                <span>@error('client.city') <span class="text-rose-600 text-sm error">{{ $message }}</span> @enderror</span>
                            </div>

                            <div>
                                <x-jet-label for="province" value="Province" />
                                <x-jet-input wire:model.lazy="client.province" id="province" type="text" tabindex="6" />
                                <span>@error('client.province') <span class="text-rose-600 text-sm error">{{ $message }}</span> @enderror</span>
                            </div>

                            <div>
                                <x-jet-label for="postal_code" value="Postal Code" />
                                <x-jet-input wire:model.lazy="client.postal_code" id="postal_code" type="text" tabindex="6" />
                                <span>@error('client.postal_code') <span class="text-rose-600 text-sm error">{{ $message }}</span> @enderror</span>
                            </div>

                            <div>
                                <x-jet-label for="country" value="Country" />
                                <x-jet-input wire:model.lazy="client.country" id="country" type="text" tabindex="8" />
                                <span>@error('client.country') <span class="text-rose-600 text-sm error">{{ $message }}</span> @enderror</span>
                            </div>

                            <div>
                                <x-jet-label for="registration" value="Registration Number" />
                                <x-jet-input id="registration" wire:model.lazy="client.registration_number" type="text" tabindex="10" />
                            </div>
                        </div>
                    </div>
                </div>
                {{-- End client details --}}

                {{-- Company details --}}
                <div class="bg-white rounded-lg px-20 py-10 space-y-4">
                    <div class="text-xl font-bold">Company Details</div>

                    <div class="grid grid-cols-2 gap-20">
                        <div class="space-y-6">
                            <div>
                                <x-jet-label for="size" value="Size" />
                                <div class="flex gap-4 w-full">
                                    <div class="grow">
                                        <x-select2-multiple 
                                            wire:model.defer="client.size" 
                                            wire:key="create-size" 
                                            name="client-Size-select2" 
                                            id="client-size-select2"
                                            tabindex="11"
                                            >
                                            <option value="">Select an option</option>
                                            @foreach($this->sizes as $size)
                                            <option value="{{ $size->id }}">{{ $size->name }}</option>
                                            @endforeach
                                        </x-select2-multiple>
                                    </div>

                                    <x-button class="rounded-xl" wire:click.prevent="showDropDownModal('Size')">
                                        <x-icons.plus />
                                    </x-button>
                                </div>
                                <span>@error('client.size') <span class="text-rose-600 text-sm error">{{ $message }}</span> @enderror</span>
                            </div>

                            <div>
                                <x-jet-label for="sector" value="Sector" />
                                <div class="flex gap-4">
                                    <div class="grow">
                                        <x-select2-multiple 
                                            wire:model.defer="client.sector" 
                                            wire:key="create-sector" 
                                            name="client-Sector-select2" 
                                            id="client-sector-select2"
                                            tabindex="13"
                                            >
                                            <option value="">Select an option</option>
                                            @foreach($this->sectors as $sector)
                                            <option value="{{ $sector->id }}">{{ $sector->name }}</option>
                                            @endforeach
                                        </x-select2-multiple>
                                    </div>

                                    <x-button class="rounded-xl" wire:click.prevent="showDropDownModal('Sector')">
                                        <x-icons.plus />
                                    </x-button>
                                </div>
                                <span>@error('client.sector') <span class="text-rose-600 text-sm error">{{ $message }}</span> @enderror</span>
                            </div>

                            <div>
                                <x-jet-label for="engagement-type" value="Engagement Type" />
                                <div class="flex gap-4">
                                    <div class="grow">
                                        <x-select2-multiple 
                                            wire:model.defer="client.engagement_type_id" 
                                            wire:key="create-engagement-type" 
                                            name="client-EngagementType-select2" 
                                            id="client-EngagementType-select2"
                                            tabindex="15"
                                            >
                                            <option value="">Select an option</option>
                                            @foreach($this->engagementTypes as $type)
                                            <option value="{{ $type->id }}">{{ $type->name }}</option>
                                            @endforeach
                                        </x-select2-multiple>
                                    </div>

                                    <x-button class="rounded-xl" wire:click.prevent="showDropDownModal('EngagementType')">
                                        <x-icons.plus />
                                    </x-button>
                                </div>
                            </div>

                            <div>
                                <x-jet-label for="rating-agency" value="Rating Agency" />
                                <div class="flex gap-4">
                                    <div class="grow">
                                        <x-select2-multiple 
                                            wire:model.defer="client.rating_agency_id" 
                                            wire:key="create-rating-agency" 
                                            name="client-RatingAgency-select2" 
                                            id="client-RatingAgency-select2"
                                            tabindex="17"
                                            >
                                            <option value="">Select an option</option>
                                            @foreach($this->ratingAgencies as $agency)
                                            <option value="{{ $agency->id }}">{{ $agency->name }}</option>
                                            @endforeach
                                        </x-select2-multiple>
                                    </div>

                                    <x-button class="rounded-xl" wire:click.prevent="showDropDownModal('RatingAgency')">
                                        <x-icons.plus />
                                    </x-button>
                                </div>
                            </div>
                        </div>
                    
                        <div class="space-y-6">
                            <div>
                                <x-jet-label for="region" value="Region" />
                                <div class="flex gap-4">
                                    <div class="grow">
                                        <x-select2-multiple 
                                            wire:model.defer="client.region" 
                                            wire:key="create-region" 
                                            name="client-Region-select2" 
                                            id="client-region-select2"
                                            tabindex="12"
                                            >
                                            <option value="">Select an option</option>
                                            @foreach($this->regions as $region)
                                            <option value="{{ $region->id }}">{{ $region->name }}</option>
                                            @endforeach
                                        </x-select2-multiple>
                                    </div>

                                    <x-button class="rounded-xl" wire:click.prevent="showDropDownModal('Region')">
                                        <x-icons.plus />
                                    </x-button>
                                </div>
                                <span>@error('client.region') <span class="text-rose-600 text-sm error">{{ $message }}</span> @enderror</span>
                            </div>

                            <div>
                                <x-jet-label for="state" value="State" />
                                <div class="flex gap-4">
                                    <div class="grow">
                                        <x-select2-multiple 
                                            wire:model.defer="client.state" 
                                            wire:key="create-state" 
                                            name="client-State-select2" 
                                            id="client-state-select2"
                                            tabindex="14"
                                            >
                                            <option value="">Select an option</option>
                                            @foreach($this->states as $state)
                                            <option value="{{ $state->id }}">{{ $state->name }}</option>
                                            @endforeach
                                        </x-select2-multiple>
                                    </div>

                                    <x-button class="rounded-xl" wire:click.prevent="showDropDownModal('State')">
                                        <x-icons.plus />
                                    </x-button>
                                </div>
                                <span>@error('client.state') <span class="text-rose-600 text-sm error">{{ $message }}</span> @enderror</span>
                            </div>

                            <div>
                                <x-jet-label for="report-status" value="Report Status" />
                                <div class="flex gap-4">
                                    <div class="grow">
                                        <x-select2-multiple 
                                            wire:model.defer="client.report_status_id" 
                                            wire:key="create-report-status" 
                                            name="client-ReportStatus-select2" 
                                            id="client-ReportStatus-select2"
                                            tabindex="16"
                                            >
                                            <option value="">Select an option</option>
                                            @foreach($this->reportStatuses as $status)
                                            <option value="{{ $status->id }}">{{ $status->name }}</option>
                                            @endforeach
                                        </x-select2-multiple>
                                    </div>

                                    <x-button class="rounded-xl" wire:click.prevent="showDropDownModal('ReportStatus')">
                                        <x-icons.plus />
                                    </x-button>
                                </div>
                            </div>

                            <div>
                                <x-jet-label for="bee-level" value="BEE Level" />
                                <div class="flex gap-4">
                                    <div class="grow">
                                        <x-select2-multiple 
                                            wire:model.defer="client.bee_level_id" 
                                            wire:key="create-bee-level" 
                                            name="client-BeeLevel-select2" 
                                            id="client-BeeLevel-select2"
                                            tabindex="18"
                                            >
                                            <option value="">Select an option</option>
                                            @foreach($this->beeLevels as $level)
                                            <option value="{{ $level->id }}">{{ $level->name }}</option>
                                            @endforeach
                                        </x-select2-multiple>
                                    </div>

                                    <x-button class="rounded-xl" wire:click.prevent="showDropDownModal('BeeLevel')">
                                        <x-icons.plus />
                                    </x-button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- End company details --}}

                {{-- Dates --}}
                <div class="bg-white rounded-lg px-20 py-10 space-y-4">
                    <div class="text-xl font-bold">Dates</div>

                    <div class="grid grid-cols-2 gap-20">
                        <div class="space-y-6">
                            <div>
                                <x-jet-label for="fye" value="Financial Year End" />
                                <x-input.flatpickr id="flatpickr-client-fye" wire:model.defer="client.fye" tabindex="19" />
                                <span>@error('client.fye') <span class="text-rose-600 text-sm error">{{ $message }}</span> @enderror</span>
                            </div>

                            {{-- <div>
                                <x-jet-label for="flatpickr-client-deadline" value="Deadline" />
                                <x-input.flatpickr id="flatpickr-client-deadline" wire:model.defer="client.deadline" tabindex="19" />
                                <span>@error('client.deadline') <span class="text-rose-600 text-sm error">{{ $message }}</span> @enderror</span>
                            </div> --}}
                            <div>
                                <x-jet-label for="flatpickr-client-planned-audit" value="Planned Audit Date" />
                                <x-input.flatpickr id="flatpickr-client-planned-audit" wire:model.defer="client.planned_audit_date" tabindex="21" />
                            </div>

                            <div>
                                <x-jet-label for="flatpickr-client-cert-issued" value="Date Certificate Issued" />
                                <x-input.flatpickr id="flatpickr-client-cert-issued" wire:model.defer="client.date_cert_issued" tabindex="23" />
                            </div>

                            <div>
                                <x-jet-label for="flatpickr-client-date-engaged" value="Date Engaged" />
                                <x-input.flatpickr id="flatpickr-client-date-engaged" wire:model.defer="client.date_engaged" tabindex="25" />
                            </div>
                        </div>

                        <div class="space-y-6">
                            <div>
                                <x-jet-label for="next_report" value="Next Report Required" />
                                <x-input.flatpickr id="flatpickr-client-next_report" wire:model.defer="client.next_report_required" tabindex="20" />
                                <span>@error('client.next_report_required') <span class="text-rose-600 text-sm error">{{ $message }}</span> @enderror</span>
                            </div>
                            
                            <div>
                                <x-jet-label for="next_audit" value="Next Audit" />
                                <x-input.flatpickr id="flatpickr-client-next_audit" wire:model.defer="client.next_audit" tabindex="22" />
                                <span>@error('client.next_audit') <span class="text-rose-600 text-sm error">{{ $message }}</span> @enderror</span>
                            </div>

                            <div>
                                <x-jet-label for="flatpickr-client-cert-exp" value="Date Certificate Expires" />
                                <x-input.flatpickr id="flatpickr-client-cert-exp" wire:model.defer="client.current_certificate_expiry" tabindex="24" />
                            </div>
                        </div>
                    </div>
                </div>
                {{-- End Dates --}}
            </div>

            <x-jet-button wire:click.prevent="submit" tabindex="26">Create</x-jet-button>
        </form>
    </div>

    {{-- Create new dropdown item modal --}}
    <x-jet-dialog-modal wire:model="newDropDownItemModal" maxWidth="md">
        <x-slot name="title">Create New {{ $dropDownClass }}</x-slot>

        <x-slot name="content">
            <x-jet-input type="text" wire:model="newDropDownItemName"/>
            <span>@error('newDropDownItemName') <span class="text-rose-600 text-sm error">{{ $message }}</span> @enderror</span>
        </x-slot>

        <x-slot name="footer">
            <div class="flex flex-row items-center justify-end space-x-2">
                <x-buttons.cancel-button wire:click="cancelDropdownItem">Cancel</x-buttons.cancel-button>
                <x-create-button wire:click="newDropDownItem">Create</x-create-button>
            </div>
        </x-slot>
    </x-jet-dialog-modal>
</div>