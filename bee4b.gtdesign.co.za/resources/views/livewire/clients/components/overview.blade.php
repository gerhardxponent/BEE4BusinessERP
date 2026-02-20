<div>
    {{-- <x-jet-button wire:click="changeDirName">Change Dir</x-jet-button> --}}

    <div class="grid grid-cols-2 gap-4 mt-2">
        {{-- Left column --}}
        <div class="flex flex-col gap-4">
            {{-- Client details block --}}
            <div class="p-8 bg-white rounded-xl">
                <table class="table-auto border-separate [border-spacing:0.2rem]">
                    <tbody>
                        <tr>
                            <td class="w-1/2 font-bold">Company Name</td>
                            @if($editing)
                            <td>
                                <x-jet-input wire:model.delay="client.name" type="text" placeholder="Name" />
                                {{-- <span>@error('client.name') <span class="text-red-500 text-sm error">{{ $message }}</span> @enderror</span> --}}
                                <x-validation-error field="client.name" />
                            </td>
                            @else
                            <td>
                                {{ $client->name }}
                            </td>
                            @endif
                        </tr>
                        <tr>
                            <td class="w-1/2 font-bold">Email</td>
                            @if($editing)
                            <td>
                                <x-jet-input wire:model.delay="client.email" type="text" placeholder="Email" />
                                {{-- <span>@error('client.email') <span class="text-red-500 text-sm error">{{ $message }}</span> @enderror</span> --}}
                                <x-validation-error field="client.email" />
                            </td>
                            @else
                            <td>
                                {{ $client->email }}
                                {{-- <livewire:global-components.inline-edit
                                    :model="'\\App\\Models\\Clients'"
                                    :entity="$client"
                                    :field="'email'"
                                    :key="'client-email-'.$client->id"
                                    lineID="client-email-{{ $client->id }}"
                                    type="line"
                                /> --}}
                            </td>
                            @endif
                        </tr>
                        <tr>
                            <td class="w-1/2 font-bold">Phone</td>
                            @if($editing)
                            <td>
                                <x-jet-input wire:model.delay="client.phone" type="text" placeholder="Phone" />
                                {{-- <span>@error('client.phone') <span class="text-red-500 text-sm error">{{ $message }}</span> @enderror</span> --}}
                                <x-validation-error field="client.phone" />
                            </td>
                            @else
                            <td>
                                {{ $client->phone }}
                                {{-- <livewire:global-components.inline-edit
                                    :model="'\\App\\Models\\Clients'"
                                    :entity="$client"
                                    :field="'phone'"
                                    :key="'client-phone-'.$client->id"
                                    lineID="client-phone-{{ $client->id }}"
                                    type="line"
                                /> --}}
                            </td>
                            @endif
                        </tr>
                        <tr>
                            <td class="w-1/2 font-bold">Address</td>
                            @if($editing)
                            <td>
                                <x-jet-input wire:model.delay="client.address" type="text" placeholder="Address" />
                                {{-- <span>@error('client.address') <span class="text-red-500 text-sm error">{{ $message }}</span> @enderror</span> --}}
                            </td>
                            @else
                            <td>
                                {{ $client->address }}
                                {{-- <livewire:global-components.inline-edit
                                    :model="'\\App\\Models\\Clients'"
                                    :entity="$client"
                                    :field="'address'"
                                    :key="'client-address-'.$client->id"
                                    lineID="client-address-{{ $client->id }}"
                                    type="line"
                                /> --}}
                            </td>
                            @endif
                        </tr>
                        <tr>
                            <td class="w-1/2 font-bold">City</td>
                            @if($editing)
                            <td>
                                <x-jet-input wire:model.delay="client.city" type="text" placeholder="City" />
                                {{-- <span>@error('client.city') <span class="text-red-500 text-sm error">{{ $message }}</span> @enderror</span> --}}
                            </td>
                            @else
                            <td>
                                {{ $client->city }}
                                {{-- <livewire:global-components.inline-edit
                                    :model="'\\App\\Models\\Clients'"
                                    :entity="$client"
                                    :field="'city'"
                                    :key="'client-city-'.$client->id"
                                    lineID="client-city-{{ $client->id }}"
                                    type="line"
                                /> --}}
                            </td>
                            @endif
                        </tr>
                        <tr>
                            <td class="w-1/2 font-bold">Province</td>
                            @if($editing)
                            <td>
                                <x-jet-input wire:model.delay="client.province" type="text" placeholder="Province" />
                            </td>
                            @else
                            <td>
                                {{ $client->province }}
                            </td>
                            @endif
                        </tr>
                        <tr>
                            <td class="w-1/2 font-bold">Postal Code</td>
                            @if($editing)
                            <td>
                                <x-jet-input wire:model.delay="client.postal_code" type="text" />
                            </td>
                            @else
                            <td>
                                {{ $client->postal_code }}
                            </td>
                            @endif
                        </tr>
                        <tr>
                            <td class="w-1/2 font-bold">Country</td>
                            @if($editing)
                            <td>
                                <x-jet-input wire:model.delay="client.country" type="text" placeholder="Country" />
                            </td>
                            @else
                            <td>
                                {{ $client->country }}
                            </td>
                            @endif
                        </tr>
                        <tr>
                            <td class="w-1/2 font-bold">Financial Year End</td>
                            @if($editing)
                            <td>
                                <x-input.flatpickr id="flatpickr-client-fye" wire:model.defer="client.fye" />
                            </td>
                            @else
                            <td>
                                {{ $client->fye ? \Carbon\Carbon::parse($client->fye)->format('d M Y') : '' }}
                                {{-- <livewire:global-components.inline-edit
                                    :model="'\\App\\Models\\Clients'"
                                    :entity="$client"
                                    :field="'fye'"
                                    :key="'client-fye-'.$client->id"
                                    lineID="client-fye-{{ $client->id }}"
                                    type="date"
                                    dateFormat="d M Y"
                                /> --}}
                            </td>
                            @endif
                        </tr>
                        <tr>
                            <td class="w-1/2 font-bold">Date Certificate issued</td>
                            @if($editing)
                            <td>
                                <x-input.flatpickr id="flatpickr-client-cert_issued" wire:model.defer="client.date_cert_issued" />
                            </td>
                            @else
                            <td>
                                {{ $client->date_cert_issued ? \Carbon\Carbon::parse($client->date_cert_issued)->format('d M Y') : '' }}
                            </td>
                            @endif
                        </tr>
                        <tr>
                            <td class="w-1/2 font-bold">Date Certificate expires</td>
                            @if($editing)
                            <td>
                                <x-input.flatpickr id="flatpickr-client-cert_expires" wire:model.defer="client.current_certificate_expiry" />
                            </td>
                            @else
                            <td>
                                {{ $client->current_certificate_expiry ? \Carbon\Carbon::parse($client->current_certificate_expiry)->format('d M Y') : '' }}
                            </td>
                            @endif
                        </tr>
                        <tr>
                            <td class="w-1/2 font-bold">Next Report Required</td>
                            @if($editing)
                            <td>
                                <x-input.flatpickr id="flatpickr-client-next_report_required" wire:model.defer="client.next_report_required" />
                            </td>
                            @else
                            <td>
                                {{ $client->next_report_required ? \Carbon\Carbon::parse($client->next_report_required)->format('d M Y') : '' }}
                            </td>
                            @endif
                        </tr>
                        <tr>
                            <td class="w-1/2 font-bold">Planned Audit Month</td>
                            @if($editing)
                            {{-- <td>
                                <x-input.flatpickr id="flatpickr-client-next_audit" wire:model.defer="client.planned_audit_date" />
                            </td> --}}
                            <td>
                                <div class="w-full">
                                    <x-select2-multiple
                                        id="client-planned-audit-month-select2"
                                        wire:model.defer="client.planned_audit_month_id"
                                        name="client-planned-audit-month-select2"
                                        :options="$this->months"
                                        placeholder="Please select an option"
                                    />
                                </div>
                            </td>
                            @else
                            <td>
                                {{-- {{ $client->planned_audit_date ? \Carbon\Carbon::parse($client->planned_audit_date)->format('d M Y') : '' }} --}}
                                {{ isset($client->plannedAuditMonth) ? $client->plannedAuditMonth->name : '' }}
                            </td>
                            @endif
                        </tr>
                        <tr>
                            <td class="w-1/2 font-bold">Date VA Engaged</td>
                            @if($editing)
                            <td>
                                <x-input.flatpickr id="flatpickr-client-date_engaged" wire:model.defer="client.date_engaged" />
                            </td>
                            @else
                            <td>
                                {{ $client->date_engaged ? \Carbon\Carbon::parse($client->date_engaged)->format('d M Y') : '' }}
                            </td>
                            @endif
                        </tr>
                        <tr>
                            <td class="w-1/2 font-bold">Next Audit Date</td>
                            @if($editing)
                            <td>
                                <x-input.flatpickr id="flatpickr-client-next_audit-date" wire:model.defer="client.next_audit" />
                            </td>
                            @else
                            <td>
                                {{ $client->next_audit ? \Carbon\Carbon::parse($client->next_audit)->format('d M Y') : '' }}
                            </td>
                            @endif
                        </tr>
                        <tr>
                            <td class="w-1/2 font-bold">VAT Number</td>
                            @if($editing)
                            <td>
                                <x-jet-input type="text" wire:model.delay="client.vat_number" />
                            </td>
                            @else
                            <td>
                                {{ $client->vat_number }}
                            </td>
                            @endif
                        </tr>
                        <tr>
                            <td class="w-1/2 font-bold">Registration Number</td>
                            @if($editing)
                            <td>
                                <x-jet-input type="text" wire:model.delay="client.registration_number" />
                            </td>
                            @else
                            <td>
                                {{ $client->registration_number }}
                            </td>
                            @endif
                        </tr>
                        <tr>
                            <td class="w-1/2 font-bold">Engagement Type</td>
                            @if($editing)
                            <td>
                                {{-- <x-jet-input wire:model.delay="client.engagement_type" type="text" placeholder="Engagement Type" />
                                <x-validation-error field="client.engagement_type" /> --}}

                                <div class="flex space-x-1">
                                    <div class="w-full">
                                        <x-select2-multiple
                                            id="client-engagement-select2"
                                            wire:model="client.engagement_type_id"
                                            name="client-EngagementType-select2"
                                            :options="$this->engagementTypes"
                                            placeholder="Please select an option"
                                        />
                                    </div>

                                    <x-button class="rounded-xl" wire:click="showDropDownModal('EngagementType')">
                                        <x-icons.plus />
                                    </x-button>
                                </div>
                            </td>
                            @else
                            <td>
                                {{ $client->engagementType ? $client->engagementType->name : '' }}
                                {{-- <livewire:global-components.inline-edit
                                    :model="'\\App\\Models\\Clients'"
                                    :entity="$client"
                                    :field="'engagement_type_id'"
                                    :key="'client-engagementType-'.$client->id"
                                    lineID="client-engagementType-{{ $client->id }}"
                                    type="select2"
                                    :optionsClass="'\\App\\Models\\EngagementType'"
                                /> --}}
                            </td>
                            @endif
                        </tr>
                        <tr>
                            <td class="w-1/2 font-bold">Report Status</td>
                            @if($editing)
                            <td>
                                {{-- <x-jet-input wire:model.delay="client.engagement_type" type="text" placeholder="Engagement Type" />
                                <x-validation-error field="client.engagement_type" /> --}}

                                <div class="flex space-x-1">
                                    <div class="w-full">
                                        <x-select2-multiple
                                            id="client-report-status-select2"
                                            wire:model="client.report_status_id"
                                            name="client-ReportStatus-select2"
                                            :options="$this->reportStatuses"
                                            placeholder="Please select an option"
                                        />
                                    </div>
                                    <x-button class="rounded-xl" wire:click="showDropDownModal('ReportStatus')">
                                        <x-icons.plus />
                                    </x-button>
                                </div>
                            </td>
                            @else
                            <td>{{ $client->reportStatus ? $client->reportStatus->name : '' }}</td>
                            @endif
                        </tr>
                        <tr>
                            <td class="w-1/2 font-bold">Report Notes</td>
                            @if($editing)
                            <td>
                                <x-textarea wire:model.delay="client.report_notes"></x-textarea>
                            </td>
                            @else
                            <td>
                                {{ $client->report_notes }}
                            </td>
                            @endif
                        </tr>
                        <tr>
                            <td class="w-1/2 font-bold">Rating Agency</td>
                            @if($editing)
                            <td>
                                {{-- <x-jet-input wire:model.delay="client.engagement_type" type="text" placeholder="Engagement Type" />
                                <x-validation-error field="client.engagement_type" /> --}}

                                <div class="flex space-x-1">
                                    <div class="w-full">
                                        <x-select2-multiple
                                            id="client-rating-agency-select2"
                                            wire:model="client.rating_agency_id"
                                            name="client-RatingAgency-select2"
                                            :options="$this->ratingAgencies"
                                            placeholder="Please select an option"
                                        />
                                    </div>
                                    <x-button class="rounded-xl" wire:click="showDropDownModal('RatingAgency')">
                                        <x-icons.plus />
                                    </x-button>
                                </div>
                            </td>
                            @else
                            <td>{{ optional($client->ratingAgency)->name }}</td>
                            @endif
                        </tr>
                        <tr>
                            <td class="w-1/2 font-bold">BEE Level</td>
                            @if($editing)
                            <td>
                                {{-- <x-jet-input wire:model.delay="client.engagement_type" type="text" placeholder="Engagement Type" />
                                <x-validation-error field="client.engagement_type" /> --}}

                                <div class="flex space-x-1">
                                    <div class="w-full">
                                        <x-select2-multiple
                                            id="client-bee-level-select2"
                                            wire:model="client.bee_level_id"
                                            name="client-BeeLevel-select2"
                                            :options="$this->beeLevels"
                                            placeholder="Please select an option"
                                        />
                                    </div>
                                    <x-button class="rounded-xl" wire:click="showDropDownModal('BeeLevel')">
                                        <x-icons.plus />
                                    </x-button>
                                </div>
                            </td>
                            @else
                            <td>{{ $client->beeLevel ? $client->beeLevel->name : '' }}</td>
                            @endif
                        </tr>
                        <tr>
                            <td class="w-1/2 font-bold">Size</td>
                            @if($editing)
                            <td>
                                {{-- <span>@error('client.size') <span class="text-red-500 text-sm error">{{ $message }}</span> @enderror</span> --}}
                                <div class="flex space-x-1">
                                    {{-- <x-select wire:model.delay="client.size">
                                        <option value="">Select an option</option>
                                        @foreach($this->sizes as $size)
                                        <option value="{{ $size->id }}">{{ $size->name }}</option>
                                        @endforeach
                                    </x-select> --}}
                                    <div class="w-full">
                                        <x-select2-multiple
                                            id="client-size-select2"
                                            wire:model="client.size"
                                            name="client-Size-select2"
                                            :options="$this->sizes"
                                            placeholder="Please select an option"
                                        />
                                    </div>
                                    <x-button class="rounded-xl" wire:click="showDropDownModal('Size')">
                                        <x-icons.plus />
                                    </x-button>
                                </div>
                            </td>
                            @else
                            <td>{{ optional($client->size)->name }}</td>
                            @endif
                        </tr>
                        <tr>
                            <td class="w-1/2 font-bold">Sector</td>
                            @if($editing)
                            <td>
                                <span>@error('client.sector') <span class="text-red-500 text-sm error">{{ $message }}</span> @enderror</span>
                                <div class="flex space-x-1">
                                    {{-- <x-select wire:model.delay="client.sector">
                                        <option value="">Select an option</option>
                                        @foreach($this->sectors as $sector)
                                        <option value="{{ $sector->id }}">{{ $sector->name }}</option>
                                        @endforeach
                                    </x-select> --}}
                                    <div class="w-full">
                                        <x-select2-multiple
                                            id="client-sector-select"
                                            wire:model="client.sector"
                                            name="client-Sector-select2"
                                            :options="$this->sectors"
                                            placeholder="Select an option"
                                        />
                                    </div>
                                    <x-button class="rounded-xl" wire:click="showDropDownModal('Sector')">
                                        <x-icons.plus />
                                    </x-button>
                                </div>
                            </td>
                            @else
                            <td>{{ optional($client->sector)->name }}</td>
                            @endif
                        </tr>
                        <tr>
                            <td class="w-1/2 font-bold">Region</td>
                            @if($editing)
                            <td>
                                <span>@error('client.region') <span class="text-red-500 text-sm error">{{ $message }}</span> @enderror</span>
                                <div class="flex space-x-1">
                                    {{-- <x-select wire:model.delay="client.region">
                                        <option value="">Select an option</option>
                                        @foreach($this->regions as $region)
                                        <option value="{{ $region->id }}">{{ $region->name }}</option>
                                        @endforeach
                                    </x-select> --}}
                                    <div class="w-full">
                                        <x-select2-multiple
                                            id="client-region-select"
                                            wire:model="client.region"
                                            name="client-Region-select2"
                                            :options="$this->regions"
                                            placeholder="Select an option"
                                        />
                                    </div>
                                    <x-button class="rounded-xl" wire:click="showDropDownModal('Region')">
                                        <x-icons.plus />
                                    </x-button>
                                </div>
                            </td>
                            @else
                            <td>{{ optional($client->region)->name }}</td>
                            @endif
                        </tr>
                        <tr>
                            <td class="w-1/2 font-bold">State</td>
                            @if($editing)
                            <td>
                                <span>@error('client.state') <span class="text-red-500 text-sm error">{{ $message }}</span> @enderror</span>
                                <div class="flex space-x-1">
                                    {{-- <x-select wire:model.delay="client.state">
                                        <option value="">Select an option</option>
                                        @foreach($this->states as $state)
                                        <option value="{{ $state->id }}">{{ $state->name }}</option>
                                        @endforeach
                                    </x-select> --}}
                                    <div class="w-full">
                                        <x-select2-multiple
                                            id="client-state-select"
                                            wire:model="client.state"
                                            name="client-State-select2"
                                            :options="$this->states"
                                            placeholder="Select an option"
                                        />
                                    </div>
                                    <x-button class="rounded-xl" wire:click="showDropDownModal('State')">
                                        <x-icons.plus />
                                    </x-button>
                                </div>
                            </td>
                            @else
                            <td>{{ optional($client->state)->name }}</td>
                            @endif
                        </tr>
                    </tbody>
                </table>
            </div>
            {{-- End client details block --}}

            {{-- Comment Section --}}
            @if(!$editing)
            <div class="bg-white p-8 rounded-xl">
                <livewire:global-components.comment-section :entity="$client" />
            </div>
            @endif
            {{-- End comment section --}}
        </div>
        {{-- End left column --}}

        {{-- Right Column --}}
        <div class="flex flex-col gap-4">
            {{-- Certificate --}}
            <?php /*
            @if($client->certificate_erp_key)
            <div class=" bg-white p-8 rounded-xl">
                <div class="space-y-4">
                    <div class="font-bold text-2xl flex flex-row justify-between items-center ">
                        <div>Certificate</div>
                        <div>
                            <x-buttons.flat wire:click="$emit('toggleCertModal')">
                                <x-slot name="icon">
                                    <x-icons.refresh />
                                </x-slot>
                                Replace
                            </x-buttons.flat>
                        </div>
                    </div>
                    <div class="flex flex-row items-center justify-start space-x-6">
                        <div class="bg-orange-50 px-1 rounded-lg">
                            <x-icons.certificate />
                        </div>

                        <table>
                            <tr>
                                <td class="font-bold">Name</td>
                                @if($editing)
                                <td><x-jet-input type="text" wire:model="current_cert.file_name" /></td>
                                @else
                                <td>{{ $current_cert->file_name }}</td>
                                @endif
                            </tr>
                            <tr>
                                <td class="font-bold">Expiry Date</td>
                                @if($editing)
                                <td><x-jet-input type="date" wire:model="current_cert.expiry_date" /></td>
                                @else
                                <td>{{ $current_cert->expiry_date }}</td>
                                @endif
                            </tr>
                            @if(!$editing)
                            <tr>
                                <td class="font-bold">Uploaded by</td>
                                <td>{{ $current_cert->user->name }}</td>
                            </tr>
                            @endif
                        </table>
                    </div>
                    <div class="pt-2">
                        <div class="font-bold">Comments</div>
                        @if($editing)
                        <x-textarea wire:model="current_cert.reviewer_comments" class="w-full" rows="6"></x-textarea>
                        @else
                        <div>
                            {{ $current_cert->reviewer_comments }}
                        </div>
                        @endif
                    </div>
                    <div class="flex flex-row justify-end pt-4">
                        @if(!$editing)
                        <x-buttons.download wire:click="downloadCertificate">Download</x-buttons.download>
                        @endif
                    </div>
                </div>
            </div>
            @else
            <div class=" bg-white rounded-xl text-center py-12 text-lg text-gray-700">
                No certificate uploaded for this client
            </div>
            @endif
            */ ?>

            <div class="bg-white rounded-xl p-8 flex flex-col gap-4">
                @if($client->certificate_erp_key)
                    {{-- Certificate header --}}
                    <div class="flex justify-between">
                        <div class="flex gap-2 items-center">
                            <x-icons.certificate size="50" />
                            <div class="font-bold text-lg">BBBEE Certificate</div>
                        </div>

                        <div>
                            @if (!$editing)
                            <x-jet-button>
                                <a href="{{ url('file-viewer/' . $client->certificate_erp_key) }}" target="_blank">View</a>
                            </x-jet-button>
                            <x-jet-button wire:click="$emit('toggleCertModal')">Replace</x-jet-button>
                            @endif
                        </div>
                    </div>
                    {{-- End certificate header --}}

                    {{-- Certificate body --}}
                    <div>
                        {{-- Fields --}}

                        <div class="grid grid-cols-2 mb-4">
                            <div>
                                <table>
                                    <tr>
                                        <td class="font-bold">Name</td>
                                        @if($editing)
                                        <td><x-jet-input type="text" wire:model="current_cert.file_name" /></td>
                                        @else
                                        <td>{{ $current_cert->file_name }}</td>
                                        @endif
                                    </tr>
                                    <tr>
                                        <td class="font-bold">Expiry Date</td>
                                        @if($editing)
                                        <td><x-jet-input type="date" wire:model="client.current_certificate_expiry" /></td>
                                        @else
                                        <td>{{ Carbon\Carbon::parse($client->current_certificate_expiry)->format('d M Y') }}</td>
                                        @endif
                                    </tr>
                                    @if(!$editing)
                                    <tr>
                                        <td class="font-bold">Uploaded by</td>
                                        <td>{{ optional($current_cert->user)->name }}</td>
                                    </tr>
                                    @endif
                                </table>
                            </div>

                            <div>
                                @if($isReplacing)
                                <x-input.filepond key="replace-certificate-fp" />
                                @endif
                            </div>
                        </div>
                        {{-- End fields --}}

                        {{-- Comments --}}
                        <div class="font-bold space-y-1">Comments</div>
                        <div>
                            @if($editing)
                            <x-textarea wire:model="current_cert.reviewer_comments" class="w-full" rows="6"></x-textarea>
                            @else
                            <div>
                                {{ $current_cert->reviewer_comments }}
                            </div>
                            @endif
                        </div>
                        {{-- End comments --}}
                    </div>
                    {{-- End certificate body --}}
                @else
                    <div class=" bg-white rounded-xl text-center py-12 text-lg text-gray-700">
                        No certificate uploaded for this client
                    </div>
                @endif
            </div>

            {{-- End certificate --}}

            {{-- Manager and analyst block --}}
            @if(!(Auth::user()->hasRole('Client') || Auth::user()->hasRole('Client Sub User')))
            <div class="flex flex-col lg:flex-row w-full gap-4">
                <x-user-block>
                    <x-slot name="title">Manager</x-slot>
                    @if($editing)
                    <x-slot name="editing">
                        <div class="flex flex-row space-x-1">
                            <x-select2-multiple
                                id="client-manager-select2"
                                wire:model="client.manager"
                                name="client-manager-select2"
                                :options="$this->allUsers"
                                placeholder="Select Manager"
                            />
                            @can('create users')
                            <x-jet-button wire:click="showUserModal('Manager')">
                                <x-icons.plus />
                            </x-jet-button>
                            @endcan
                        </div>
                    </x-slot>
                    @else
                        @if(!isset($client->manager))
                            <x-slot name="editing">
                                <div class="flex flex-row space-x-1">
                                    <x-select2-multiple
                                        id="client-manager-create-select2"
                                        wire:model="managerSelect"
                                        name="client-manager-create-select2"
                                        :options="$this->allUsers"
                                        placeholder="Select Manager"
                                    />
                                    <x-jet-button wire:click="setUser('m')">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-check" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                            <path d="M5 12l5 5l10 -10"></path>
                                        </svg>
                                    </x-jet-button>
                                </div>
                            </x-slot>
                        @else
                            <x-slot name="initials">{{ $this->generateInitials($client->manager()->name) }}</x-slot>
                            <x-slot name="userName">{{ optional($client->manager)->name }}</x-slot>
                            <x-slot name="userEmail">{{ $client->manager()->email }}</x-slot>
                        @endif
                    @endif
                </x-user-block>

                <x-user-block>
                    <x-slot name="title">Analyst</x-slot>
                    @if($editing)
                    <x-slot name="editing">
                        <div class="flex flex-row space-x-1">
                            <x-select2-multiple
                                id="client-analyst-select2"
                                wire:model="client.analyst"
                                name="client-analyst-select2"
                                :options="$this->allUsers"
                                placeholder="Select Analyst"
                            />
                            @can('create users')
                            <x-jet-button wire:click="showUserModal('Analyst')">
                                <x-icons.plus />
                            </x-jet-button>
                            @endcan
                        </div>
                    </x-slot>
                    @else
                        @if(!isset($client->analyst))
                            <x-slot name="editing">
                                <div class="flex flex-row space-x-1">
                                    <x-select2-multiple
                                        id="client-analyst-create-select2"
                                        wire:model="analystSelect"
                                        name="client-analyst-create-select2"
                                        :options="$this->allUsers"
                                        placeholder="Select Analyst"
                                    />
                                    <x-jet-button wire:click="setUser('a')">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-check" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                            <path d="M5 12l5 5l10 -10"></path>
                                        </svg>
                                    </x-jet-button>
                                </div>
                            </x-slot>
                        @else
                            <x-slot name="initials">{{ $this->generateInitials($client->analyst()->name) }}</x-slot>
                            <x-slot name="userName">{{ optional($client->analyst)->name }}</x-slot>
                            <x-slot name="userEmail">{{ $client->analyst()->email }}</x-slot>
                        @endif
                    @endif
                </x-user-block>
            </div>
            @endif
            {{-- End manager and analyst block --}}

            {{-- Contact block --}}
            @if(!(Auth::user()->hasRole('Client Sub User')))
            @if(isset($primaryContact))
                <x-primary-contact>
                <x-slot name="header">
                    <div class="font-bold">{{ optional($primaryContact)->firstname }} {{ optional($primaryContact)->lastname }}</div>
                    <div class="mb-4">{{ optional($primaryContact)->jobtitle }}</div>
                </x-slot>

                <x-slot name="buttons">
                    <x-jet-button>Email</x-jet-button>
                    <x-jet-button wire:click="contactRedirect({{ $primaryContact->id }})">View</x-jet-button>
                </x-slot>

                <x-slot name="attributes">
                    <div>{{ $primaryContact->email }}</div>
                    <div>{{ $primaryContact->phone_primary}}</div>
                    <div>{{ $primaryContact->phone_secondary}}</div>
                </x-slot>
            </x-primary-contact>
            @endif
            @endif
            {{-- End contact block --}}
        </div>
        {{-- End right column --}}
    </div>

    {{-- MODALS --}}
    {{-- Create dropdown item --}}
    <x-jet-dialog-modal wire:model="showCreateDropDownItemModal">
        <x-slot name="title">New {{ $dropDownModelName }}</x-slot>
        <x-slot name="content">
            <div>
                <x-jet-label for="name" value="Name" />
                <x-jet-input type="text" id="name" wire:model="newDropDownItemName" />
            </div>
        </x-slot>
        <x-slot name="footer">
            <div class="flex flex-row justify-end items-center gap-1">
                <x-buttons.cancel-button wire:click="$set('showCreateDropDownItemModal', false)">Cancel</x-buttons.cancel-button>
                <x-jet-button wire:click="newDropDownItem">Create</x-jet-button>
            </div>
        </x-slot>
    </x-jet-dialog-modal>

    {{-- Create user --}}
    <form name="create-user-form" class="space-y-4">
        <x-modal.dialog wire:model="showCreateUserModal">
            <x-slot name="title">
                Create {{ $newUserRole }}
            </x-slot>

            <x-slot name="content">
                <table class="border-separate [border-spacing:0.8rem]">
                    <tr>
                        <td class="w-1/2">
                            <span>@error('user.name') <span class="text-red-500 text-sm error">{{ $message }}</span> @enderror</span>&#x200B;
                            <x-jet-label for="name" value="Name" />
                            <x-jet-input wire:model="user.name" id="name" name="name" type="text" class="w-full"/>
                        </td>
                        <td class="w-1/2">
                            <span>@error('user.email') <span class="text-red-500 text-sm error">{{ $message }}</span> @enderror</span>&#x200B;
                            <x-jet-label for="email" value="Email" />
                            <x-jet-input wire:model="user.email" id="email" name="email" type="text" class="w-full"/>
                        </td>
                    </tr>
                    <tr>
                        <td class="w-1/2">
                            <span>@error('user.password') <span class="text-red-500 text-sm error">Password must contain at least 8 characters, an uppercase letter, a lowercase letter and a number</span> @enderror</span>&#x200B;
                            <x-jet-label for="password" value="Password" />
                            <x-jet-input wire:model="user.password" id="password" name="password" type="text" class="w-full"/>
                        </td>
                        <td>
                            @error('selectedRole') <span class="text-red-500 text-sm error">Please select a role</span> @enderror<span>&#x200B;
                            <x-jet-label for="role" value="Role" />
                            <x-jet-input name="role" type="text" disabled value="{{ $newUserRole }}" />
                        </td>
                    </tr>
                </table>
            </x-slot>

            <x-slot name="footer">
                <div class="flex flex-row items-center justify-end">
                    <x-buttons.cancel-button wire:click.prevent="$set('showCreateUserModal', false)">Cancel</x-buttons.cancel-button>
                    <x-create-button wire:click.prevent="createNewUser">Create</x-create-button>
                </div>
            </x-slot>
        </x-modal.dialog>
    </form>
    {{-- END MODALS --}}
</div>
