<div>
    <main class="space-y-4">
        <div class="w-full flex justify-center">
            <x-tabs.tab-layout>
                @foreach ($tabs as $tab)
                    <x-tabs.tab 
                        :current="$currentTab === $tab ? true : false"
                        click="changeTab('{{ $tab }}')"
                    >
                        {{ ucfirst($tab) }}
                    </x-tabs.tab>
                @endforeach
            </x-tabs.tab-layout>
        </div>

        @if($currentTab == "tasks")
        <div class="grid grid-cols-3 gap-4 w-full">
            @foreach ($this->chartData as $index => $client)
                @php $currentChart = $this->allChartData($client->boardsMorph->last()); @endphp

                <div class="bg-white border border-gray-200 p-6">
                    <div class="flex justify-between items-center">
                        <div class="flex gap-2">
                            <div class="bg-indigo-600 text-white p-4 w-12 h-12 flex justify-center items-center text-xl rounded">
                                <div>{{ $this->generateInitials($client->name) }}</div>
                            </div>
                            <div class="flex flex-col justify-center">
                                <div class="text-xl">{{ $client->name }}</div>
                                <div class="text-gray-500 text-sm">{{ $currentChart["remainingCount"] }} Tasks remaining</div>
                            </div>
                        </div>

                        <div wire:click="clientRedirect({{ $client->id }})" class="text-gray-600 flex items-center gap-1 hover:bg-gray-100 px-3 py-2 rounded cursor-pointer active:bg-gray-200 text-sm">
                            <div>View All</div>
                            <x-icons.right-arrow size="20" />
                        </div>
                    </div>
                    <div class="w-full flex justify-center">
                        <x-charts.donut 
                            id="donut{{ $index }}" 
                            :allChartData="$currentChart"
                        />
                    </div>
                </div>
            @endforeach

            {{-- <div class="bg-white border border-gray-200 p-6">
                <x-charts.donut id="donut2" />
            </div>

            <div class="bg-white border border-gray-200 p-6">
                <x-charts.donut id="donut3" />
            </div> --}}
        </div>
        @endif

        @if($currentTab == "audits")
            @can('view audits')
            <div>
                <livewire:dashboard.components.audit-dashboard />
            </div>
            @endcan
        @endif

        {{-- CLIENTS (new) --}}
        @if($currentTab == "clients")
            {{-- Our new overview --}}
            <livewire:projects-task-category-overview />
        @endif
    </main>


</div>
