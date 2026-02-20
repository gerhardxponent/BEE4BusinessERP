<div>
    <x-header>
        <x-slot name="title">Create Project</x-slot>
    </x-header>
    <x-header :breadcrumbs="$breadcrumbs"/>

    <x-slot name="title">Create Project</x-slot>
    <div>
        <form class="space-y-2">
            <div>
                <x-jet-label for="name" value="Project Name" />
                <x-jet-input wire:model.delay="client.name" id="name" type="text" />
            </div>
        </form>
    </div>
</div>
