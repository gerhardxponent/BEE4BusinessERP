<div class="space-y-4">
    <div class="flex items-center justify-between gap-3">
        <div class="flex items-center gap-3">
            <x-jet-checkbox wire:model="showInactive" />
            <span class="text-sm text-gray-700">Show inactive (hidden) fields</span>
        </div>

        <div class="w-72">
            <x-jet-input type="text" class="w-full" placeholder="Search fields…" wire:model.debounce.400ms="search" />
        </div>
    </div>

    @foreach ($folders as $folder)
        @php $fields = $grouped->get($folder->id) ?? collect(); @endphp
        @if($fields->isEmpty())
            @continue
        @endif

        <div class="bg-white rounded-lg border">
            <div class="px-4 py-2 border-b bg-gray-50 rounded-t-lg">
                <div class="font-bold text-gray-800">
                    {{ $folder->top_level ? $folder->top_level.' / ' : '' }}{{ $folder->name }}
                </div>
            </div>

            <div class="divide-y">
                @foreach ($fields as $field)
                    <div class="flex items-center justify-between px-4 py-2">
                        <div class="{{ $field->is_active ? '' : 'line-through text-gray-400' }}">
                            {{ $field->name }}
                            @if(!$field->is_active)
                                <span class="ml-2 text-xs bg-gray-200 text-gray-700 px-2 py-0.5 rounded">inactive</span>
                            @endif
                        </div>
                        <div class="flex items-center gap-2">
                            @if($field->is_active)
                                <x-buttons.delete-button wire:click="deactivateField({{ $field->id }})">Hide</x-buttons.delete-button>
                            @else
                                <x-jet-button wire:click="activateField({{ $field->id }})">Unhide</x-jet-button>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endforeach

    @if($folders->isEmpty() || $folders->sum(fn($f) => ($grouped->get($f->id) ?? collect())->count()) === 0)
        <div class="text-gray-500 text-center py-8">No fields found.</div>
    @endif
</div>
