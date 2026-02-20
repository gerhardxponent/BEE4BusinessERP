<div class="relative" style="transform: scale(1);">
    <div class="fixed z-50 top-20 right-5 space-y-4">
        @if (session()->has('event_success'))
        <x-toast.success message="{{ session('event_success') }}"></x-toast.success>
        @endif
    </div>

    <style>
        .fc-view-harness {
            background-color: white;
        }

        .fc-daygrid-day-events:hover,
        .fc-timegrid-event-harness:hover {
            cursor: pointer;
        }
    </style>

    <style>
        #preloader {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 99999999;
        }
        #loader {
            display: block;
            position: relative;
            z-index: 9999999999;
            left: 50%;
            top: 50%;
            width: 150px;
            height: 150px;
            margin: -75px 0 0 -75px;
            border-radius: 50%;
            border: 3px solid transparent;
            border-top-color: #9370DB;
            -webkit-animation: spin 2s linear infinite;
            animation: spin 2s linear infinite;
        }
        #loader:before {
            content: "";
            position: absolute;
            top: 5px;
            left: 5px;
            right: 5px;
            bottom: 5px;
            border-radius: 50%;
            border: 3px solid transparent;
            border-top-color: #BA55D3;
            -webkit-animation: spin 3s linear infinite;
            animation: spin 3s linear infinite;
        }
        #loader:after {
            content: "";
            position: absolute;
            top: 15px;
            left: 15px;
            right: 15px;
            bottom: 15px;
            border-radius: 50%;
            border: 3px solid transparent;
            border-top-color: #FF00FF;
            -webkit-animation: spin 1.5s linear infinite;
            animation: spin 1.5s linear infinite;
        }
        @-webkit-keyframes spin {
            0% {
                -webkit-transform: rotate(0deg);
                -ms-transform: rotate(0deg);
                transform: rotate(0deg);
            }
            100% {
                -webkit-transform: rotate(360deg);
                -ms-transform: rotate(360deg);
                transform: rotate(360deg);
            }
        }
        @keyframes spin {
            0%   {
                -webkit-transform: rotate(0deg);
                -ms-transform: rotate(0deg);
                transform: rotate(0deg);
            }
            100% {
                -webkit-transform: rotate(360deg);
                -ms-transform: rotate(360deg);
                transform: rotate(360deg);
            }
        }
    </style>
    
    @if($signedIn)
        <div id="preloader" wire:loading>
            <div id="loader"></div>
        </div>
        
        <x-select wire:model="currentCalendar">
            @foreach ($calendars as $calendar)
                <option value="{{ $calendar['id'] }}">{{ $calendar['name'] }}</option>
            @endforeach
        </x-select>

        <div 
            wire:ignore
            id='calendar-container' 
            class="px-8 py-4 transition-opacity"
            wire:loading.class="opacity-50"
            >
            <div id="calendar" class="w-full"></div>
        </div>
    @else
        <x-jet-button wire:click="signIn">Sign in to microsoft</x-jet-button>
    @endif

    {{-- Modals --}}
    <x-modal.dialog wire:model="showEventDetailsModal">
        <x-slot name="title">
            <div class="flex flex-row justify-between">
                <div class="font-bold text-lg">{{ $selectedEvent['title'] }}</div>
                <div>
                    @unless($editing)
                    <div wire:key="editing-off-buttons">
                        <x-jet-button wire:click="confirmDelete">Delete</x-jet-button>
                        <x-jet-button wire:click="editEvent">Edit</x-jet-button>
                    </div>
                    @endif
                    @if($editing)
                    <div wire:key="editing-on-buttons">
                        <x-jet-button wire:click="editEvent">Cancel</x-jet-button>
                        <x-jet-button wire:loading.attr="disabled" wire:click="updateEvent">Update</x-jet-button>
                    </div>
                    @endif
                </div>
            </div>
        </x-slot>

        <x-slot name="content">
            <div class="space-y-4 transition-opacity" wire:loading.class="opacity-50" wire:target="updateEvent">
                <div>
                    <x-jet-label for="name" value="Name" />
                    <div id="name">
                        @if($editing)
                        <x-jet-input wire:loading.attr="disabled" wire:target="updateEvent" type="text" wire:model.defer="selectedEvent.title" />
                        @else
                        <div>{{ $selectedEvent['title'] }}</div>
                        @endif
                    </div>
                </div>
                <div class="flex flex-row w-full space-x-2">
                    <div class="w-1/2">
                        <x-jet-label for="eventStart" value="Event Start" />
                        <div id="eventStart">
                            @if($editing)
                            <x-jet-input wire:loading.attr="disabled" wire:target="updateEvent" type="datetime-local" wire:model.defer="selectedEvent.start" />
                            @else
                            {{ date('d F Y, H:i', strtotime($selectedEvent['start'])) }}
                            @endif
                        </div>
                    </div>
                    <div class="w-1/2">
                        <x-jet-label for="eventEnd" value="Event End" />
                        <div id="eventEnd">
                            @if($editing)
                            <x-jet-input wire:loading.attr="disabled" wire:target="updateEvent" type="datetime-local" wire:model.defer="selectedEvent.end" />
                            @else
                            {{ date('d F Y, H:i', strtotime($selectedEvent['end'])) }}
                            @endif    
                        </div>
                    </div>
                </div>
                <div>
                    <x-jet-label for="body" value="Description" />
                    <div id="body">
                        @if($editing)
                        <x-textarea wire:loading.attr="disabled" wire:target="updateEvent" wire:model.defer="selectedEvent.body"></x-textarea>
                        @else
                        <div>{{ $selectedEvent['body'] }}</div>
                        @endif
                    </div>
                </div>
                @if(count($selectedEvent['attendees']) > 0 || $editing)
                <div>
                    <x-jet-label for="attendees" value="Attendees"/>
                    <div id="attendees">
                        @if($editing)
                            <div id="editing-emails-input" wire:ignore class="border-none"></div>
                        @else
                            <div class="flex flex-row flex-wrap gap-2">
                                @if(count($selectedEvent['attendees']) > 0)
                                    @foreach($selectedEvent['attendees'] as $attendee)
                                        @if(isset($attendee['emailAddress']['address']))
                                        <div class="bg-indigo-100 px-4 py-1 rounded-2xl">{{ $attendee['emailAddress']['address'] }}</div>
                                        @endif
                                    @endforeach
                                @endif
                            </div>
                        @endif
                    </div>
                </div>
                @endif
            </div>
        </x-slot>

        <x-slot name="footer">
            <x-jet-button wire:click="closeEventDetails">Close</x-jet-button>
        </x-slot>
    </x-modal.dialog>

    <x-jet-dialog-modal wire:model="showCreateEventModal">
        <x-slot name="title">Create new event</x-slot>

        <x-slot name="content">
            <div class="space-y-4 transition-opacity" wire:loading.class="opacity-50">
                <div class="form-group">
                    <x-jet-label>Subject</x-jet-label>
                    <x-jet-input wire:model.defer="eventData.eventSubject" wire:loading.attr="disabled" wire:target="createEvent" type="text" class="form-control" name="eventSubject" />
                </div>
                <div class="form-group">
                    <x-jet-label>Attendees</x-jet-label>
                    {{-- <x-jet-input wire:model.defer="eventData.eventAttendees" type="text" class="form-control" name="eventAttendees" /> --}}
                    <div id="emails-input" wire:ignore class="border-none"></div>
                </div>
                <div class="form-row flex flex-row w-full space-x-2">
                    <div class="w-1/2">
                        <div class="form-group">
                            <x-jet-label>Start</x-jet-label>
                            <x-jet-input wire:model.defer="eventData.eventStart" wire:loading.attr="disabled" wire:target="createEvent" type="datetime-local" class="form-control" name="eventStart" id="eventStart" />
                        </div>
                        @error('eventStart')<div class="alert alert-danger">{{ $message }}</div>@enderror
                    </div>
                    <div class="w-1/2">
                        <div class="form-group">
                            <x-jet-label>End</x-jet-label>
                            <x-jet-input wire:model.defer="eventData.eventEnd" wire:loading.attr="disabled" wire:target="createEvent" type="datetime-local" class="form-control" name="eventEnd" />
                        </div>
                        @error('eventEnd')<div class="alert alert-danger">{{ $message }}</div>@enderror
                    </div>
                </div>
                <div class="form-group">
                    <x-jet-label>Body</x-jet-label>
                    <x-textarea wire:model.defer="eventData.eventBody" wire:loading.attr="disabled" wire:target="createEvent" type="text" class="form-control" name="eventBody" rows="3"></x-textarea>
                </div>
            </div>
        </x-slot>

        <x-slot name="footer">
            <x-buttons.cancel-button wire:click="closeCreateModal" wire:loading.attr="disabled">Cancel</x-buttons.cancel-button>
            <x-create-button wire:click="createEvent" wire:loading.attr="disabled">Create Event</x-create-button>
        </x-slot>
    </x-jet-dialog-modal>

    <x-jet-confirmation-modal wire:model="showConfirmDeleteModal">
        <x-slot name="title">
            Delete Event
        </x-slot>

        <x-slot name="content">
            Are you sure you would like to delete this event?
        </x-slot>

        <x-slot name="footer">
            <x-buttons.cancel-button wire:click="cancelDelete">Cancel</x-buttons.cancel-button>
            <x-jet-button wire:click="deleteEvent">Delete</x-jet-button>
        </x-slot>
    </x-jet-confirmation-modal>
    {{-- End modals --}}

    @push('scripts')
        <script src='https://cdn.jsdelivr.net/npm/fullcalendar@5.3.1/main.min.js'></script>
        
        <script>
            document.addEventListener('livewire:load', function() {    
                setTimeout(() => {
                    var Calendar = FullCalendar.Calendar;
                    var Draggable = FullCalendar.Draggable;
                    var calendarEl = document.getElementById('calendar');
                    var checkbox = document.getElementById('drop-remove');
                    var data = JSON.parse(@this.json);
                    var selectedEvent;

                    var calendar = new Calendar(calendarEl, {
                        customButtons: {
                            addButton: {
                                text: 'Add Event',
                                click: function() {
                                    document.querySelectorAll('.emailsEditor__email').forEach(e => {
                                        e.remove();
                                    });
                                    @this.showCreateEventModal = true;
                                }
                            }
                        },
                        headerToolbar: {
                            left: 'prev,next today addButton',
                            center: 'title',
                            right: 'dayGridMonth,timeGridWeek,timeGridDay'
                        },
                        events: data,
                        dateClick: function(info)  {
                            document.querySelectorAll('.emailsEditor__email').forEach(e => {
                                e.remove();
                            });
                            @this.dateClick(info.dateStr);
                        },
                        eventClick: function(info) {
                            selectedEvent = info.event;
                            Livewire.emit('eventClicked', info.event.id);
                        },
                        editable: false,
                        selectable: true,
                        displayEventTime: false,
                        droppable: false,
                        loading: function(isLoading) {
                            if (!isLoading) {
                                // Reset custom events
                                this.getEvents().forEach(function(e){
                                    if (e.source === null) {
                                        e.remove();
                                    }
                                });
                            }
                        }
                    });
                    calendar.render();

                    //To switch between different calendars
                    @this.on(`refreshCalendar`, () => {
                        calendar.getEvents().forEach(e => {
                            e.remove();
                        });

                        JSON.parse(@this.json).forEach(e => {
                            calendar.addEvent(e);
                        });
                    });

                    //Creating a new event
                    Livewire.on('createEvent', function(id) {
                        calendar.addEvent({
                            id: id,
                            title: @this.eventData['eventSubject'],
                            start: @this.eventData['eventStart'],
                            end: @this.eventData['eventEnd'],
                            body: @this.eventData['eventBody'],
                        });

                        @this.resetNewEvent();
                    });

                    //Event is edited
                    Livewire.on('updatedEvent', function() {
                        selectedEvent.setProp('title', @this.selectedEvent['title']);
                        selectedEvent.setStart(@this.selectedEvent['start']);
                        selectedEvent.setEnd(@this.selectedEvent['end']);
                        selectedEvent.setExtendedProp('body', @this.selectedEvent['body']);
                    });

                    //Event is deleted
                    Livewire.on('deletedEvent', function() {
                        selectedEvent.remove();
                    });
                }, 160); 

                //multi-email input
                const inputContainerNode = document.querySelector('#emails-input');
                const emailsInput = EmailsEditor(inputContainerNode, function() {
                    @this.set('eventData.eventAttendees', emailsInput.getEmails());
                });

                Livewire.on('editEvent', function() {
                    const editingInputContainerNode = document.querySelector('#editing-emails-input');
                    const editingEmailsInput = EmailsEditor(editingInputContainerNode, function() {
                        @this.set('selectedEvent.attendees', editingEmailsInput.getEmails());
                    });

                    @this.selectedEvent['attendees'].forEach(e => {
                        editingEmailsInput.add(e['emailAddress']['address']);
                    });
                })
            });
        </script>
        <link href='https://cdn.jsdelivr.net/npm/fullcalendar@5.3.1/main.min.css' rel='stylesheet' />
    @endpush
</div>