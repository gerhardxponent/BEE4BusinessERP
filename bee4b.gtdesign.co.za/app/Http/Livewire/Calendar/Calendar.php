<?php

namespace App\Http\Livewire\Calendar;

use App\TimeZones\TimeZones;
use App\TokenStore\TokenCache;
use Livewire\Component;
use Illuminate\Support\Facades\Cookie;
use Microsoft\Graph\Graph;
use Microsoft\Graph\Model;

class Calendar extends Component
{
    protected $listeners = ['eventClicked'];

    public $test = [
        'a' => 'first',
        'b' => 'second'
    ];

    public $signedIn = false;
    
    // public $attendees;

    public $editing = false;
    
    public $attendeeEmails = '';

    public $jsEvents = [];
    public $json;
    public $selectedEvent = [
        'title' => '',
        'start' => null,
        'end' => null,
        'body' => '',
        'attendees' => []
    ];
    public $showEventDetailsModal = false;

    public $showCreateModal = false;
    public $showCreateEventModal = false;
    public $showConfirmDeleteModal = false;
    public $eventData = [
        'eventSubject' => '',
        'eventAttendees' => [],
        'eventStart' => null,
        'eventEnd' => null,
        'eventBody' => ''
    ];

    protected $rules = [
        'eventData.eventSubject' => 'nullable|string',
        'eventData.eventAttendees' => 'nullable',
        'eventData.eventStart' => 'required|date',
        'eventData.eventEnd' => 'required|date',
        'eventData.eventBody' => 'nullable|string',

        'selectedEvent.title' => 'required',
        'selectedEvent.start' => 'required',
        'selectedEvent.end' => 'required',
        'selectedEvent.body' => 'required',
        'selectedEvent.attendees' => 'required',
    ];

    public $calendars = [];
    public $currentCalendar;

    public function getCalendars()
    {
        $graph = $this->getGraph();

        $calendarsURL = '/me/calendars/?$select=id,name';

        $this->calendars = array_map(
            fn($value) => ['id' => $value->getId(), 'name' => $value->getName()],
            $graph->createRequest('GET', $calendarsURL)->setReturnType(Model\Calendar::class)->execute()
        );

        $this->currentCalendar = $this->calendars[0]['id'];
    }

    public function updatedCurrentCalendar($value)
    {
        // dd($value);
        $this->jsEvents = [];
        $this->json = $this->getEvents();
        $this->emit('refreshCalendar');
    }

    public function mount()
    {
        if(Cookie::get('msEmail')) {
            $this->signedIn = true;
            $this->getCalendars();
            $this->json = $this->getEvents();
        }
    }
    
    public function render()
    {
        return view('livewire.calendar.calendar');
    }

    protected function getGraph() : Graph
    {
        // Get the access token from the cache
        $tokenCache = new TokenCache();
        $accessToken = $tokenCache->getAccessToken();

        // Create a Graph client
        $graph = new Graph();
        $graph->setAccessToken($accessToken);
        return $graph;
    }

    public function getEvents()
    {
        $data = [];

        $graph = $this->getGraph();

        // Get user's timezone
        $timezone = TimeZones::getTzFromWindows('South Africa Standard Time');

        // Get start and end of week
        $startOfWeek = new \DateTimeImmutable('first day of this month', $timezone);
        $endOfWeek = new \DateTimeImmutable('last day of this month', $timezone);

        $queryParams = array(
            'startDateTime' => $startOfWeek->format(\DateTimeInterface::ISO8601),
            'endDateTime' => $endOfWeek->format(\DateTimeInterface::ISO8601),
            // Only request the properties used by the app
            '$select' => 'subject,organizer,start,end,bodyPreview,attendees',
            // Sort them by start time
            '$orderby' => 'start/dateTime',
            // Limit results to 25
            '$top' => 25
        );

        // Append query parameters to the '/me/calendarView' url
        $getEventsUrl = '/me/calendars/' . $this->currentCalendar . '/events';
        // $getEventsUrl = '/me/events?'.http_build_query($queryParams);
        
        // $getEventsUrl = '/users/keshavedge@outlook.com';
        // $test = $graph->createRequest('GET', $getEventsUrl)
        //     ->execute();
        // dd($test);

        $events = $graph->createRequest('GET', $getEventsUrl)
        // Add the user's timezone to the Prefer header
        ->addHeaders(array(
            'Prefer' => 'outlook.timezone="South Africa Standard Time"'
        ))
        ->setReturnType(Model\Event::class)
        ->execute();

        $data['events'] = $events;

        foreach($data['events'] as $index => $event) {
            array_push($this->jsEvents, [
                'id' => $event->getId(),
                'title' => $event->getSubject(),
                'start' => explode('.', $event->getStart()->getDateTime())[0],
                'end' => explode('.', $event->getEnd()->getDateTime())[0],
                //not part of fullcalendar event object
                'body' => $event->getBodyPreview(),
                'attendees' => $event->getAttendees() 
            ]);
        }

        return json_encode($this->jsEvents);
    }

