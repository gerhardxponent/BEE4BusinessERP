<div>
    {{-- Outlook email modal --}}
    <x-jet-dialog-modal wire:model="showEmailModal">
        <x-slot name="title">
            <div>New Email</div>
            @if($msEmail != null)
                <div class="text-base text-slate-400">From: {{ $msEmail }}</div>
            @endif
        </x-slot>

        <x-slot name="content">
            @if($msEmail === '' || $msEmail == null)
                <div class="w-full flex flex-col justify-center items-center py-4 gap-2">
                    <div>Sign into Microsoft to send emails</div>
                    <x-jet-button wire:click="signInMs">Sign in</x-jet-button>
                </div>
            @else
                <div class="space-y-4">
                    <div>
                        <x-jet-label for="toAddress" value="To"/>
                        {{-- <x-jet-input id="toAddress" type="text"  wire:model.defer="emailData.recipient.0"/> --}}

                        <x-select2-multiple wire:model.defer="emailData.recipients" wire:key="set-client" id="outlook-email-recipients" multiple tags="true">
                            <option value="">Select Recipients</option>
                            @foreach($contactEmails as $index => $data)
                            <option value="{{ $data }}">{{ $data }}</option>
                            @endforeach
                        </x-select2-multiple>
                    </div>
                    <div>
                        <x-jet-label for="emailSubject" value="Subject" />
                        <x-jet-input id="emailSubject" type="text"  wire:model.defer="emailData.subject"/>
                    </div>
                    <div>
                        <x-jet-label for="emailBody" value="Body" />
                        <x-textarea 
                            id="emailBody"
                            wire:model.defer="emailData.body"
                            class="w-full preserveLines"
                            rows="8"
                            >
                        </x-textarea>
                    </div>
                    {{-- @json($attachments) --}}
                    @if(isset($attachments) && count($attachments) > 0)
                    <div>
                        <x-jet-label for="attachments" value="Attachments" />
                        <div id="attachments" class="space-y-2">
                            @foreach($attachments as $id => $attachment) 
                            <div class="flex flex-row items-center space-x-1">
                                <span class="cursor-pointer" wire:click="removeAttachment({{ $id }})">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-x" width="20" height="20" viewBox="0 0 24 24" stroke-width="2" stroke="#e11d48" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                        <line x1="18" y1="6" x2="6" y2="18"></line>
                                        <line x1="6" y1="6" x2="18" y2="18"></line>
                                    </svg>
                                </span>
                                <span>{{ $attachment['Name'] }}</span>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endif
                </div>
            @endif
        </x-slot>

        <x-slot name="footer">
            <div class="flex flex-row justify-end items-center space-x-2">
                {{-- <button wire:click="$toggle('sending')">TEST</button> --}}
                <x-buttons.cancel-button wire:click="closeEmailModal">Cancel</x-buttons.cancel-button>
                <x-buttons.send wire:click="sendOutlook" id="send-button" wire:loading.attr="disabled">Send</x-buttons.send>
            </div>
        </x-slot>
    </x-jet-dialog-modal>
</div>
