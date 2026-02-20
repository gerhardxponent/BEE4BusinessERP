<div class="relative">
    <div class="header grid grid-cols-2 my-4 items-center">
        <div>
            <div class="profile-header flex flex-row items-center space-x-4">
                <div class="profile-image rounded-md">
                    <div style="width:100px; height:100px;" class="bg-indigo-500 text-white rounded-md flex justify-center items-center">
                        <span class="text-4xl uppercase">
                            <div>{{ $this->generateInitials($client->name) }}</div>
                        </span>
                    </div>
                </div>
                <div class="profile-header-details flex flex-col align-middle justify-center">
                    <div class="text-2xl">
                        <livewire:global-components.inline-edit 
                            :model="'\\App\\Models\\Audit'"
                            :entity="$audit"
                            :field="'name'"
                            :key="'audit-'.$audit->id"
                            permission='edit audits'
                            regex="^[^_^\/^\\\\]*$"
                        />
                    </div>
                    <div class="text-gray-500">
                        <div>{{ $audit->created_at->format('Y-m-d') }}</div>
                        <a @can('view clients') href="../clients/{{ $client->id }}" @endcan class="underline hover:text-blue-600 cursor-pointer">{{ $client->name }}</a> 
                    </div>
                </div>
            </div>
        </div>

        <div class="flex flex-col items-end space-y-2">
            @if(session()->has('message'))
                <div class="px-3 py-1 rounded-md bg-green-100 text-green-800 text-sm">{{ session('message') }}</div>
            @endif
            <div class="flex items-center gap-2">
                @if(method_exists($audit, 'trashed') && $audit->trashed())
                    <span class="px-2 py-1 text-xs rounded bg-yellow-100 text-yellow-800">Archived</span>
                    <x-jet-button wire:click="restore">Restore</x-jet-button>
                @else
                    <x-jet-danger-button wire:click="archive">Archive</x-jet-danger-button>
                @endif
            </div>
        </div>

        <div class="rounded-2xl h-3/4 bg-gray-700" style="position: relative;background-color: rgb(245, 247, 249);">
{{-- Project Progress Section --}}
@if($audit->board_id && $this->projectProgress)
<div class="p-4" style="position: relative; height: 100%; background-color: rgb(245, 247, 249);">
    <div class="flex justify-between items-center mb-3">
        <h3 class="text-base font-bold text-gray-800">Project: {{ $this->projectProgress['project'] }}</h3>
        <a href="/projects/{{ $this->projectProgress['board_id'] }}" class="text-blue-600 hover:text-blue-800 text-xs font-medium">
            View →
        </a>
    </div>
    
    <div class="space-y-2">
        @foreach($this->projectProgress['categories'] as $category)
            <div class="flex items-center gap-3">
                {{-- Fixed Width Category Label (120px) --}}
                <div class="text-xs font-medium text-gray-700 text-right flex-shrink-0" style="width: 120px;">
                    {{ $category['category'] }}
                </div>
                
                {{-- Progress Bar (Rounded) --}}
                <div class="flex-1 h-6 bg-gray-200 rounded-full overflow-hidden flex">
                    @if($category['percent']['complete'] > 0)
                        <div 
                            class="bg-green-500 flex items-center justify-center text-white text-xs font-semibold"
                            style="width: {{ $category['percent']['complete'] }}%;"
                            title="Complete: {{ $category['counts']['complete'] }} ({{ $category['percent']['complete'] }}%)"
                        >
                            @if($category['percent']['complete'] >= 8)
                                {{ $category['counts']['complete'] }}
                            @endif
                        </div>
                    @endif
                    
                    @if($category['percent']['active'] > 0)
                        <div 
                            class="bg-blue-500 flex items-center justify-center text-white text-xs font-semibold"
                            style="width: {{ $category['percent']['active'] }}%;"
                            title="Active: {{ $category['counts']['active'] }} ({{ $category['percent']['active'] }}%)"
                        >
                            @if($category['percent']['active'] >= 8)
                                {{ $category['counts']['active'] }}
                            @endif
                        </div>
                    @endif
                    
                    @if($category['percent']['inactive'] > 0)
                        <div 
                            class="bg-gray-400 flex items-center justify-center text-white text-xs font-semibold"
                            style="width: {{ $category['percent']['inactive'] }}%;"
                            title="Inactive: {{ $category['counts']['inactive'] }} ({{ $category['percent']['inactive'] }}%)"
                        >
                            @if($category['percent']['inactive'] >= 8)
                                {{ $category['counts']['inactive'] }}
                            @endif
                        </div>
                    @endif
                    
                    @if($category['percent']['red_flag'] > 0)
                        <div 
                            class="bg-red-500 flex items-center justify-center text-white text-xs font-semibold"
                            style="width: {{ $category['percent']['red_flag'] }}%;"
                            title="Red Flag: {{ $category['counts']['red_flag'] }} ({{ $category['percent']['red_flag'] }}%)"
                        >
                            @if($category['percent']['red_flag'] >= 8)
                                {{ $category['counts']['red_flag'] }}
                            @endif
                        </div>
                    @endif
                </div>
                
                {{-- Fixed Width Total Count (40px) --}}
                <div class="text-xs font-semibold text-gray-700 text-right flex-shrink-0" style="width: 40px;">
                    {{ $category['total'] }}
                </div>
            </div>
        @endforeach
    </div>
    
    {{-- Compact Legend --}}
    <div class="mt-3 pt-2 flex justify-center gap-3 text-xs">
        <div class="flex items-center gap-1">
            <span class="w-2 h-2 bg-green-500 rounded"></span>
            <span class="text-gray-600">Done</span>
        </div>
        <div class="flex items-center gap-1">
            <span class="w-2 h-2 bg-blue-500 rounded"></span>
            <span class="text-gray-600">Active</span>
        </div>
        <div class="flex items-center gap-1">
            <span class="w-2 h-2 bg-gray-400 rounded"></span>
            <span class="text-gray-600">Inactive</span>
        </div>
        <div class="flex items-center gap-1">
            <span class="w-2 h-2 bg-red-500 rounded"></span>
            <span class="text-gray-600">Flag</span>
        </div>
    </div>
