<?php

namespace App\Http\Livewire\Consultations\Components;

use App\Jobs\MSGraphEmailJob;
use App\Models\BoardItem;
use App\Models\Clients;
use Livewire\Component;
use App\Models\Consultation;
use App\Models\Contact;
use App\Models\Lead;
use App\TokenStore\TokenCache;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Microsoft\Graph\Graph;
use Microsoft\Graph\Model;
use Throwable;

class CreateConsultationModal extends Component
{
    use AuthorizesRequests;

    public Consultation $consultation;
    public $clients;
    
    public $clientId;
    public $entity;

    public $attendees;
    public $addToMs = false;
    public $showCreateConsultationsModal = false;


    public $rules = [
        'consultation.name' => 'required|alpha_dash',
        // 'selectedClient' => 'required|regex:/\d+/',
        'consultation.client_id' => 'required',
        'consultation.consultationdate' => 'required',
        'consultation.starttime' => 'required',
        'consultation.endtime' => 'required',
        'consultation.details' => 'nullable',
        // 'consultation.attendees' => 'nullable',
        'addToMs' => 'required',
        'attendees' => 'required',
    ];

    public $contactEmails;
    public $leadEmails;
    public $attendeeEmails;

    protected $listeners = [
        'createConsultation' => 'showModal',
        'updateConsultationEntity'
    ];

    public function updateConsultationEntity($id, $entityName)
    {
        $this->entity = $entityName::find($id);
        $this->showModal();
    }

    public function showModal()
    {
        $this->showCreateConsultationsModal = true;
    }

    public function mount()
    {
        $this->consultation = Consultation::make();
        if (isset($this->clientId)) $this->consultation->client_id = $this->clientId;
        $this->clients = Clients::all();
        $this->contactEmails = Contact::all()->pluck('email');
        $this->leadEmails = Lead::all()->pluck('email');
        $this->attendeeEmails = $this->contactEmails->merge($this->leadEmails);
    }

    // public function clearEmails()
    // {
    //     $this->contactEmails = [];
    //     $this->emit('updateSelect2');
    // }

    public function render()
    {
        return view('livewire.consultations.components.create-consultation-modal');
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
        $this->authorize('create consultations');
        $this->validate([
            'consultation.name' => 'required',
            'consultation.consultationdate' => 'required',
            'consultation.starttime' => 'required',
            'consultation.endtime' => 'required',
            'consultation.details' => 'nullable',
            'attendees' => 'required',
        ]);

        isset($this->entity) ? $this->entity->consultable()->save($this->consultation) : $this->consultation->save();

        if($this->addToMs) {
            $graph = $this->getGraph();

            $recipients = [];

            foreach ($this->attendees as $email) {
                array_push($recipients, ['emailAddress' => [
                    'address' => $email,
                ]]);
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
                "attendees" => $recipients
            ];

            try{
                $response = $graph->createRequest('POST', '/me/events')
                    ->attachBody($newEvent)
                    ->setReturnType(Model\Event::class)
                    ->execute();

                session()->flash('message', 'Email sent successfully');
            } catch(Throwable $e) {
                session()->flash('error_flash', 'Error: Email could not be sent');
            }

            // dispatch(
            //     new MSGraphEmailJob(
            //         $this->getGraph(),
            //         $this->attendees, 
            //         $this->consultation->name, 
            //         $this->consultation->details, 
            //         $this->consultation->starttime, 
            //         $this->consultation->endtime
            //     )
            // );

            $this->emit('event_created');
        }

        $this->consultation = Consultation::make();
        $this->showCreateConsultationsModal = false;
        $this->emit('consultationCreated');
    }
}
