<div>
    <x-jet-dialog-modal wire:model="showCreateModal">
        <x-slot name="title">Create Log</x-slot>
        <x-slot name="content">
            <div class="space-y-2">
                <div>
                    <x-jet-label value="Client" for="client" />
                    <x-select2-multiple wire:model="procurementLog.client_id" wire:key="set-client" id="client-select2">
                        <option value="">Select Client</option>
                        @foreach($clients as $clients)
                        <option value="{{ $clients->id }}">{{ $clients->name }}</option>
                        @endforeach
                    </x-select2-multiple>
                </div>

                <div>
                    <x-jet-label value="Date Allocated" for="date-allocated" />
                    <x-input.flatpickr id="flatpickr-date-allocated" wire:model.defer="procurementLog.date_allocated" />
                </div>

                <div>
                    <x-jet-label value="Due Date" for="due-date" />
                    <x-input.flatpickr id="flatpickr-due-date" wire:model.defer="procurementLog.due_date" />
                </div>

                <div>
                    <x-jet-label value="PP Analyst" for="pp-analyst" />
                    <x-select2-multiple wire:model.defer="procurementLog.pp_analyst_id" wire:key="set-pp-analyst" id="pp-analyst-select2">
                        <option value="">Select User</option>
                        @foreach($users as $user)
                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                        @endforeach
                    </x-select2-multiple>
                </div>

                <div>
                    <x-jet-label value="FYE" for="fye" />
                    <x-select :disabled="$procurementLog->client_id == null" wire:model.defer="procurementLog.board_id" wire:key="set-fye" id="fye-select">
                        <option value="">Select a project</option>
                        @foreach($projects as $project)
                        <option value="{{ $project->id }}">{{ $project->name }}</option>
                        @endforeach
                    </x-select>
                </div>

                <div>
                    <x-jet-label value="Scorecard Number" id="scorecard-number" />
                    <x-jet-input type="text" wire:model.defer="procurementLog.scorecard_number" />
                </div>

                <div>
                    <x-jet-label value="Notes" id="notes" />
                    <x-textarea wire:model.defer="procurementLog.notes"></x-textarea>
                </div>
            </div>
        </x-slot>
        <x-slot name="footer">
            <div class="flex justify-end items-center gap-1">
                <x-buttons.cancel-button x-on:click="show = false;">Cancel</x-buttons.cancel-button>
                <x-create-button wire:click="createLog">Create</x-buttons.create-Button>
            </div>
        </x-slot>
    </x-jet-dialog-modal>
</div>