</div>
@else
{{-- No Project Linked Message (No Background) --}}
<div class="h-3/4 flex items-center justify-center" style="position: relative;background-color: rgb(245, 247, 249);">
    <div class="text-center text-gray-500">
        <div class="text-lg font-semibold mb-1">No Project Linked</div>
        <div class="text-sm">This audit does not have a project associated with it.</div>
    </div>
</div>
@endif
        </div>
    </div>

    <x-tabs.tab-layout>
        @foreach ($tabs as $tab)
            <x-tabs.tab 
                click="changeTab('{{ $tab }}')" 
                :current="$currentTab === $tab ? true : false"
            >
                {{ ucfirst($tab) }}
            </x-tabs.tab>
        @endforeach
    </x-tabs.tab-layout>

    <div class="w-full grid grid-cols-1 mt-4" wire:key="zmncxmn">
        @if($currentTab == 'details')
            <div class="w-full">
                <livewire:audit-management.components.audit-section 
                    id="{{ $audit->id }}" 
                    :searchTerm="$searchTerm"
                />
            </div>
        @endif

        @if($currentTab == 'edit-details')
            <div>
                @livewire('audit-management.edit-audit-details', ['auditId' => $audit->id], key('edit-audit-' . $audit->id))
            </div>
        @endif

        @if($currentTab == 'exports')
            <div>
                <livewire:audit-management.components.audit-export-table :audit="$audit" />
            </div>
        @endif

        <div wire:key="audit-activities-container">
            @if($currentTab == 'activity')
                <div wire:key="audit-details-activity-component">
                    <livewire:global-components.activity 
                        :activities="$activities" 
                        :showPath="true"
                        key="audit-activities"
                        :model="'App\\Models\\Audit'"
                        entityID="{{ $audit->id }}"
                    />
                </div>
            @endif
        </div>
    </div>
</div>
