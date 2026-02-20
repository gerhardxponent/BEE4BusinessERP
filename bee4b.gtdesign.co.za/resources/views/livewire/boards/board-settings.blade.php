<div>
    <div>
        <a href="../boards/{{ $board->id }}">
            <div class="flex flex-row space-x-2 text-indigo-600 hover:underline cursor-pointer items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-arrow-left" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                    <line x1="5" y1="12" x2="19" y2="12"></line>
                    <line x1="5" y1="12" x2="11" y2="18"></line>
                    <line x1="5" y1="12" x2="11" y2="6"></line>
                </svg>
                <span class="font-bold text-lg">Back to {{ $board->name }}</span>
            </div>
        </a>
    </div>

    <div class="w-full space-y-4 mt-4">
        <div class="w-full">
            <x-jet-label for="name" value="Board Name" />
            <x-jet-input type="text" wire:model.defer="board.name" />
        </div>

        <div>
            <x-jet-label for="contributers" value="Contributers" />
            <div wire:ignore>
                <select id="contributers" style="width: 100%;" multiple>
                    @foreach($allUsers as $user)
                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        
        <h1 class="text-2xl"><strong>Permissions</strong></h1>
        <div>
            <div class="user-permissions space-y-2">
                <form wire:submit.prevent="submit(Object.fromEntries(new FormData($event.target)))" class="space-y-3">
                    <div class="not-prose relative bg-slate-50 rounded-xl overflow-hidden dark:bg-slate-800/25">
                        <div style="background-position:10px 10px" class="absolute inset-0 bg-grid-slate-100 [mask-image:linear-gradient(0deg,#fff,rgba(255,255,255,0.6))] dark:bg-grid-slate-700/25 dark:[mask-image:linear-gradient(0deg,rgba(255,255,255,0.1),rgba(255,255,255,0.5))]"></div>
                        <div class="relative rounded-xl overflow-auto">
                            <div class="shadow-sm overflow-hidden my-8">
                                <table class="border-collapse table-auto w-full text-sm">
                                    <thead>
                                        <tr>
                                            <th class="border-b dark:border-slate-600 font-medium p-4 pl-8 pt-0 pb-3 text-slate-400 dark:text-slate-200 text-left">User</th>
                                            <th class="border-b dark:border-slate-600 font-medium p-4 pl-8 pt-0 pb-3 text-slate-400 dark:text-slate-200 text-left">Create Items</th>
                                            <th class="border-b dark:border-slate-600 font-medium p-4 pl-8 pt-0 pb-3 text-slate-400 dark:text-slate-200 text-left">Edit Items</th>
                                            <th class="border-b dark:border-slate-600 font-medium p-4 pl-8 pt-0 pb-3 text-slate-400 dark:text-slate-200 text-left">Delete Items</th>
                                            <th class="border-b dark:border-slate-600 font-medium p-4 pl-8 pt-0 pb-3 text-slate-400 dark:text-slate-200 text-left">Upload Files</th>
                                            <th class="border-b dark:border-slate-600 font-medium p-4 pl-8 pt-0 pb-3 text-slate-400 dark:text-slate-200 text-left">Delete Files</th>
                                            <th class="border-b dark:border-slate-600 font-medium p-4 pl-8 pt-0 pb-3 text-slate-400 dark:text-slate-200 text-left">Post Comments</th>
                                            <th class="border-b dark:border-slate-600 font-medium p-4 pl-8 pt-0 pb-3 text-slate-400 dark:text-slate-200 text-left">Delete Any Comments</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white dark:bg-slate-800">
                                        @foreach($contributers as $contributer)
                                        <tr>
                                            <td class="border-b border-slate-100 dark:border-slate-700 p-4 pl-8 text-slate-500 dark:text-slate-400">{{$contributer->name}}</td>
                                            @foreach($operations as $index => $op)
                                            <td class="border-b border-slate-100 dark:border-slate-700 p-4 pl-8 text-slate-500 dark:text-slate-400">
                                                <input
                                                    name="{{ $contributer->id . ';' . $index }}"
                                                    @if($contributer->hasPermissionTo($board->name . '-' . $op)) checked @endif 
                                                    value="{{ $board->name . '-' . $op }}"
                                                    class="disabled:bg-gray-400 disabled:cursor-not-allowed  form-check-input appearance-none h-4 w-4 border border-gray-300 rounded-sm bg-white focus:outline-none transition duration-200 mt-1 align-top bg-no-repeat bg-center bg-contain float-left mr-2 cursor-pointer " 
                                                    type="checkbox" 
                                                    id="inlineCheckbox2"
                                                    wire:click="check({{ $contributer->id }}, '{{ $op }}')" />
                                            </td>
                                            @endforeach
                                        </tr>        
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="absolute inset-0 pointer-events-none border border-black/5 rounded-xl dark:border-white/5"></div>
                    </div>
                </form>
            </div>
        </div>

        <div>
            <x-jet-button wire:click="save">Save</x-jet-button>
            <x-jet-button wire:click="$set('confirmDelete', true)">Delete</x-jet-button>
        </div>
    </div>

    <x-jet-confirmation-modal wire:model="confirmDelete">
        <x-slot name="title">Delete Board</x-slot>

        <x-slot name="content">Are you sure you would like to delete this board?</x-slot>

        <x-slot name="footer">
            <div>
                <x-buttons.cancel-button wire:click="$set('confirmDelete', false)">Cancel</x-buttons.cancel-button>
                <x-buttons.delete-button wire:click="deleteBoard">Delete</x-buttons.delete-button>
            </div>
        </x-slot>
    </x-jet-dialog-modal>

    <script>
        $(document).ready(function() {
            $('#contributers').select2({
                multiple: true,
            });

            $('#contributers').val(@this.contributerIds).trigger('change');

            $('#contributers').on('change', function() {
                var data = $('#contributers').select2('val');
                @this.set('contributerIds', data);
            });
        })
    </script>
</div>
