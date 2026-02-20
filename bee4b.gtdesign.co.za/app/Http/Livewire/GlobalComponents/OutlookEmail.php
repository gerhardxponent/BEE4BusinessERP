<?php

namespace App\Http\Livewire\GlobalComponents;

use App\Models\Contact;
use App\TokenStore\TokenCache;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Microsoft\Graph\Graph;
use Throwable;

class OutlookEmail extends Component
{
    public $showEmailModal = false;
    public $msEmail = '';
    public $attachments = [];
    public $emailData = [
        'recipients' => [],
        'subject' => '',
        'body' => ''
    ];

    protected $queryString = [
        'showEmailModal' => ['as' => 'showEmail']
    ];

    public $contactEmails = [];

    protected $listeners = [
        'showOutlookEmailModal',
        'refreshOutlook' => '$refresh',
    ];

    protected $rules = [
        'emailData.recipients' => 'required',
        'emailData.subject' => 'required',
        'emailData.body' => 'required',
    ];

    public function mount()
    {
        $this->msEmail = Cookie::get('msEmail');
        if ($this->contactEmails === []) {
            $this->contactEmails = Contact::all()->pluck('email');
        }
    }

    public function render()
    {
        return view('livewire.global-components.outlook-email');
    }

    public function signInMs()
    {
        return redirect()->to('/signin');
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
        } catch (Throwable $e) {
            dd($e);
        }
    }

    public function toggleModal() { $this->showEmailModal = true; }

    public function showOutlookEmailModal($files)
    {
        foreach ($files as $file) {
            $fileLocation = $file['file_path'] . '/' . $file['file_name'] . '.' . $file['type'];
            $fileData = chunk_split(base64_encode(Storage::disk('local')->get($fileLocation)));
            array_push($this->attachments, [
                '@odata.type' => '#microsoft.graph.fileAttachment',
                'Name' => $file['file_name'],
                'ContentBytes' => $fileData,
                'contentType' => Storage::mimeType($fileLocation)
            ]);
        }
        $this->showEmailModal = true;
    }

    public function closeEmailModal()
    {
        $this->showEmailModal = false;
    }

    public function sendOutlook()
    {
        $recipients = [];

        foreach ($this->emailData["recipients"] as $email) {
            array_push($recipients, ['emailAddress' => [
                'address' => $email,
            ]]);
        }

        $payload = [
            'Message' => [
                'subject' => $this->emailData['subject'],
                'body' => [
                    'contentType' => 'Html',
                    'content' => $this->emailData['body'],
                ],
                'toRecipients' => $recipients,
                'attachments' => $this->attachments,
            ],
            'saveToSentItems' => "true",
        ];

        try{
            $graph = $this->getGraph();

            $post = $graph->createRequest("POST", '/me/sendMail')
                ->attachBody($payload)
                ->execute();

            $this->attachments = [];
            $this->showEmailModal = false;
            session()->flash('message', 'Email sent successfully');
        } catch(Throwable $e) {
            session()->flash('error_flash', 'Error: Email could not be sent');
        }
    }
}
