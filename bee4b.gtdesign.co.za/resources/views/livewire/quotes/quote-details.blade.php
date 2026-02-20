<div>
    {{-- <x-back>all Quotes</x-back> --}}

    <style>
        .details-section td {
            vertical-align: top;
        }
    </style>

    <div class="space-y-4">
        {{-- Header --}}
        <div class="flex flex-row justify-between my-4">
            <div class="font-bold text-2xl my-4">{{ $quote->name }}</div>
            <div>
                @if($editing)
                <x-jet-button wire:click="saveChanges">Save Changes</x-jet-button>
                @endif
                <x-jet-button wire:click="toggleEdit">
                    @if($editing)
                    Cancel
                    @else
                    Edit
                    @endif
                </x-jet-button>
            </div>
        </div>   
        {{-- End header --}}

        {{-- Details --}}
        <div class="space-y-4">
            {{-- Quote details --}}
            <div class="bg-white rounded-lg p-6 space-y-4">
                <div class="font-bold text-xl">Quote Details</div>

                <div class="flex flex-row space-x-10 details-section">
                    <table class="">
                        <tr>
                            <td class="font-bold">Name</td>
                            @if($editing)
                            <td><x-jet-input type="text" wire:model="quote.name" /></td>
                            @else
                            <td>{{ $quote->name }}</td>
                            @endif
                        </tr>

                        <tr>
                            <td class="font-bold">Client</td>
                            @if($editing)
                            <td>
                                <x-select2-multiple wire:model.defer="quote.client_id" wire:key="set-client" id="client-select2">
                                    <option value="">Select Client</option>
                                    @foreach($clients as $clients)
                                    <option value="{{ $clients->id }}">{{ $clients->name }}</option>
                                    @endforeach
                                </x-select2-multiple>
                            </td>
                            @else
                            <td>
                                <a href="{{asset('/')}}clients/{{ $quote->client->id }}" class="text-blue-600 hover:underline">
                                    {{ $quote->client->name }}
                                </a>
                            </td>
                            @endif
                        </tr>

                        <tr>
                            <td class="font-bold">Description</td>
                            @if($editing)
                            <td>
                                <x-textarea wire:model="quote.description" rows="4"></x-textarea>
                            </td>
                            @else
                            <td>
                                {{ $quote->description }}
                            </td>
                            @endif
                        </tr>
                    </table>

                    <table class="">
                        <tr>
                            <td class="font-bold">Stage</td>
                            @if($editing)
                            <td>
                                <x-select wire:model.defer="quote.stage">
                                    <option value="">Select a stage</option>
                                    @foreach($stages as $stage)
                                    <option value="{{ $stage }}">{{ $stage }}</option>
                                    @endforeach
                                </x-select>
                            </td>
                            @else
                            <td>{{ $quote->stage }}</td>
                            @endif
                        </tr>

                        <tr>
                            <td class="font-bold">Contact</td>
                            @if($editing)
                            <td>
                                {{-- <x-select2 id="client" :options="$contacts" wire:model="quote.contact_id" id="contact-select" /> --}}
                                <x-select2-multiple wire:model.defer="quote.contact_id" wire:key="set-contact" id="contact-select2">
                                    <option value="">Select Contact</option>
                                    @foreach($contacts as $contact)
                                    <option value="{{ $contact->id }}">{{ $contact->name }}</option>
                                    @endforeach
                                </x-select2-multiple>
                            </td>
                            @else
                            <td>
                                @if(isset($quote->contact))
                                <a href="{{asset('/')}}contacts/{{ $quote->contact->id }}" class="text-blue-600 hover:underline">
                                    {{ $quote->contact->firstname }}
                                </a>
                                @endif
                            </td>
                            @endif
                        </tr>

                        <tr>
                            <td class="font-bold">Valid Until</td>
                            @if($editing)
                            <td>
                                <x-jet-input type="date" wire:model="quote.valid_until" />
                            </td>
                            @else
                            <td>{{ $quote->valid_until }}</td>
                            @endif
                        </tr>
                    </table>
                </div>
            </div>
            {{-- End quote details --}}

            {{-- Address details --}}
            <div class="bg-white rounded-lg p-6 space-y-4">
                <div class="font-bold text-xl">Address Details</div>

                <div class="flex flex-row w-full gap-10">
                    <div class="w-1/2">
                        <div class="font-bold text-lg mb-2">Billing Address</div>
                        <table class="">
                            <tr>
                                <td class="font-bold">Address</td>
                                @if($editing)
                                <td>
                                    <x-jet-input type="text" wire:model="quote.billing_address" />
                                </td>
                                @else
                                <td>{{ $quote->billing_address }}</td>
                                @endif
                            </tr>

                            <tr>
                                <td class="font-bold">City</td>
                                @if($editing)
                                <td>
                                    <x-jet-input type="text" wire:model="quote.billing_city" />
                                </td>
                                @else
                                <td>{{ $quote->billing_city }}</td>
                                @endif
                            </tr>

                            <tr>
                                <td class="font-bold">Province</td>
                                @if($editing)
                                <td>
                                    <x-jet-input type="text" wire:model="quote.billing_province" />
                                </td>
                                @else
                                <td>{{ $quote->billing_province }}</td>
                                @endif
                            </tr>

                            <tr>
                                <td class="font-bold">Postal Code</td>
                                @if($editing)
                                <td>
                                    <x-jet-input type="text" wire:model="quote.billing_postal_code" />
                                </td>
                                @else
                                <td>{{ $quote->billing_postal_code }}</td>
                                @endif
                            </tr>

                            <tr>
                                <td class="font-bold">Country</td>
                                @if($editing)
                                <td>
                                    <x-jet-input type="text" wire:model="quote.billing_country" />
                                </td>
                                @else
                                <td>{{ $quote->billing_country }}</td>
                                @endif
                            </tr>
                        </table>
                    </div>

                    <div class="w-1/2">
                        <div class="font-bold text-lg mb-2">Shipping Address</div>
                        <table class="">
                            <tr>
                                <td class="font-bold">Address</td>
                                @if($editing)
                                <td>
                                    <x-jet-input type="text" wire:model="quote.shipping_address" />
                                </td>
                                @else
                                <td>{{ $quote->shipping_address }}</td>
                                @endif
                            </tr>

                            <tr>
                                <td class="font-bold">City</td>
                                @if($editing)
                                <td>
                                    <x-jet-input type="text" wire:model="quote.shipping_city" />
                                </td>
                                @else
                                <td>{{ $quote->shipping_city }}</td>
                                @endif
                            </tr>

                            <tr>
                                <td class="font-bold">Province</td>
                                @if($editing)
                                <td>
                                    <x-jet-input type="text" wire:model="quote.shipping_province" />
                                </td>
                                @else
                                <td>{{ $quote->shipping_province }}</td>
                                @endif
                            </tr>

                            <tr>
                                <td class="font-bold">Postal Code</td>
                                @if($editing)
                                <td>
                                    <x-jet-input type="text" wire:model="quote.shipping_postal_code" />
                                </td>
                                @else
                                <td>{{ $quote->shipping_postal_code }}</td>
                                @endif
                            </tr>

                            <tr>
                                <td class="font-bold">Country</td>
                                @if($editing)
                                <td>
                                    <x-jet-input type="text" wire:model="quote.shipping_country" />
                                </td>
                                @else
                                <td>{{ $quote->shipping_country }}</td>
                                @endif
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
            {{-- End address details --}}
        </div>
        {{-- End details --}}

        {{-- Items table --}}
        <div>
            @if($editing)
            <x-jet-button wire:click="$set('showProductsModal', true)">Add Products</x-jet-button>
            @endif
            <div class="inline-block min-w-full py-2 align-middle transition-opacity" >
                <div class="overflow-hidden shadow ring-1 ring-black ring-opacity-5 md:rounded-lg">
                    <table class="table-auto min-w-full divide-y divide-gray-300">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6">#</th>
                                <th class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6">Name</th>
                                <th class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6">Quantity</th>
                                <th class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6">Discount</th>
                                <th class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6">Total</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 bg-white">
                            @php $count = 1; @endphp

                            @foreach($quoteArray as $index => $item)
                            @if(!$item['toBeDeleted'])
                            <tr>
                                <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-semibold text-gray-900 sm:pl-6">{{ $count }}</td>
                                <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-semibold text-gray-900 sm:pl-6">
                                    <div>{{ $item['name'] }}</div>
                                    @if($editing)
                                    <div>
                                        <x-textarea wire:model.lazy="quoteArray.{{ $index }}.description"></x-textarea>
                                    </div>
                                    @endif
                                </td>
                                <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-semibold text-gray-900 sm:pl-6">
                                    @if($editing)
                                    <x-jet-input type="number" wire:change="calcTotal" wire:model="quoteArray.{{$index}}.quantity" class="w-1/2" />
                                    @else
                                    <div>{{ $item['quantity'] }}</div>
                                    @endif
                                </td>
                                <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-semibold text-gray-900 sm:pl-6">
                                    @if($editing)
                                    R <x-jet-input type="number" wire:model="quoteArray.{{$index}}.discount" wire:change="calcTotal" class="w-1/2" />
                                    @else
                                    <div>R {{ $item['discount'] }}</div>
                                    @endif
                                </td>
                                <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-semibold text-gray-900 sm:pl-6">R {{ $item['quantity'] * $item['price'] - $item['discount'] }}</td>
                                <td class="text-center cursor-pointer text-red-600 hover:underline" >
                                    @if($editing)
                                    <div wire:click="deleteItem({{ $index }})">Delete</div>
                                    @endif
                                </td>
                            </tr>
                            @php ++$count @endphp
                            @endif
                            @endforeach

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
                                    <span class="font-bold">-R {{ number_format($totalDiscount, 2) }}</span>
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
                                    <span class="font-bold">R {{ number_format($grandTotal, 2) }}</span>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        {{-- End items table --}}
    </div>
    
    <x-modal.dialog maxWidth="4xl" wire:model.defer="showProductsModal">
        <x-slot name="title">
            Select Products
        </x-slot>
        
        <x-slot name="content">
            <livewire:products.product-table />
        </x-slot>

        <x-slot name="footer">
            <x-jet-button wire:click="$set('showProductsModal', false)">Close</x-jet-button>
        </x-slot>
    </x-modal.dialog>
</div>