<div class="relative">
    <x-toast.success-event />

    {{-- Head section --}}
    <div class="grid grid-cols-[0.8fr_2fr_0.8fr] gap-4 mb-8">
        {{-- Category name --}}
        <div>
            <div class="flex flex-row gap-4">
                <div class="w-20 h-20 bg-amber-400 rounded-md text-white p-4">
                    {!! isset($this->resourceCategory->icon->svg) ? $this->resourceCategory->icon->svg : '' !!}
                </div>
                <div class="flex flex-col justify-center gap-1">
                    <h1 class="text-xl font-bold">{{ $this->resourceCategory->name }}</h1>
                    <p class="text-gray-500 text-sm">{{ count($this->resourceCategory->resources) }} Resources</p>
                </div>
            </div>
        </div>
        {{-- End category name --}}

        {{-- Search  --}}
        <div class="flex flex-col items-center justify-end">
            <div class="w-3/4 sticky top-0 left-0">
                <x-search-clear wire:model="searchString" />
            </div>
        </div>
        {{-- End search --}}

        {{-- Create button --}}
        @can('create knowledge-panel')
        <div class="w-full flex justify-center items-end">
            <x-button wire:click="$set('showCreateTopicModal', true)">
                <div class="flex flex-row justify-start items-center gap-1">
                    <x-icons.plus />
                    <div>Add new topic</div>
                </div>
            </x-button>
        </div>
        @endcan
        {{-- End create button --}}
    </div>
    {{-- End head section --}}

    <div class="grid grid-cols-[0.8fr_2fr_0.8fr] gap-4">
        {{-- Filters --}}
        <div>
            <div class="bg-white p-4 rounded-lg space-y-4 sticky top-0 left-0">
                <div class="font-bold text-lg">Filters</div>

                <div class="space-y-2">
                    <div>
                        <x-jet-label for="users-select" value="Users" />
                        <x-select2-multiple
                            id="users-select"
                            wire:model="filters.users"
                            multiple
                            wire:key="users-select"
                            {{-- placeholder="Select User" --}}
                            >
                            @foreach (App\Models\User::all() as $user)
                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                            @endforeach
                        </x-select2-multiple>
                    </div>

                    <div>
                        <x-jet-label for="date-created-filter" value="Date Created" />
                        <x-date-range id="date-created-filter" wire:model.lazy="filters.date-created" :options="['mode' => 'range']" />
                    </div>

                    <div>
                        <x-jet-label for="date-updated-filter" value="Date Updated" />
                        <x-date-range id="date-updated-filter" wire:model.lazy="filters.date-updated" :options="['mode' => 'range']" />
                    </div>
                </div>
                
                <x-button wire:click="clearFilters">Clear filters</x-button>
            </div>
        </div>
        {{-- End filters --}}

        {{-- List of topics --}}
        <div class="flex flex-col items-center">
            <div class="w-full space-y-4">
                {{-- Resource cards --}}
                @forelse($this->resourceCategory->resources as $resource)
                <div class="flex flex-col justify-between gap-4 bg-white p-4 rounded-lg min-h-[210px] max-h-[210px]">
                    <div class="flex flex-col gap-2">
                        <div>
                            <a class="text-blue-600 text-lg hover:underline font-bold" href="./{{ $resource->resource_category_id }}/{{ $resource->id }}" >
                                {{ $resource->title }}
                            </a>
                            <div class="text-sm text-gray-500">
                                {{ $resource->created_at != $resource->updated_at ? 'Updated on ' . $resource->updated_at->format('d M Y, H:i') : '' }}
                            </div>
                        </div>
                        <div class="text-gray-600 break-all">
                            {{ strlen($resource->content) > 200 ? substr(strip_tags($resource->content), 0, 200) . "..." : strip_tags($resource->content) }}
                        </div>
                    </div>
                    
                    <div class="flex flex-row justify-between">
                        <div class="flex flex-row justify-start items-center gap-2">
                            <div class="text-sm font-bold bg-amber-500 text-white rounded-lg max-w-max px-4 py-1">Created by {{ isset($resource->user) ? $resource->user->name : 'Deleted User' }}</div>
                            <div class="text-sm text-gray-500">{{ $resource->created_at->format('Y/m/d') }}</div>
                        </div>
                        <div class="text-gray-500">{{ count($resource->comments) }} Comments</div>
                    </div>
                </div>
                @empty
                <div class="text-gray-400 text-xl py-10 flex flex-col justify-between items-center w-full">
                    There are no topics to show
                </div>
                @endforelse
                {{-- End resource cards --}}
            </div>
        </div>
        {{-- End list of topics --}}

        {{-- Users --}}
        <div>
            <div class="bg-white p-4 rounded-lg space-y-4">
                <div class="font-bold mb-2">Users</div>

                <div class="flex flex-col gap-2">
                    @foreach ($postingUsers as $user)
                        <div class="flex flex-row items-center justify-between pr-2">
                            <div class="flex flex-row items-center gap-1">
                                <div class="avatar mr-1 shadow-md border-2 border-white w-10 h-10 bg-indigo-200 text-base p-2 rounded-full flex items-center justify-center">
                                    <span class="font-bold text-black">
                                        {{ $this->generateInitials($user->name) }}
                                    </span>
                                </div>
                                <div>{{ $user->name }}</div>
                            </div>

                            <div class="font-bold text-indigo-600">
                                {{ count($user->resources) }}
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
        {{-- End users --}}
    </div>

    {{-- MODALS --}}
    <x-jet-dialog-modal wire:model="showCreateTopicModal">
        <x-slot name="title">Create new topic</x-slot>
        <x-slot name="content">
            <div class="space-y-4">
                <div>
                    <x-jet-label for="title" value="Title" />
                    <x-jet-input type="text" wire:model.defer="newTopic.title" />
                    <x-validation-error field="newTopic.title" />
                </div>

                <div>
                    <x-jet-label for="content" value="Content" />
                    <x-textarea rows="10" id="content" wire:model="newTopic.content" />
                    <x-validation-error field="newTopic.content" />
                </div>
            </div>
        </x-slot>
        <x-slot name="footer">
            <div class="flex flex-row items-center justify-end gap-1">
                <x-buttons.cancel-button x-on:click="show = false;">Cancel</x-buttons.cancel-button>
                <x-button wire:click="createTopic">Create</x-button>
            </div>
        </x-slot>
    </x-jet-dialog-modal>
    {{-- END MODALS --}}
</div>
