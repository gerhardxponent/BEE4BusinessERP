@if($archives)
<div x-data="{ archived: false, }">
    <x-button 
        x-on:click="() => { 
            archived = !archived;
            Livewire.emit('toggleShowDeleted')
        }"
        x-html="!archived ? 'Archived' : 'Active'"
        >
    </x-button>
</div>
@endif