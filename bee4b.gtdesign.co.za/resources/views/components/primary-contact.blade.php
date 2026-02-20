<div class="grid grid-cols-2 bg-white px-10 py-8 rounded-xl">
    <div>
        {{-- <div class="font-bold">{{ $primaryContact->firstname }}</div>
        <div class="mb-4">{{ $primaryContact->jobtitle }}</div> --}}
        {{ $header }}

        {{-- <div>
            <x-jet-button>Email</x-jet-button>
            <x-jet-button>View</x-jet-button>
        </div> --}}
        <div class="contact-button-container">
            {{ $buttons }}
        </div>
    </div>
    <div class="grid grid-cols-2">
        <div class="grid grid-rows-3">
            <div>Email Address</div>
            <div>Phone 1</div>
            <div>Phone 2</div>
        </div>
        <div class="grid grid-rows-3">
            {{-- <div>{{ $primaryContact->email }}</div>
            <div>{{ $primaryContact->phone_primary}}</div>
            <div>{{ $primaryContact->phone_secondary}}</div> --}}

            {{ $attributes }}
        </div>
    </div>
</div>