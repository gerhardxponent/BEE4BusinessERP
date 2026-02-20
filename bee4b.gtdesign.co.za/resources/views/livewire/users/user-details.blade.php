<div class="relative">
    {{-- Notifications --}}
    <div class="fixed z-50 top-20 right-5 space-y-4">
        @if (session()->has('success_message'))
        <x-toast.success message="{{ session('success_message') }}" />
        @endif

        @if(session()->has('error_message'))
        <x-toast.success message="{{ session('error_message') }}" />
        @endif
    </div>
    {{-- End notifications --}}

    <style>
        .active-tab,
        .active-tab:active {
            /* background-color: rgb(54,97,235);
            color: white; */
            background-color: white;
            color: black;
        }

        .tab-container:active {
            background-color: var(--color-gray-300);
        }
    </style>

    <x-details>
        <x-slot name="initials">{{ $this->generateInitials($user->name) }}</x-slot>

        <x-slot name="headerDetails">
            <div class="font-bold text-xl">{{ $user->name }}</div>
            <div class="text-gray-600">{{ $user->email }}</div>
        </x-slot>

        <x-slot name="headerButtons">
            @if ($currentTab == 'overview')
                @if(!$editing)
                    @can('delete users')
                        <x-buttons.delete-button wire:key="deleteButton" wire:click="$set('showConfirmDeleteModal', true)">Delete User</x-buttons.delete-button>
                    @endcan
                @endif
                @can('edit users')
                    <x-jet-button wire:key="editButton" wire:click="toggleEdit">@if($editing) Cancel @else Edit @endif</x-jet-button>
                @endcan
                @if ($editing)
                    <x-jet-button wire:key="saveButton" wire:click="update">Save</x-jet-button>
                @endif
                @can('edit users')
                    <x-jet-button wire:key="resetPasswordButton" wire:click="$set('showResetPasswordModal', true)">Reset Password</x-jet-button>
                @endcan
            @endif
        </x-slot>

        <x-slot name="tabs">
            @foreach ($tabs as $tab)
                @if ($tab === 'permissions' && auth()->user()->hasAnyRole(['Client', 'Client Sub User']))
                    @continue
                @endif
                <x-tabs.tab 
                    :current="$currentTab === $tab ? true : false"
                    click="changeTab('{{ $tab }}')"
                >
                    {{ ucfirst($tab) }}
                </x-tabs.tab>
            @endforeach
        </x-slot>

        @if ($currentTab == 'permissions' && !auth()->user()->hasAnyRole(['Client', 'Client Sub User']))
            @section('fullWidth')
            <livewire:users.components.permissions id="{{ $user->id }}" />
            @endsection
        @endif


        @if ($currentTab == 'overview')
            @section('fullWidth')
            <livewire:users.components.overview id="{{ $user->id }}" />
            @endsection
        @endif  

        @if ($currentTab == 'permissions')
            @section('fullWidth')
            <livewire:users.components.permissions id="{{ $user->id }}" />
            @endsection
        @endif

        @if ($currentTab == 'tasks')
            @section('fullWidth')
            <livewire:global-components.kanban :userId="$user->id" :showTips="false" />
            @endsection
        @endif

        @if ($currentTab == 'files')
            @section('fullWidth')
            <livewire:users.components.files id="{{ $user->id }}" />
            @endsection
        @endif

        @if ($currentTab == 'activity')
            @section('fullWidth')
            {{-- <livewire:global-components.activity :activities="$user->activities" :showPath="false" /> --}}
                <livewire:global-components.activity 
                    :model="'App\\Models\\User'"
                    userID="{{ $user->id }}"
                    :showPath="true"
                />
            @endsection
        @endif
    </x-details>

    {{-- MODALS --}}
    <x-jet-dialog-modal wire:model="showResetPasswordModal">
        <x-slot name="title">Reset Password</x-slot>
        <x-slot name="content">
            <div class="space-y-4">
                <form aria-autocomplete="false" class="space-y-4">
                    <div>
                        <x-jet-label for="password" value="Password" />
                        <x-jet-input id="password" type="password" autocomplete="false" wire:model.defer="newPassword" />
                        <span>@error('newPassword') <span class="text-red-500">{{ $message }}</span> @enderror</span>
                    </div>
        
                    <div>
                        <x-jet-label for="confirmPassword" value="Confirm Password" />
                        <x-jet-input id="confirmPassword" type="password" autocomplete="false" wire:model.defer="newPassword_confirmation" />
                        <span>@error('newPassword_confirmation') <span class="text-red-500">{{ $message }}</span> @enderror</span>
                    </div>
                </form>
            </div>
        </x-slot>

        <x-slot name="footer">
            <div class="flex flex-row justify-end items-center space-x-1">
                <x-buttons.cancel-button x-on:click="show = false">Cancel</x-buttons.cancel-button>
                <x-jet-button wire:click="resetPassword">Reset</x-jet-button>
            </div>
        </x-slot>
    </x-jet-dialog-modal>

    {{-- Confirm delete modal --}}
    <x-jet-confirmation-modal wire:model="showConfirmDeleteModal">
        <x-slot name="title">Delete user</x-slot>

        <x-slot name="content">
            <div>
                Are you sure you want to delete this user?
            </div>
            <div class="text-red-500 text-sm mb-4">This action is irreversible</div>

            {{-- ✅ User Reassignment Dropdown --}}
            <div>
                <x-jet-label for="newUserId" value="Reassign tasks to:" />
                <select wire:model="newUserId" id="newUserId" class="border-gray-300 focus:ring-indigo-500 rounded-md shadow-sm w-full">
                    <option value="">Select a user</option>
                    @foreach ($otherUsers as $user)
                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                    @endforeach
                </select>
            </div>
        </x-slot>

        <x-slot name="footer">
            <div class="flex flex-row gap-1 justify-end items-center">
                <x-buttons.cancel-button x-on:click="show = false">Cancel</x-buttons.cancel-button>
                <x-buttons.delete-button wire:click="deleteUser">Delete</x-buttons.delete-button>
            </div>
        </x-slot>
    </x-jet-confirmation-modal>
    {{-- End confirm delete modal --}}
    {{-- END MODALS --}}
</div>
