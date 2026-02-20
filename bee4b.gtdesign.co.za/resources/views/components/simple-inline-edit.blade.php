@props([
    'submit' => '',
    'name' => '',
    'permission' => ''
])

<div
    x-data="{
        isEditing: false,
    }"
    x-cloak
    >
    @if ($permission === '' || Auth::user()->hasPermissionTo($permission))
    <div x-show="!isEditing">
        <div x-on:click="isEditing = true" class="hover:underline cursor-pointer">
            <div class="text-gray-500 underline cursor-pointer">Set...</div>
        </div>
    </div>
    @endif

    <div x-show="isEditing">
        <form wire:submit.prevent="{{ $submit }}">
            <x-jet-input type="date" name="{{ $name }}" />
            <div class="flex flex-row">
                <button x-on:click.prevent="isEditing = false">
                    <x-icons.close />
                </button>
                <button type="submit">
                    <x-icons.check />
                </button>
            </div>
        </form>
    </div>
</div>