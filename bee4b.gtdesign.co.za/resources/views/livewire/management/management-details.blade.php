<div class="relative space-y-4">
    {{-- <x-back>all Management Processes</x-back> --}}

    {{-- <div wire:ignore class="permissions-header transition-all text-2xl font-bold flex justify-between items-center rounded-xl top-0 left-0 z-[9999]"> --}}
    <div>
        <x-details-header>
            <x-slot name="initials">
                <div class="w-20 h-20">
                    {!! $managementProcess->icon->svg !!}
                </div>
            </x-slot>

            <x-slot name="headerDetails">
                <div class="text-2xl my-4">
                    <x-inline-edit
                        :original="$managementProcess->name"
                        model="ManagementProcess"
                        :entityId="$managementProcess->id"
                        field="name"
                        name="managementProcess-name"
                    />

                    {{-- {{ $managementProcess->name }} --}}
                </div>
            </x-slot>
        </x-details-header>
    </div>
    {{-- </div> --}}
    {{-- <div class="sential w-full h-0 opacity-0"></div> --}}

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

    @if ($currentTab === 'projects')
        <livewire:global-components.projects 
            :entity="$managementProcess" 
            activityPath="Management" 
        />
    @endif

    @if($currentTab === 'files')
        <div>
            <livewire:global-components.files-section 
                :entity="$managementProcess" 
                :model="'App\\Models\\ManagementProcess'" 
                :filePath="'Management/' . $managementProcess->name" 
            />
        </div>
    @endif

    @if ($currentTab === 'contacts')
        <livewire:contacts.contacts-table :entity="$managementProcess" />
    @endif

    @if($currentTab === 'activity')
        <livewire:global-components.activity 
            :model="'App\\Models\\ManagementProcess'"
            entityID="{{ $managementProcess->id }}"
            :showPath="true" 
        />
    @endif

    {{-- <script>
        const headerEl = document.querySelector('.permissions-header');
        const sentialEl = document.querySelector('.sential');
        const initalsBlock = document.querySelector('.initials-block');

        const handler = (entries) => {
            if (!entries[0].isIntersecting) {
                headerEl.classList.add('bg-indigo-500', 'text-white', 'shadow-lg', 'sticky');
                initalsBlock.classList.remove('flex');
                initalsBlock.classList.add('hidden');
            } else {
                headerEl.classList.remove('bg-indigo-500', 'text-white', 'shadow-lg', 'sticky');
                initalsBlock.classList.remove('hidden');
                initalsBlock.classList.add('flex');
            }
        }

        const observer = new window.IntersectionObserver(handler);
        observer.observe(sentialEl);
    </script> --}}
</div>
