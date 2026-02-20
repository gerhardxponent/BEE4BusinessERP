<?php

namespace App\Http\Livewire\Consultations;

use App\Models\Consultation;
use App\TokenStore\TokenCache;
use Illuminate\Support\Facades\Cookie;
use Livewire\Component;
use Microsoft\Graph\Graph;
use Throwable;

class ConsultationDetails extends Component
{
    public Consultation $consultation;
    public $showEmailModal = false;
    public $msEmail;
    public $emailData = [
        'recipient' => '',
        'subject' => '',
        'body' => ''
    ];
    public $breadcrumbs = [];

    protected $rules = [
        'emailData.recipient' => 'required',
        'emailData.subject' => 'required',
        'emailData.body' => 'required',
    ];

    public function mount($id)
    {
        $this->consultation = Consultation::find($id);
        $this->msEmail = Cookie::get('msEmail');
        $this->breadcrumbs = ['Consultations', $this->consultation->name];
    }

    public function render()
    {
        return view('livewire.consultations.consultation-details')
            ->layoutData([
                'backText' => 'all Consultations'
            ]);
    }

    protected function getGraph()
    {
        try {
            // Get the access token from the cache
            $tokenCache = new TokenCache();
            $accessToken = $tokenCache->getAccessToken();

            // Create a Graph client
            $graph = new Graph();
            $graph->setAccessToken($accessToken);
            return $graph;
        } catch(Throwable $e) {
            dd($e);
        }
    }

    public function sendOutlook()
    {
        $payload = [
            'Message' => [
                'subject' => $this->emailData['subject'],
                'body' => [
                    'contentType' => 'Html',
                    'content' => $this->emailData['body'],
                ],
                'toRecipients' => [
                    [
                        'emailAddress' => [
                            'address' => $this->emailData['recipient'],
                        ]
                    ]
                ],
            ],
            'saveToSentItems' => "true",
        ];

        $graph = $this->getGraph();

        $post = $graph->createRequest("POST", '/me/sendMail')
            ->attachBody($payload)
            ->execute();

        $this->showEmailModal = false;
        session()->flash('message', 'Email sent successfully');
    }

    public function openModal($recipient)
    {
        $this->emailData['recipient'] = $recipient;
        $this->showEmailModal = true;
    }

    public function closeEmailModal() 
    {
        $this->showEmailModal = false;
    }
}
