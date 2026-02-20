<div>
    <div class="grid grid-cols-2 gap-4">
        <div class="flex flex-col gap-4">
            <div class="bg-white p-8 rounded-lg">
                <table class="table-fixed">
                    <tr>
                        <td class="font-bold">Name</td>
                        @if($editing)
                        <td><x-jet-input type="text" wire:model.defer="user.name" /></td>
                        @else
                        <td>{{ $user->name }}</td>
                        @endif
                    </tr>
                    <tr>
                        <td class="font-bold">Email</td>
                        @if($editing)
                        <td><x-jet-input type="text" wire:model.defer="user.email" /></td>
                        @else
                        <td>{{ $user->email }}</td>
                        @endif
                    </tr>
                    <tr>
                        <td class="font-bold">Role 1</td>
                        @if($editing)
                            <td>
                                @if(auth()->user()->hasAnyRole(['Client', 'Client Sub User']))
                                    <x-jet-input 
                                        type="text" 
                                        value="{{ $user->roles[0]->name }}" 
                                        disabled 
                                        class="w-full border-gray-300 focus:border-indigo-500 rounded-md bg-gray-100 text-gray-600 cursor-not-allowed" 
                                    />
                                @else
                                    <x-select2 
                                        :options="$allRoles" 
                                        id="roles-select2-1" 
                                        wire:model="selectedRole1" 
                                        initial="{{ $user->roles[0]->id }}" 
                                    />
                                @endif
                            </td>
                        @else
                            <td>{{ $user->roles[0]->name }}</td>
                        @endif
                    </tr>
                    <tr>
                        <td class="font-bold">Role 2</td>
                        @if($editing)
                            <td>
                                @if(auth()->user()->hasAnyRole(['Client', 'Client Sub User']))
                                    <x-jet-input 
                                        type="text" 
                                        value="{{ $user->roles[1]->name ?? 'No second role assigned' }}" 
                                        disabled 
                                        class="w-full border-gray-300 focus:border-indigo-500 rounded-md bg-gray-100 text-gray-600 cursor-not-allowed" 
                                    />
                                @else
                                    <x-select2 
                                        :options="$allRoles" 
                                        id="roles-select2-2" 
                                        wire:model="selectedRole2" 
                                        initial="{{ $user->roles[1]->id ?? '' }}" 
                                    />
                                @endif
                            </td>
                        @else
                            <td>
                                @if(isset($user->roles[1])) 
                                    {{ $user->roles[1]->name }}
                                @else
                                    <span>No second role assigned</span>
                                @endif
                            </td>
                        @endif
                    </tr>

                    @if(
                        isset($user->roles[0]) 
                        && in_array($user->roles[0]->name, ['Client','Client Sub User'])
                    )
                        {{-- NEW: Clients multi-select --}}
                        <tr>
                            <td class="font-bold">Clients</td>
                            @if($editing)
                                <td>
                                    <x-select2-multiple
                                        id="clients-select2"
                                        wire:model="selectedClients"
                                        :options="$allClients"
                                        :placeholder="'Select clients…'"
                                        :tags="false"
                                        class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm px-4 py-2"
                                        multiple
                                    />

                                </td>
                            @else
                                <td>
                                    @if(count($selectedClients))
                                        @foreach($selectedClients as $id)
                                            @php
                                            $clients = collect($allClients);
                                            $match   = $clients->firstWhere('id', $id);
                                            @endphp

                                            {{ optional($match)->name }}
                                            @if(! $loop->last), @endif
                                        @endforeach
                                    @else
                                        <em>No clients assigned</em>
                                    @endif
                                </td>
                            @endif
                        </tr>
                    @endif

                    <tr>
                        <td class="font-bold">Address</td>
                        @if($editing)
                        <td><x-jet-input type="text" wire:model.defer="user.street_address" /></td>
                        @else
                        <td>{{ $user->street_address }}</td>
                        @endif
                    </tr>
                    <tr>
                        <td class="font-bold">Postal Code</td>
                        @if($editing)
                        <td><x-jet-input type="text" wire:model.defer="user.postal_code" /></td>
                        @else
                        <td>{{ $user->postal_code }}</td>
                        @endif
                    </tr>
                    <tr>
                        <td class="font-bold">City</td>
                        @if($editing)
                        <td><x-jet-input type="text" wire:model.defer="user.city" /></td>
                        @else
                        <td>{{ $user->city }}</td>
                        @endif
                    </tr>
                    <tr>
                        <td class="font-bold">Province</td>
                        @if($editing)
                        <td><x-jet-input type="text" wire:model.defer="user.province" /></td>
                        @else
                        <td>{{ $user->province }}</td>
                        @endif
                    </tr>
                    <tr>
                        <td class="font-bold">Country</td>
                        @if($editing)
                        <td><x-jet-input type="text" wire:model.defer="user.country" /></td>
                        @else
                        <td>{{ $user->country }}</td>
                        @endif
                    </tr>
                </table>
            </div>
        </div>

        <div class="flex flex-col gap-4">
            <div class="bg-white p-8 rounded-lg space-y-4">
                <div class="flex flex-row justify-between items-center">
                    <div class="font-bold text-lg">Recently uploaded files</div>
                    <x-buttons.flat wire:click="$emit('changeTab', 'files')">
                        <div>View All</div>
                        <x-slot name="trailingIcon"><x-icons.right-arrow /></x-slot>
                    </x-buttons.flat>
                </div>

                <div 
                    style="box-shadow: 0px 0px 0px 1px var(--color-gray-200);"
                    class="overflow-x-auto relative sm:rounded-lg shadow-xl"
                    >
                    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400 border-collapse rounded-lg">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th scope="col" class="py-3 px-6">
                                    File name
                                </th>
                                <th scope="col" class="py-3 px-6">
                                    Type
                                </th>
                                <th scope="col" class="py-3 px-6">
                                    Size
                                </th>
                                <th scope="col" class="py-3 px-6">
                                    Uploaded on
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($user->files()->orderByDesc('created_at')->paginate(5) as $index => $file)
                            <tr class="bg-white border-b dark:bg-gray-900 dark:border-gray-700">
                                <td class="py-4 px-6">
                                    {{ $file->file_name }}
                                </td>
                                <td class="py-4 px-6">
                                    {{ $file->type }}
                                </td>
                                <td class="py-4 px-6">
                                    {{ $file->file_size }}
                                </td>
                                <td class="py-4 px-6">
                                    {{ $file->created_at->format('d/m/Y') }}
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
