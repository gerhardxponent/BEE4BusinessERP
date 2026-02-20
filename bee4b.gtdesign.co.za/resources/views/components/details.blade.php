<div class="main-content space-y-4 relative">
    <div class="header grid grid-cols-2">
        <div>
            <div class="profile-header flex flex-row space-x-4">
                <div class="profile-image rounded-md">
                    <div style="width:100px; height:100px;" class="{{ $bgColor ?? 'bg-indigo-500'}} text-white rounded-md flex justify-center items-center">
                        <span class="text-4xl uppercase">{{ $initials ?? '' }}</span>
                    </div>
                </div>
                <div class="profile-header-details flex flex-col align-middle justify-center">
                    {{-- <div class="font-bold text-xl">{{ $client->name }}</div>
                    <div class="text-gray-500">{{ $client->email }}</div>
                    <div class="text-gray-500">{{ $client->phone }}</div> --}}
                    {{ $headerDetails }}
                </div>
            </div>
        </div>
        <div class="grid grid-cols-1 content-center justify-items-end align-middle h-full">
            <div class="button-container gap-1 flex items-center">
                {{-- <x-jet-button>Email</x-jet-button>
                <x-jet-button>Edit</x-jet-button>
                <x-jet-button>Delete</x-jet-button> --}}
                {{ $headerButtons ?? '' }}
            </div>
        </div>
    </div>

    {{-- For use with intersection obserever --}}
    {{ $sential ?? '' }}

    @if(isset($tabs))
        <x-tabs.tab-layout>
            {{ $tabs ?? '' }}
        </x-tabs.tab-layout>
    @endif

    {{-- <div>{{ $tabs ?? '' }}</div> --}}

    <div class="w-full grid grid-cols-1 detail-section mt-4">
        @yield('fullWidth')
    </div>

    @if(isset($leftColum) || isset($rightColumn))
    <div class="w-full grid grid-cols-1 lg:grid-cols-2 gap-4 detail-section">
        <div class="left-column space-y-4">
            {{ $leftColumn ?? '' }}
        </div>

        <div class="right-column space-y-4">
            {{ $rightColumn ?? '' }}
        </div>
    </div>
    @endif

    @if(isset($column1) || isset($column2) || isset($column3))
    <div class="w-full grid grid-cols-1 lg:grid-cols-3 gap-4 detail-section">
        <div class="space-y-4">
            {{ $column1 ?? '' }}
        </div>

        <div class="space-y-4">
            {{ $column2 ?? '' }}
        </div>

        <div class="space-y-4">
            {{ $column3 ?? '' }}
        </div>
    </div>
    @endif
</div>