    public function createEvent()
    {
        // $this->validate();
        $graph = $this->getGraph();
        $attendeeAddresses = array_column($this->eventData['eventAttendees'], 'value');
        $attendees = [];

        foreach($attendeeAddresses as $attendeeAddress) {
            array_push($attendees, [
                'emailAddress' => [
                    'address' => $attendeeAddress
                ],
                'type' => 'required'
            ]);
        }

        $newEvent = [
            'subject' => $this->eventData['eventSubject'],
            "body" => [
                "contentType" => "HTML",
                "content" => $this->eventData["eventBody"]
            ],
            'start' => [
                'dateTime' => $this->eventData['eventStart'],
                'timeZone' => "South Africa Standard Time"
            ],
            'end' => [
                'dateTime' => $this->eventData['eventEnd'],
                'timeZone' => "South Africa Standard Time"
            ],
            "attendees" => $attendees
        ];

        $newEvent = $graph->createRequest('POST', '/me/calendars/' . $this->currentCalendar . '/events')
            ->attachBody($newEvent)
            ->setReturnType(Model\Event::class)
            ->execute();

        array_push($this->jsEvents, [
            'id' => $newEvent->getId(),
            'title' => $newEvent->getSubject(),
            'start' => explode('.', $newEvent->getStart()->getDateTime())[0],
            'end' => explode('.', $newEvent->getEnd()->getDateTime())[0],
            //not part of fullcalendar event object
            'body' => $newEvent->getBodyPreview(),
            'attendees' => $newEvent->getAttendees()
        ]);

        
        $this->emit('createEvent', $newEvent->getId());
        $this->showCreateEventModal = false;
        session()->flash('event_success', 'Event created successfully');
    }

    public function dateClick($date)
    {
        $this->eventData['eventStart'] = $date . 'T08:00';
        $this->eventData['eventEnd'] = $date . 'T08:30';
        $this->showCreateEventModal = true;
    }

    public function updateEvent()
    {
        $graph = $this->getGraph();

        $attendeeAddresses = array_column($this->selectedEvent['attendees'], 'value');
        $attendees = [];

        foreach($attendeeAddresses as $attendeeAddress) {
            array_push($attendees, [
                'emailAddress' => [
                    'address' => $attendeeAddress
                ],
                'type' => 'required'
            ]);
        }

        $newEvent = [
            'subject' => $this->selectedEvent['title'],
            "body" => [
                "contentType" => "HTML",
                "content" => $this->selectedEvent['body'],
            ],
            'start' => [
                'dateTime' => $this->selectedEvent['start'],
                'timeZone' => "South Africa Standard Time"
            ],
            'end' => [
                'dateTime' => $this->selectedEvent['end'],
                'timeZone' => "South Africa Standard Time"
            ],
            "attendees" => $attendees
        ];

        $response = $graph->createRequest('PATCH', '/me/events/' . $this->selectedEvent['id'])
            ->attachBody($newEvent)
            ->setReturnType(Model\Event::class)
            ->execute();

        $this->jsEvents[array_search($this->selectedEvent['id'], array_column($this->jsEvents, 'id'))] = 
        [
            'id' => $this->selectedEvent['id'],
            'title' => $this->selectedEvent['title'],
            'start' => $this->selectedEvent['start'],
            'end' => $this->selectedEvent['end'],
            //not part of fullcalendar event object
            'body' => $this->selectedEvent['body'],
            'attendees' => $attendees
        ];

        $this->emit('updatedEvent');
        $this->showEventDetailsModal = false;
        session()->flash('event_success', 'Event updated successfully');
        $this->editing = false;
    }

    public function eventClicked($id)
    {
        $this->selectedEvent = $this->jsEvents[array_search($id, array_column($this->jsEvents, 'id'))];
        $this->showEventDetailsModal = true;
    }

    public function signIn()
    {
        session(['signInFrom' => 'calendar']);
        return redirect()->to('/signin');
    }

    public function resetNewEvent()
    {
        $this->eventData = [
            'eventSubject' => '',
            'eventAttendees' => [],
            'eventStart' => null,
            'eventEnd' => null,
            'eventBody' => ''
        ];
    }

    public function closeCreateModal()
    {
        $this->resetNewEvent();

        $this->showCreateEventModal = false;
    }

    public function confirmDelete()
    {
        $this->showEventDetailsModal = false;
        $this->showConfirmDeleteModal = true;
    }

    public function cancelDelete()
    {
        $this->showConfirmDeleteModal = false;
        $this->showEventDetailsModal = true;
    }

    public function deleteEvent()
    {
        $graph = $this->getGraph();

        $response = $graph->createRequest('DELETE', '/me/events/' . $this->selectedEvent['id'])
            ->execute();
        
        $this->showConfirmDeleteModal = false;

        $this->selectedEvent = [
            'title' => '',
            'start' => null,
            'end' => null,
            'body' => '',
            'attendees' => []
        ];

        $this->emit('deletedEvent');
        session()->flash('event_success', 'Event deleted successfully');
    }

    public function editEvent()
    {
        if($this->editing) {
            $this->editing = false;
            $res = [];
            foreach($this->selectedEvent['attendees'] as $attendee) {
                array_push($res, [
                    'emailAddress' => [
                        'address' => $attendee['value']
                    ]
                ]);
            }
            $this->selectedEvent['attendees'] = $res;
            return;
        }

        $this->editing = true;
        $this->emit('editEvent');
    }

    public function closeEventDetails()
    {
        if($this->editing) $this->editing = false;

        $this->showEventDetailsModal = false;
    }
}
