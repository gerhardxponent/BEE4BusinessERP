<div class="w-full grid grid-cols-1 lg:grid-cols-2 gap-4">
    <div class="space-y-4">
        {{-- Lead details --}}
        <div class="p-8 bg-white rounded-xl">
            <div class="font-bold text-lg mb-4 flex items-center justify-between">
                <div class="flex justify-between items-center w-full">
                    <div>Lead Details</div>
                    <div>
                        @if ($editing) 
                        <x-button wire:click="updateLead" colour="green">Save</x-button>
                        @endif
                        <x-button wire:click="toggleEdit">{{ !$editing ? 'Edit' : 'Cancel' }}</x-button>
                    </div>
                </div>
            </div>
            <table class="table-fixed">
                <tr>
                    <td class="font-bold">Name</td>
                    @if($editing)
                    <td>
                        <x-jet-input type="text" wire:model.defer="lead.name" />
                        <x-validation-error field="lead.name" />
                    </td>
                    @else
                    <td>{{ $lead->name }}</td>
                    @endif
                </tr>

                <tr>
                    <td class="font-bold">Primary Phone</td>
                    @if($editing)
                    <td>
                        <x-jet-input type="text" wire:model.defer="lead.primary_phone" />
                        <x-validation-error field="lead.primary_phone" />
                    </td>
                    @else
                    <td>{{ $lead->primary_phone }}</td>
                    @endif
                </tr>

                <tr>
                    <td class="font-bold">Secondary Phone</td>
                    @if($editing)
                    <td><x-jet-input type="text" wire:model.defer="lead.secondary_phone" /></td>
                    @else
                    <td>{{ $lead->secondary_phone }}</td>
                    @endif
                </tr>

                <tr>
                    <td class="font-bold">Email Address</td>
                    @if($editing)
                    <td>
                        <x-jet-input type="text" wire:model.defer="lead.email_address" />
                    </td>
                    @else
                    <td>{{ $lead->email_address }}</td>
                    @endif
                </tr>

                <tr>
                    <td class="font-bold">Company Name</td>
                    @if($editing)
                    <td>
                        <x-jet-input type="text" wire:model.defer="lead.company_name" />
                    </td>
                    @else
                    <td>{{ $lead->company_name }}</td>
                    @endif
                </tr>

                <tr>
                    <td class="font-bold">Website</td>
                    @if($editing)
                    <td><x-jet-input type="text" wire:model.defer="lead.website" /></td>
                    @else
                    <td>
                        <a href="{{ $lead->website }}" target="_blank" class="table-link">{{ $lead->website }}</a>
                    </td>
                    @endif
                </tr>

                <tr>
                    <td class="font-bold">Industry</td>
                    @if($editing)
                    <td>
                        <x-select2-multiple wire:model.defer="lead.sector_id" wire:key="set-sector" id="sector">
                            <option value="">Select sector</option>
                            @foreach(App\Models\Sector::all() as $sector)
                            <option value="{{ $sector->id }}">{{ $sector->name }}</option>
                            @endforeach
                        </x-select2-multiple>
                    </td>
                    @else
                    <td>{{ isset($lead->sector->name) ? $lead->sector->name : '' }}</td>
                    @endif
                </tr>

                <tr>
                    <td class="font-bold">Enquiry</td>
                    @if($editing)
                    <td><x-jet-input type="text" wire:model.defer="lead.enquiry" /></td>
                    @else
                    <td>{{ $lead->enquiry }}</td>
                    @endif
                </tr>

                <tr>
                    <td class="font-bold">Source</td>
                    @if($editing)
                    <td><x-jet-input type="text" wire:model.defer="lead.source" /></td>
                    @else
                    <td>{{ $lead->source }}</td>
                    @endif
                </tr>

                <tr>
                    <td class="font-bold align-top">Description</td>
                    @if($editing)
                    <td><x-textarea wire:model.defer="lead.description" rows="6"></x-textarea></td>
                    @else
                    <td>{{ $lead->description }}</td>
                    @endif
                </tr>

                <tr>
                    <td class="font-bold align-top">Address</td>
                    @if($editing)
                    <td><x-jet-input type="text" wire:model.defer="lead.address" /></td>
                    @else
                    <td>{{ $lead->address }}</td>
                    @endif
                </tr>

                <tr>
                    <td class="font-bold align-top">City</td>
                    @if($editing)
                    <td><x-jet-input type="text" wire:model.defer="lead.city" /></td>
                    @else
                    <td>{{ $lead->city }}</td>
                    @endif
                </tr>

                <tr>
                    <td class="font-bold align-top">Province</td>
                    @if($editing)
                    <td><x-jet-input type="text" wire:model.defer="lead.province" /></td>
                    @else
                    <td>{{ $lead->province }}</td>
                    @endif
                </tr>

                <tr>
                    <td class="font-bold align-top">Country</td>
                    @if($editing)
                    <td><x-jet-input type="text" wire:model.defer="lead.country" /></td>
                    @else
                    <td>{{ $lead->country }}</td>
                    @endif
                </tr>
            </table>
        </div>
        {{-- End lead details --}}

        {{-- Comment section --}}
        <div class="p-8 bg-white rounded-xl space-y-4">
            <livewire:global-components.comment-section :entity="$lead" />
        </div>
        {{-- End comment section --}}
    </div>

    <div class="space-y-4">
        {{-- Upcoming consultations --}}
        <div class="bg-white p-8 rounded-xl">
            <div class="font-bold text-lg mb-2 flex items-center justify-between">
                @php 
                    $count = count($this->consultations);
                    $count > 5 ? $count = $count . '+' : $count;
                @endphp
                <div>
                    {{ $count }} Upcoming Consultations
                </div>
                <div>
                    <x-buttons.flat wire:click="$emit('changeTab', 'consultations')">
                        View all
                        <x-slot name="trailingIcon">
                            <x-icons.right-arrow />
                        </x-slot>
                    </x-buttons.flat>
                </div>
            </div>
            <div class="space-y-2">
                @forelse ($this->consultations as $index => $consultation)
                    <div>
                        <div class="flex items-center gap-1">
                            <div>{{ $consultation->name }}</div>
                            @if (Carbon\Carbon::parse($consultation->consultationdate) == Carbon\Carbon::today())
                            <div class="text-red-800 font-bold text-sm bg-red-100 px-2 rounded-full">Today</div>
                            @endif
                        </div>
                        <div class="text-gray-600 text-sm">
                            {{ Carbon\Carbon::parse($consultation->consultationdate)->format('d M Y') }}, 
                            {{ Carbon\Carbon::parse($consultation->starttime)->format('H:i') }} -
                            {{ Carbon\Carbon::parse($consultation->endtime)->format('H:i') }}
                        </div>
                    </div>
                @empty
                    <div class="text-gray-600 text-center py-4">
                        There are no upcoming consultations
                    </div>
                @endforelse
            </div>
        </div>
        {{-- End upcoming consultations --}}

        {{-- Tasks --}}
        <div class="bg-white p-8 rounded-xl">
            <div class="font-bold text-lg mb-4 flex items-center justify-between">
                <div>
                    Tasks
                </div>
                <div>
                    <x-buttons.flat wire:click="$emit('changeTab', 'projects')">
                        View all
                        <x-slot name="trailingIcon">
                            <x-icons.right-arrow />
                        </x-slot>
                    </x-buttons.flat>
                </div>
            </div>
            <div class="space-y-4">
                @foreach ($this->projects as $project)
                    <div>
                        <div>
                            <div class="relative overflow-x-auto">
                                <table class="table-fixed rounded-corners w-full text-sm text-left text-gray-500">
                                    <thead class="text-xs text-gray-700 uppercase bg-gray-100">
                                        <tr>
                                            <th class="bg-gray-500 rounded-t-md py-2 text-white text-center" colspan="3">
                                                {{ $project->name }}
                                            </th>
                                        </tr>
                                        <tr>
                                            <th scope="col" class="px-6 py-2">
                                                Task
                                            </th>
                                            <th scope="col" class="px-6 py-2">
                                                Due Date
                                            </th>
                                            <th scope="col" class="px-6 py-2">
                                                Priority
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($project->boardItems as $task)
                                        <tr>
                                            <td scope="row" class="px-6 py-4 font-medium text-gray-900">
                                                {{ $task->name }}
                                            </td>
                                            <td scope="row" class="px-6 py-4 font-medium text-gray-900">
                                                {{ $task->deadline }}
                                            </td>
                                            <td scope="row" class="px-6 py-4 font-medium text-gray-900">
                                                {{ $task->priorityForeign->name }}
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        {{-- End tasks --}}

        {{-- Recent Activity --}}
        <div class="bg-white p-8 rounded-xl">
            <div class="font-bold text-lg mb-2 flex items-center justify-between">
                <div>Recent Activity</div>
                <div>
                    <x-buttons.flat wire:click="$emit('changeTab', 'activity')">
                        View all
                        <x-slot name="trailingIcon">
                            <x-icons.right-arrow />
                        </x-slot>
                    </x-buttons.flat>
                </div>
            </div>

            <livewire:global-components.activity 
                itemsPerPage="5"
                :showPages="false"
                :showHeader="false"
                :showPath="false"
                :model="'App\\Models\\Lead'"
                entityID="{{ $lead->id }}"
            />
        </div>
        {{-- End recent Activity --}}
    </div>
</div>