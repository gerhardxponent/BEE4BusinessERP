<div>
    <div class="space-y-4">
        <div class="bg-white rounded-lg p-6 space-y-4">
            <div class="font-bold text-xl">Quote Details</div>

            <div class="grid grid-cols-2 gap-6">
                <div class="space-y-4">
                    <div>
                        <x-jet-label for="name" value="Name" />
                        <x-jet-input id="name" type="text" wire:model.defer="quote.name" />
                        <x-validation-error field="quote.name" />
                    </div>

                    <div>
                        <x-jet-label for="client" value="Client" />
                        <x-select2-multiple wire:model="quote.client_id" wire:key="set-client" id="client-select2">
                            <option value="">Select Client</option>
                            @foreach($clients as $clients)
                            <option value="{{ $clients->id }}">{{ $clients->name }}</option>
                            @endforeach
                        </x-select2-multiple>
                        <x-validation-error field="quote.client_id" />
                    </div>

                    <div>
                        <x-jet-label for="desctiption" value="Description" />
                        <x-textarea id="description" wire:model.defer="quote.description" rows="4"></x-textarea>
                    </div>
                </div>

                <div class="space-y-4">
                    <div>
                        <x-jet-label for="stage" value="Stage" />
                        <x-select2-multiple wire:model.defer="quote.stage" wire:key="set-quote-stage" id="quote-stage-select2">
                            <option value="">Select a stage</option>
                            @foreach($stages as $stage)
                            <option value="{{ $stage }}">{{ $stage }}</option>
                            @endforeach
                        </x-select2-multiple>
                        <x-validation-error field="quote.stage" />
                    </div>

                    <div>
                        <x-jet-label for="contact" value="Contact" />
                        <x-select2-multiple wire:model.defer="quote.contact_id" wire:key="set-quote-contact" id="quote-contact-select2">
                            <option value="">Select Contact</option>
                            @foreach($contacts as $contact)
                            <option value="{{ $contact->id }}">{{ $contact->firstname . ' ' . $contact->lastname }}</option>
                            @endforeach
                        </x-select2-multiple>
                    </div>

                    <div>
                        <x-jet-label for="flatpickr-valid_until" value="Valid Until" />
                        {{-- <x-jet-input type="date" wire:model.defer="quote.valid_until" /> --}}
                        <x-input.flatpickr id="flatpickr-valid_until" wire:model.defer="quote.valid_until" />
                        <x-validation-error field="quote.valid_until" />
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg p-6 space-y-4">
            <div class="font-bold text-xl">Address Details</div>

            <div class="grid grid-cols-2 gap-6">
                <div class="space-y-4">
                    <div class="font-bold">Billing Address</div>

                    <div class="space-y-4">
                        <div>
                            <x-jet-label for="billing-address" value="Address" />
                            <x-jet-input id="billing-address" type="text" wire:model.debounce.500ms="quote.billing_address" />
                        </div>

                        <div>
                            <x-jet-label for="billing-city" value="City" />
                            <x-jet-input id="billing-city" type="text" wire:model.debounce.500ms="quote.billing_city" />
                        </div>

                        <div>
                            <x-jet-label for="billing-province" value="Province" />
                            <x-jet-input id="billing-province" type="text" wire:model.debounce.500ms="quote.billing_province" />
                        </div>

                        <div>
                            <x-jet-label for="billing-postal-code" value="Postal Code" />
                            <x-jet-input id="billing-postal-code" type="text" wire:model.debounce.500ms="quote.billing_postal_code" />
                        </div>

                        <div>
                            <x-jet-label for="billing-country" value="Country" />
                            <x-jet-input id="billing-country" type="text" wire:model.debounce.500ms="quote.billing_country" />
                        </div>
                    </div>
                </div>

                <div class="space-y-4">
                    <div class="flex gap-4 items-center">
                        <div class="font-bold">Shipping Address</div>
                        <div class="flex items-center gap-1">
                            <x-jet-checkbox id="same-as-billing-checkbox" wire:model="sameAsBilling" />
                            <x-jet-label for="same-as-billing-checkbox">Same as billing address</x-jet-label>
                        </div>
                    </div>

                    <div @class(['space-y-4 transition-opacity', 'opacity-50' => $sameAsBilling])>
                        <div>
                            <x-jet-label for="shipping-address" value="Address" />
                            <input 
                                @if ($sameAsBilling) disabled @endif
                                class="w-full border border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md"
                                id="shipping-address" 
                                type="text" 
                                @if ($sameAsBilling) 
                                    wire:model="quote.billing_address" 
                                @else
                                    wire:model="quote.shipping_address"
                                @endif
                            />
                        </div>

                        <div>
                            <x-jet-label for="shipping-city" value="City" />
                            {{-- <x-jet-input :disabled="$sameAsBilling" id="shipping-city" type="text" wire:model.defer="quote.shipping_city" /> --}}
                            <input 
                                @if ($sameAsBilling) disabled @endif
                                class="w-full border border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md"
                                id="shipping-city" 
                                type="text" 
                                @if ($sameAsBilling) 
                                    wire:model="quote.billing_city" 
                                @else
                                    wire:model="quote.shipping_city"
                                @endif
                            />
                        </div>

                        <div>
                            <x-jet-label for="shipping-province" value="Province" />
                            {{-- <x-jet-input :disabled="$sameAsBilling" id="shipping-province" type="text" wire:model.defer="quote.shipping_province" /> --}}
                            <input 
                                @if ($sameAsBilling) disabled @endif
                                class="w-full border border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md"
                                id="shipping-province" 
                                type="text" 
                                @if ($sameAsBilling) 
                                    wire:model="quote.billing_province" 
                                @else
                                    wire:model="quote.shipping_province"
                                @endif
                            />
                        </div>

                        <div>
                            <x-jet-label for="shipping-postal-code" value="Postal Code" />
                            {{-- <x-jet-input :disabled="$sameAsBilling" id="shipping-postal-code" type="text" wire:model.defer="quote.shipping_postal_code" /> --}}
                            <input 
                                @if ($sameAsBilling) disabled @endif
                                class="w-full border border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md"
                                id="shipping-postal-code" 
                                type="text" 
                                @if ($sameAsBilling) 
                                    wire:model="quote.billing_postal_code" 
                                @else
                                    wire:model="quote.shipping_postal_code"
                                @endif
                            />
                        </div>

                        <div>
                            <x-jet-label for="shipping-country" value="Country" />
                            {{-- <x-jet-input :disabled="$sameAsBilling" id="shipping-country" type="text" wire:model.defer="quote.shipping_country" /> --}}
                            <input 
                                @if ($sameAsBilling) disabled @endif
                                class="w-full border border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md"
                                id="shipping-country" 
                                type="text" 
                                @if ($sameAsBilling) 
                                    wire:model="quote.billing_country" 
                                @else
                                    wire:model="quote.shipping_country"
                                @endif
                            />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="w-1/2 space-y-4 mt-4">
        <div>
            <x-jet-button wire:click.prevent="toggleProductModal">Add Services</x-jet-button>
        </div>
    </div>

    <div class="mt-4">
        <div class="inline-block min-w-full py-2 align-middle transition-opacity" >
            <div class="overflow-hidden shadow ring-1 ring-black ring-opacity-5 md:rounded-lg">
                <table class="table-auto min-w-full divide-y divide-gray-300">
                    <thead class="bg-gray-50">
                        <tr>
                            <th style="z-index: 1" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6">#</th>
                            <th style="z-index: 1" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6">Name</th>
                            <th style="z-index: 1" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6">Quantity</th>
                            <th style="z-index: 1" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6">Discount</th>
                            <th style="z-index: 1" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6">Total</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 bg-white">
                        @php $count = 1; @endphp
                        @forelse($quoteItems as $index => $item)
                        <tr>
                            <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-semibold text-gray-900 sm:pl-6">{{ $count }}</td>
                            <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-semibold text-gray-900 sm:pl-6">
                                <div>{{ $item['name'] }}</div>
                                <div>
                                    <x-textarea wire:model.lazy="quoteItems.{{ $index }}.description"></x-textarea>
                                </div>
                            </td>
                            <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-semibold text-gray-900 sm:pl-6">
                                <x-jet-input class="w-1/2" wire:change="calcTotal" type="number" wire:model="quoteItems.{{ $index }}.quantity" />
                            </td>
                            <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-semibold text-gray-900 sm:pl-6 space-x-2">
                                <span>R</span>
                                <x-jet-input 
                                    wire:change="calcTotal"
                                    wire:model.lazy="quoteItems.{{ $index }}.discount"
                                    class="w-1/2"
                                    type="number"
                                    />
                            </td>
                            <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-semibold text-gray-900 sm:pl-6">R {{ $item['price'] * $item['quantity'] - $item['discount'] }}</td>
                            <td class="text-left cursor-pointer text-red-600 hover:underline" wire:click="removeProduct({{ $index }})">Delete</td>
                        </tr>
                        @php ++$count @endphp
                        @empty
                        <tr>
                            <td colspan="6">
                                <div class="w-full py-8 flex justify-center items-center">
                                    <div class="flex flex-col justify-center items-center gap-2 text-gray-500">
                                        <x-icons.box size="60" />
                                        <div>No services have been added to this quote.</div>
                                        <div>Click the <span class="font-bold">Add Services</span> button above to add some</div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                        <tr>
                            <td colspan="4" class="border-gray-300 border-t-2 text-right">
                                <span class="font-bold">Items Total</span>
                            </td>
                            <td colspan="2" class="border-gray-300 border-t-2 whitespace-nowrap py-4 pl-4 pr-3 text-sm font-semibold text-gray-900 sm:pl-6">
                                <span class="font-bold">R {{ number_format($itemsTotal, 2) }}</span>
                            </td>
                        </tr>

                        <tr>
                            <td colspan="4" class="text-right">
                                <span class="font-bold">Total Discount</span>
                            </td>
                            <td colspan="2" class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-semibold text-gray-900 sm:pl-6">
                                <span class="font-bold">R -{{ number_format($totalDiscount, 2) }}</span>
                            </td>
                        </tr>

                        <tr>
                            <td colspan="4" class="text-right">
                                <span class="font-bold">Subtotal</span>
                            </td>
                            <td colspan="2" class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-semibold text-gray-900 sm:pl-6">
                                <span class="font-bold">R {{ number_format($subtotal, 2) }}</span>
                            </td>
                        </tr>

                        <tr>
                            <td colspan="4" class="text-right">
                                <span class="font-bold">Total VAT</span>
                            </td>
                            <td colspan="2" class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-semibold text-gray-900 sm:pl-6">
                                <span class="font-bold">R {{ number_format($totalVat, 2) }}</span>
                            </td>
                        </tr>

                        <tr>
                            <td colspan="4" class="text-right">
                                <span class="font-bold">Grand Total</span>
                            </td>
                            <td colspan="2" class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-semibold text-gray-900 sm:pl-6">
                                <span class="font-bold">R {{ number_format($total, 2) }}</span>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="w-full flex flex-row justify-end space-y-4 py-8">
            <div>
                <x-jet-button wire:click="createQuote">Create Quote</x-jet-button>
            </div>
        </div>
    </div>

    <x-modal.dialog maxWidth="4xl" wire:model.defer="showProductsModal">
        <x-slot name="title">
            <div class="flex justify-between items-center">
                <div>Select Services</div>
                <div>
                    <x-button wire:click="$emit('add-services')">
                        <div class="flex items-center gap-1">
                            <x-icons.plus size="18" />
                            <div>Add</div>
                        </div>
                    </x-button>
                </div>
            </div>
        </x-slot>
        
        <x-slot name="content">
            <livewire:services.service-table />
        </x-slot>

        <x-slot name="footer">
            <x-jet-button wire:click="$set('showProductsModal', false)">Close</x-jet-button>
        </x-slot>
    </x-modal.dialog>
</div>