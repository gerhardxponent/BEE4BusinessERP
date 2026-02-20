<div class="relative h-full">
    <x-toast.success-event />

    <div class="w-[200px] h-[200px] opacity-100 border-2 border-amber-300 rounded-full absolute -translate-x-1/2 -translate-y-1/2 left-1/2 top-1/2 z-10"></div>
    <div class="w-[400px] h-[400px] opacity-75 border-2 border-amber-300 rounded-full absolute -translate-x-1/2 -translate-y-1/2 left-1/2 top-1/2 z-10"></div>
    <div class="w-[600px] h-[600px] opacity-50 border-2 border-amber-300 rounded-full absolute -translate-x-1/2 -translate-y-1/2 left-1/2 top-1/2 z-10"></div>
    <div class="w-[800px] h-[800px] opacity-25 border-2 border-amber-300 rounded-full absolute -translate-x-1/2 -translate-y-1/2 left-1/2 top-1/2 z-10"></div>

    {{-- Knowledge panel header --}}
    <div class="relative z-20">
        <div class="w-full my-10 flex flex-col gap-4 justify-center items-center">
            <div class="text-indigo-500 font-bold">Curated</div>
            <div class="text-6xl font-bold">BBBEE Resources</div>
            <div class="text-sm">At your fingertips</div>
            @can('create knowledge-panel')
            <x-button wire:click="$set('showCreateCategoryModal', true)">Create Category</x-button>
            @endcan
        </div>
    </div>
    {{-- End knowledge panel header --}}

    {{-- Categories --}}
    <div class="mt-4 w-full relative grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-4 z-[9999]">
        @foreach ($this->resourceCategories as $category)
            <a href="./resources/{{ $category->id }}">
                <div class="bg-white shadow rounded-lg p-4 sm:p-6 xl:p-8 hover:scale-[1.03] transition-all hover:shadow-lg">
                    <div class="flex flex-row gap-4">
                        <div class="w-20 h-20 bg-amber-400 rounded-md text-white p-4">
                            {!! isset($category->icon->svg) ? $category->icon->svg : '' !!}
                        </div>
                        <div class="flex flex-col justify-center gap-1">
                            <h1 class="text-xl">{{ $category->name }}</h1>
                            <p class="text-gray-500 text-sm">{{ count($category->resources) }} Resources</p>
                        </div>
                    </div>
                </div>
            </a>
        @endforeach
    </div>    
    {{-- End categories --}}

    {{-- MODALS --}}
    <x-jet-dialog-modal wire:model="showCreateCategoryModal">
        <x-slot name="title">New Management Process</x-slot>
        <x-slot name="content">
            <div class="space-y-4">
                <div>
                    <x-jet-label for="name" value="Name" />
                    <x-jet-input type="text" id="name" wire:model.defer="newCategory.name" />
                    <span>@error('newCategory.name') <span class="text-red-500">{{ $message }}</span> @enderror</span>
                </div>

                <div class="flex flex-row gap-4">
                    <div>
                        <x-jet-label for="icon" value="Icon" />
                        <div
                            style="max-height: 140px;" 
                            id="icon" 
                            class="bg-white grid grid-cols-5 gap-2 p-2 overflow-y-scroll border border-gray-300 rounded-md"
                            >
                            @foreach ($icons as $icon)
                                <div 
                                    wire:click="$set('newCategory.icon_id', {{ $icon->id }})"
                                    class="
                                        w-11 h-11 border border-gray-300 p-1 rounded-md active:scale-[0.9] active:bg-gray-100 transition-all cursor-pointer
                                        @if($newCategory->icon_id === $icon->id) bg-amber-500 text-white @endif
                                    "
                                    >
                                    {!! $icon->svg !!}
                                </div>
                            @endforeach
                        </div>
                        <span>@error('newCategory.icon_id') <span class="text-red-500">{{ $message }}</span> @enderror</span>
                    </div>
                </div>
            </div>
        </x-slot>
        <x-slot name="footer">
            <div class="flex flex-row items-center justify-end gap-1">
                <x-buttons.cancel-button x-on:click="show = false">Cancel</x-buttons.cancel-button>
                <x-jet-button wire:click="createCategory">Create</x-jet-button>
            </div>
        </x-slot>
    </x-jet-dialog-modal>
    {{-- END MODALS --}}
</div>
