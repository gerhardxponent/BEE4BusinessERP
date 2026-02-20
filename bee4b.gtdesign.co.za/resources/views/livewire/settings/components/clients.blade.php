<div>
    <div class="flex w-full">
        <div class="w-1/6 pr-6 border-r border-gray-200">
            <div class="text-lg font-bold mb-4 flex justify-between items-center">
                <div>Dropdown Items</div>
            </div>
            <div class="flex flex-col gap-1">
                @foreach ($properties as $property)
                    <div 
                        @class([
                            'p-2 rounded-md cursor-pointer',
                            'bg-indigo-100 text-indigo-900 font-bold' => $currentProperty == $property,
                            'hover:bg-gray-200 active:bg-gray-300' => $currentProperty != $property,
                        ])
                        wire:click="changeProperty('{{ $property }}')"
                        >
                        <div>
                            {{ $property }}
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="pl-6 w-full">
            <div class="bg-white p-4 rounded-lg w-full">
                <div class="text-sm text-gray-500 flex gap-1 items-center mb-4">
                    <x-icons.info />
                    <div>Click on an item name to edit it, click the New button to create new items or click Delete to delete an item</div>
                </div>
        
                <div class="px-8 pb-6">
                    <div x-data="{ newItem: false }" wire:key="{{ $currentProperty }}-current">
                        <div class="flex justify-between items-center">
                            <div class="text-lg font-bold">{{ $currentProperty }}</div>
                            <x-button 
                                x-on:click="() => {
                                    newItem = !newItem;
                                    newItem && setTimeout(() => $refs.newItemInput.focus(), 120)
                                }"
                                x-html="!newItem ? 'New' : 'Cancel'"
                                >
                            </x-button>
                        </div>
                        <div 
                            style="box-shadow: 0px 0px 0px 1px var(--color-gray-200);"
                            class="w-full overflow-x-auto relative sm:rounded-lg shadow-xl mt-2"
                            >
                            <table wire:key="{{ $currentProperty }}-oiweqads" class="w-full text-sm text-left text-gray-500 dark:text-gray-400 border-collapse rounded-lg">
                                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                    <tr>
                                        <th scope="col" style="width:20px"></th>
                                        <th scope="col" class="py-3 px-6 text-center">Name</th>
                                        <th scope="col" class="py-3 px-6 text-center"></th>
                                    </tr>
                                </thead>
                                <tbody 
                                    wire:sortable="updateItemOrder"
                                    >
                                    @foreach(('App\Models\\' . $currentProperty)::all()->sortBy('position') as $item)
                                    <tr 
                                        wire:sortable.item="{{ $item->id }}" 
                                        wire:key="{{ $currentProperty }}-{{ $item->id }}"
                                        class="bg-white border-b dark:bg-gray-900 dark:border-gray-700"
                                        >
                                        <td>
                                            <div wire:sortable.handle class="cursor-grab">
                                                <x-icons.move />
                                            </div>
                                        </td>
                                        <td class="text-center py-2">
                                            <x-inline-edit
                                                :original="$item->name"
                                                :model="$currentProperty"
                                                :entityId="$item->id"
                                                field="name"
                                                name="dropdown-item"
                                            />
                                        </td>
    
                                        <td scope="row">
                                            <div class="w-full flex justify-center">
                                                <div 
                                                    class="text-red-500 hover:underline cursor-pointer text-center" 
                                                    wire:click="delete('{{ $currentProperty }}', {{ $item->id }})"
                                                    >
                                                    Delete
                                                </div>
                                            </div>
                                        </td> 
                                    </tr>
                                    @endforeach
                                    <tr x-show="newItem" wire:key="{{ $currentProperty }}-newItem">
                                        <td></td>
                                        <td class="py-4 px-6 flex gap-2">
                                            <x-jet-input x-ref="newItemInput" wire:model.defer="newItem" type="text" />
                                            <x-buttons.flat wire:click="createItem('{{ $currentProperty }}')" color="green">
                                                <x-icons.check />
                                            </x-buttons.flat>
                                        </td>
                                        <td></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
