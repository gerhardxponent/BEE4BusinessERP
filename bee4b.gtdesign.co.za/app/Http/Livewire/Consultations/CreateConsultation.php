<?php

namespace App\Http\Livewire\Consultations;

use App\Models\Clients;
use Livewire\Component;
use App\Models\Consultation;
use App\TokenStore\TokenCache;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Microsoft\Graph\Graph;
use Microsoft\Graph\Model;

class CreateConsultation extends Component
{
    use AuthorizesRequests;

    public Consultation $consultation;
    public $clients;
    public $selectedClient;
    public $addToMs = false;

    public $attendees;
    // public function showTest() {
    //     foreach($this->test as $index => $item) {
    //         $this->test[$index] = $item['value'];
    //     }

    //     dd($this->test);
    // }

    public $breadcrumbs = [];

    public $rules = [
        'consultation.name' => 'required|alpha_dash',
        // 'selectedClient' => 'required|regex:/\d+/',
        'consultation.consultationdate' => 'required',
        'consultation.starttime' => 'required',
        'consultation.endtime' => 'required',
        'consultation.details' => 'nullable',
        // 'consultation.attendees' => 'nullable',
        'addToMs' => 'required'
    ];

    public function mount()
    {
        $this->consultation = Consultation::make();
        $this->clients = Clients::all();
        $this->breadcrumbs = ['Consultations', 'Create Consultation'];
    }

    public function render()
    {
        return view('livewire.consultations.create-consultation');
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

    public function submit()
    {
        dd($this->attendees);
        
        $this->authorize('create consultations');
        $this->validate();
        foreach($this->attendees as $index => $attendee) {
            $this->attendees[$index] = $attendee['value'];
        }
        $this->consultation->attendees = join(';', $this->attendees);

        $this->consultation->client_id = $this->selectedClient;
        $this->consultation->save();

        if($this->addToMs) {
            $graph = $this->getGraph();
            $msAttendees = [];

            foreach($this->attendees as $attendeeAddress) {
                array_push($msAttendees, [
                    'emailAddress' => [
                        'address' => $attendeeAddress
                    ],
                    'type' => 'required'
                ]);
            }

            $newEvent = [
                'subject' => $this->consultation->name,
                "body" => [
                    "contentType" => "HTML",
                    "content" => $this->consultation->details
                ],
                'start' => [
                    'dateTime' => $this->consultation->starttime,
                    'timeZone' => "South Africa Standard Time"
                ],
                'end' => [
                    'dateTime' => $this->consultation->endtime,
                    'timeZone' => "South Africa Standard Time"
                ],
                "attendees" => $msAttendees
            ];

            $response = $graph->createRequest('POST', '/me/events')
                ->attachBody($newEvent)
                ->setReturnType(Model\Event::class)
                ->execute();

            // dd($response);

            $this->emit('event_created');
        }

        session()->flash('message', 'Consultation Created Successfully!');
        return redirect()->to('/consultations');
    }
}
