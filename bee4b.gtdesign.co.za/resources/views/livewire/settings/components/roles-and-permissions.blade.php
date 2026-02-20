<div>
    <div class="flex w-full">
        <div class="w-1/6 pr-6 border-r border-gray-200">
            <div class="text-lg font-bold mb-4 flex justify-between items-center">
                <div>Roles</div>
                <div wire:click="toggleNewRole" class="cursor-pointer hover:bg-indigo-100 active:bg-indigo-200 p-1 rounded-md">
                    <x-icons.plus />
                </div>
            </div>
            <div class="flex flex-col gap-1">
                @foreach ($this->roles as $role)
                    <div 
                        @class([
                            'p-2 rounded-md cursor-pointer',
                            'bg-indigo-100 text-indigo-900 font-bold' => $currentRole == $role->id,
                            'hover:bg-gray-200 active:bg-gray-300' => $currentRole != $role->id,
                        ])
                        wire:click="changeRole('{{ $role->id }}')"
                        >
                        <div>
                            {{ ucfirst($role->name) }}
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="pl-6">
            @if ($newRole)
            <livewire:global-components.roles-and-permissions title="Create New Role" />
            @else
            {{-- @php $_role = $this->getRole(); @endphp --}}
            <livewire:global-components.roles-and-permissions :role="$this->getRole()" :title="'Permissions'" />
            @endif
        </div>
    </div>
</div>
