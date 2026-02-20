<div>
    <div>
        <a href="./">
            <div class="flex flex-row space-x-2 text-indigo-600 hover:underline cursor-pointer items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-arrow-left" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                    <line x1="5" y1="12" x2="19" y2="12"></line>
                    <line x1="5" y1="12" x2="11" y2="18"></line>
                    <line x1="5" y1="12" x2="11" y2="6"></line>
                </svg>
                <span class="font-bold text-lg">Back to My Boards</span>
            </div>
        </a>
    </div>

    <div class="w-1/2 space-y-4 mt-4">
        <div class="w-full">
            <x-jet-label for="name" value="Board Name" />
            <x-jet-input type="text" wire:model.defer="board.name" />
            <span>@error('board.name') <span class="text-rose-600 text-sm error">{{ $message }}</span> @enderror</span>
        </div>

        <div class="space-y-2">
            <div>
                <x-jet-label for="contributers-create" value="Contributers" />
                <div wire:ignore>
                    <select id="contributers-create" style="width: 100%;" multiple>
                        @foreach($allUsers as $user)
                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <x-jet-button wire:click="addAllUsers">Add all users</x-jet-button>
        </div>

        <x-jet-button wire:click="save">Save</x-jet-button>
    </div>

    
    <script>
        $(document).ready(function() {
            $('#contributers-create').select2({
                multiple: true,
                placeholder: 'Add Contributers'
            });

            $('#contributers-create').val([@this.currentUserId]).trigger('change');
            @this.set('contributerIds', [@this.currentUserId]);

            $('#contributers-create').on('change', function() {
                var data = $('#contributers-create').select2('val');
                @this.set('contributerIds', data);
            });

            Livewire.on('usersAdded', () => {
                $('#contributers-create').val(@this.contributerIds).trigger('change');
            });
        })
    </script>
</div>
