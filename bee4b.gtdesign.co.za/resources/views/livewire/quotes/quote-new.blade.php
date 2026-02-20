<div>
    @json($serviceArr)

    <div>
        <div class="space-y-2">
            @foreach (App\Models\Service::all() as $service)
                <div class="flex items-center gap-1">
                    <div>{{ $service->name }}</div>
                    <x-jet-button wire:click="addService({{ $service->id }})">Add</x-jet-button>
                </div>
            @endforeach
        </div>
    </div>

    <div class="space-y-4">
        <div class="bg-white rounded-lg p-6 space-y-4">
            <div class="font-bold text-xl">Quote Details</div>

            <div class="grid grid-cols-2 gap-6">
                <div class="space-y-4">
                    <div>
                        <x-jet-label for="name" value="Name" />
                        <x-jet-input id="name" type="text" wire:model.defer="quote.name" />
                    </div>

                    <div>
                        <x-jet-label for="client" value="Client" />
                        <x-select2-multiple wire:model.defer="quote.client_id" wire:key="set-client" id="client-select2">
                            <option value="">Select Client</option>
                            @foreach($clients as $clients)
                            <option value="{{ $clients->id }}">{{ $clients->name }}</option>
                            @endforeach
                        </x-select2-multiple>
                    </div>

                    <div>
                        <x-jet-label for="desctiption" value="Description" />
                        <x-textarea id="description" wire:model.defer="quote.description" rows="4"></x-textarea>
                    </div>
                </div>

                <div class="space-y-4">
                    <div>
                        <x-jet-label for="stage" value="Stage" />
                        {{-- <x-select2-multiple wire:model.defer="quote.stage" wire:key="set-quote-stage" id="quote-stage-select2">
                            <option value="">Select a stage</option>
                            @foreach($stages as $stage)
                            <option value="{{ $stage }}">{{ $stage }}</option>
                            @endforeach
                        </x-select2-multiple> --}}
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
                        <x-jet-label for="valid_until" value="Valid Until" />
                        <x-jet-input type="date" wire:model.defer="quote.valid_until" />
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
                            <x-jet-input id="billing-address" type="text" wire:model.defer="quote.billing_address" />
                        </div>

                        <div>
                            <x-jet-label for="billing-city" value="City" />
                            <x-jet-input id="billing-city" type="text" wire:model.defer="quote.billing_city" />
                        </div>

                        <div>
                            <x-jet-label for="billing-province" value="Province" />
                            <x-jet-input id="billing-province" type="text" wire:model.defer="quote.billing_province" />
                        </div>

                        <div>
                            <x-jet-label for="billing-postal-code" value="Postal Code" />
                            <x-jet-input id="billing-postal-code" type="text" wire:model.defer="quote.billing_postal_code" />
                        </div>

                        <div>
                            <x-jet-label for="billing-country" value="Country" />
                            <x-jet-input id="billing-country" type="text" wire:model.defer="quote.billing_country" />
                        </div>
                    </div>
                </div>

                <div class="space-y-4">
                    <div class="font-bold">Shipping Address</div>

                    <div class="space-y-4">
                        <div>
                            <x-jet-label for="shipping-address" value="Address" />
                            <x-jet-input id="shipping-address" type="text" wire:model.defer="quote.shipping_address" />
                        </div>

                        <div>
                            <x-jet-label for="shipping-city" value="City" />
                            <x-jet-input id="shipping-city" type="text" wire:model.defer="quote.shipping_city" />
                        </div>

                        <div>
                            <x-jet-label for="shipping-province" value="Province" />
                            <x-jet-input id="shipping-province" type="text" wire:model.defer="quote.shipping_province" />
                        </div>

                        <div>
                            <x-jet-label for="shipping-postal-code" value="Postal Code" />
                            <x-jet-input id="shipping-postal-code" type="text" wire:model.defer="quote.shipping_postal_code" />
                        </div>

                        <div>
                            <x-jet-label for="shipping-country" value="Country" />
                            <x-jet-input id="shipping-country" type="text" wire:model.defer="quote.shipping_country" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
