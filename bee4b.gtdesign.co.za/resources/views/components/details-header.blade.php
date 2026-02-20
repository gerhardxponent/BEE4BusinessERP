<div class="header grid grid-cols-2">
    <div>
        <div class="profile-header flex flex-row space-x-4">
            <div class="profile-image rounded-md">
                <div style="width:100px; height:100px;" class="{{ $bgColor ?? 'bg-indigo-500' }} initials-block text-white rounded-md flex justify-center items-center">
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
        <div class="button-container gap-1 flex flex-col md:flex-row">
            {{-- <x-jet-button>Email</x-jet-button>
            <x-jet-button>Edit</x-jet-button>
            <x-jet-button>Delete</x-jet-button> --}}
            {{ $headerButtons ?? '' }}
        </div>
    </div>
</div>