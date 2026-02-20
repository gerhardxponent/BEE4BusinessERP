<div class="relative">
    @if (session()->has('message'))
        <x-toast.success message="{{ session('message') }}"></x-toast.success>
    @endif

    <div class="mt-4 space-y-2">
        <div class="flex items-center justify-between">
            <label class="inline-flex items-center gap-2 text-sm">
                <input type="checkbox" class="rounded border-gray-300" wire:model="showDeletedOnly">
                Show deleted users only
            </label>
        </div>

        <div class="mt-1">
            {{-- Pass flag into child AND force remount on change with a key --}}
            <livewire:users.user-table :show-deleted-only="$showDeletedOnly"
                :key="'users-table-' . (int) $showDeletedOnly" />
        </div>
    </div>



    <form name="create-user-form" class="space-y-4">
        <x-jet-dialog-modal wire:model="showCreateModal">
            <x-slot name="title">
                Create User
            </x-slot>

            <x-slot name="content">
                <table class="border-separate [border-spacing:0.8rem]">
                    <tr>
                        <td class="w-1/2">
                            <x-jet-label for="name" value="Name" />
                            <x-jet-input wire:model="user.name" id="name" name="name" type="text" class="w-full" />
                            <span>@error('user.name') <span class="text-red-500 text-sm error">{{ $message }}</span>
                            @enderror</span>&#x200B;
                        </td>
                        <td class="w-1/2">
                            <x-jet-label for="email" value="Email" />
                            <x-jet-input wire:model="user.email" id="email" name="email" type="text" class="w-full" />
                            <span>@error('user.email') <span class="text-red-500 text-sm error">{{ $message }}</span>
                            @enderror</span>&#x200B;
                        </td>
                    </tr>
                    <tr>
                        <td class="w-1/2">
                            <x-jet-label for="password" value="Password" />
                            <x-jet-input wire:model="user.password" id="password" name="password" type="text"
                                class="w-full" />
                            <span>
                                @error('user.password')
                                    <span class="text-red-500 text-sm error">
                                        Password must contain at least 4 characters
                                    </span>
                                @enderror
                            </span>&#x200B;
                        </td>
                        @if(auth()->user()->client_id)
                            <td style='display:none'>
                                <x-jet-label for="role" value="Role" />
                                <select id="role" wire:model="selectedRole" name="role"
                                    class="w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
                                    readonly>
                                    <option value="0">Select a Role</option>
                                    @foreach($roles as $role)
                                        <option value="{{ $role->id }}">{{ $role->name }}</option>
                                    @endforeach
                                </select>
                                @error('selectedRole') <span class="text-red-500 text-sm error">Please select a role</span>
                                @enderror<span>&#x200B;
                            </td>
                        @else
                            <td>
                                <x-jet-label for="role" value="Role" />
                                <select id="role" wire:model="selectedRole" name="role"
                                    class="w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
                                    readonly>
                                    <option value="0">Select a Role</option>
                                    @foreach($roles as $role)
                                        <option value="{{ $role->id }}">{{ $role->name }}</option>
                                    @endforeach
                                </select>
                                @error('selectedRole') <span class="text-red-500 text-sm error">Please select a role</span>
                                @enderror<span>&#x200B;
                            </td>
                        @endif
                    </tr>
                    @if($selectedRole == 17 || $selectedRole == 19)
                        <tr>
                            @if(auth()->user()->client_id)
                                <td style='display:none'>
                                    <x-jet-label for="client_id" value="Client" />
                                    <x-select id="client_id" wire:model="user.client_id">
                                        <option value="">Please select a client</option>
                                        @foreach (App\Models\Clients::all()->sortBy('name') as $client)
                                            <option value="{{ $client->id }}">{{ $client->name }}</option>
                                        @endforeach
                                    </x-select>
                                </td>
                            @else
                                <td>
                                    <x-jet-label for="client_id" value="Client" />
                                    <x-select id="client_id" wire:model="user.client_id">
                                        <option value="">Please select a client</option>
                                        @foreach (App\Models\Clients::all()->sortBy('name') as $client)
                                            <option value="{{ $client->id }}">{{ $client->name }}</option>
                                        @endforeach
                                    </x-select>
                                </td>
                            @endif
                        </tr>
                    @endif
                </table>
            </x-slot>

            <x-slot name="footer">
                <x-buttons.cancel-button
                    wire:click.prevent="$set('showCreateModal', false)">Cancel</x-buttons.cancel-button>
                <x-create-button id="create-user-submit" wire:click.prevent="submit">Create User</x-create-button>
            </x-slot>
        </x-jet-dialog-modal>
    </form>
</div>

@if(auth()->user()->client_id)
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Get the logged-in user's client_id directly from a data attribute or Blade
            const clientId = "{{ auth()->user()->client_id }}"; // Blade renders this on the server-side

            // Delay to populate and filter the role dropdown
            setTimeout(function () {
                const roleSelect = document.getElementById('role');
                const fixedRoleId = "19"; // Fixed Role ID as a string

                if (roleSelect) {
                    // Loop through options and remove any that don't match the fixed role ID
                    Array.from(roleSelect.options).forEach(option => {
                        if (option.value !== fixedRoleId) {
                            option.remove();
                        }
                    });

                    // Set the value to the fixed role ID
                    roleSelect.value = fixedRoleId;
                    roleSelect.dispatchEvent(new Event('change')); // Trigger change event for Livewire binding
                }
            }, 1000);

            // Delay to populate and filter the client_id dropdown
            setTimeout(function () {
                const clientSelect = document.getElementById('client_id');

                if (clientSelect) {
                    // Loop through options and remove any that don't match the user's client ID
                    Array.from(clientSelect.options).forEach(option => {
                        if (option.value !== clientId) {
                            option.remove();
                        }
                    });

                    // Set the value to the user's client ID
                    clientSelect.value = clientId;
                    clientSelect.dispatchEvent(new Event('change')); // Trigger change event for Livewire binding
                }
            }, 2000);
        });
    </script>
@endif