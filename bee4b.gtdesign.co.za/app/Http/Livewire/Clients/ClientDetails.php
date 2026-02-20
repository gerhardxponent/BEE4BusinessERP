<?php

namespace App\Http\Livewire\Clients;

use App\Models\Activity;
use Illuminate\Support\Facades\Schema;
use App\Models\Clients;
use App\Models\Contact;
use App\Models\File;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\TokenStore\TokenCache;
use Illuminate\Support\Facades\Cookie;
use Microsoft\Graph\Graph;
use Microsoft\Graph\Model;
use Illuminate\Support\Facades\Mail;
use stdClass;
use Throwable;

class ClientDetails extends Component
{
    use WithFileUploads;
    use AuthorizesRequests;
    
    public $currentUser;

    public $showDeleteModal = false;
    
    public $listeners = [
        'refreshComponent' => '$refresh',
        'email_files' => 'openEmailModal', 
        'configureDefaultTasks',
        'toggleCertModal',
        'successFlash',
        'changesSaved'
    ];

    public $client;
    // public $client_files = [];
    // public $quotes;
    // public $client_backup;
    // public $attributeCount;
    public $editing = false;
    public $currentTab = 'projects';
    public $tabs = [
        1 => 'projects',
        2 => 'overview',
        3 => 'procurement',
        7 => 'files',
        8 => 'OneDrive',
        9 => 'activity',
    ];

    // 1 projects, 2 overview, 3 audits, 4 consultations, 5 contacts, 6 quotes, 7 files, 8 onedrive, 9 activity

    public $showEmailModal = false;
    public $emailData = [
        'recipient' => '',
        'subject' => '',
        'body' => ''
    ];

    //certificate details
    public $cert_file;
    public $cert_name;
    public $cert_exp_date;
    public $cert_comments;
    public $cert_uploader;
    public $current_cert;
    public $cert_original_name;
    public $replace_cert = false;
    public $showCertUploadModal = false;

    // public $user;
    // public $showCreateUserModal = false;
    // public $newUserRole = '';
    // public $managerSelect;
    // public $analystSelect;

    //OneDrive
    public $remoteDriveId = '';
    public $remoteItemId = '';
    public $curDir = [];
    public $oneDriveFile;
    public $newFolderName = '';
    public $oneDriveNewFolder = false;
    public $selectedOdFolder = '';

    //Outlook emails
    public $attachments = [];
    public $emailRecipient;
    public $emailSubject;
    public $emailBody;
    public $msEmail;

    //Tasks
    // public $showTaskSettings = false;

    //Audits
    public $clientAudits;
    public $currentAuditID;

    protected $queryString = [
        'currentTab' => ['as' => 'tab']
    ];

    protected $rules = [
        'file' => 'required',

        'client.name' => 'required',
        'client.email' => 'required',
        'client.phone' => 'required',
        'client.address' => 'required',
        'client.city' => 'required',
        'client.province' => 'required',
        'client.postal_code' => 'required',
        'client.country' => 'required',
        'client.onedrive_folder' => 'required',
        'client.size' => 'required',
        'client.sector' => 'required',
        'client.region' => 'required',
        'client.manager' => 'required',
        'client.analyst' => 'required',
        'client.state' => 'required',
        'client.fye' => 'required',
        'client.deadline' => 'required',
        'client.next_report_required' => 'required',
        'client.next_audit' => 'required',
        'client.engagement_type' => 'required',

        'cert_exp_date' => 'required',
        'cert_comments' => 'required',
        'cert_name' => 'required',
        'current_cert.file_name' => 'required',
        'current_cert.expiry_date' => 'required',
        'current_cert.reviewer_comments' => 'required',

        'emailData.recipient' => 'required',
        'emailData.subject' => 'required',
        'emailData.body' => 'required',

        'user.name' => 'required|min:2',
        'user.email' => 'required|email',
        'user.password' => 'required|min:4',

        'fileDetails.file_name' => 'nullable',
        'fileDetails.client_comments' => 'nullable',
        'fileDetails.reviewer_comments' => 'nullable',
        'fileDetails.status' => 'required',

        'selectedFile.file_name' => 'nullable',
        'selectedFile.client_comments' => 'nullable',
        'selectedFile.reviewer_comments' => 'nullable',
        'selectedFile.status' => 'nullable',

        'oneDriveFile' => 'required',
        'newFolderName' => 'required',

        'emailRecipient' => 'required',
        'emailSubject' => 'required',
        'emailBody' => 'required',

        'newComment.body' => 'required',

        'currentAuditID' => 'required',
    ];

    public function mount($id)
    {
        $this->currentUser = User::find(Auth::id());
        $this->client = Clients::find($id);

        if (!$this->client) {
            abort(404, 'Client not found');
        }

        if ($this->currentUser->hasRole('Client') || $this->currentUser->hasRole('Client Sub User')) {
            // Restrict to only the user's company
            $userClientIds = array_filter(
                array_map('trim', explode(',', $this->currentUser->client_id))
            );

            if (! in_array($this->client->id, $userClientIds, true)) {
                //return redirect()->to('/clients');
            }
        } elseif (!Auth::user()->hasPermissionTo('view all projects')) {
            // Restrict to other user roles with limited access
            $clients = Clients::query()
                ->where(function ($query) {
                    $query->whereHas('boardsMorph.consultant', fn($q) => $q->where('id', Auth::id()))
                        ->orWhereHas('boardsMorph.analyst', fn($q) => $q->where('id', Auth::id()))
                        ->orWhereHas('boardsMorph.jnrAnalyst', fn($q) => $q->where('id', Auth::id()))
                        ->orWhere('manager', Auth::id())
                        ->orWhere('analyst', Auth::id());
                })
                ->pluck('id');

            if (!$clients->contains($id)) {
                return redirect()->to('/clients');
            }
        }

        if ($this->currentUser->hasRole('Client')) {
            // Limit tabs for Client and Client Sub User
            $this->tabs = [
                2 => 'overview',
                6 => 'contacts',
                9 => 'activity',
            ];
        }
        else if ($this->currentUser->hasRole('Client Sub User')){
            // Limit tabs for Client and Client Sub User
            $this->tabs = [
                2 => 'overview',
                9 => 'activity',
            ];
        }
        else {
            // Add tabs based on permissions for other roles
            $additionalModules = [4 => 'audits', 5 => 'consultations', 6 => 'contacts', 7 => 'quotes'];
    
            foreach ($additionalModules as $key => $module) {
                if ($this->currentUser->hasPermissionTo('view ' . $module)) {
                    $this->tabs[$key] = $module;
                }
            }
        }

        // Default tab is 'projects' unless the user is a Client or Client Sub User
        if ($this->currentUser->hasRole('Client') || $this->currentUser->hasRole('Client Sub User')) {
            $this->currentTab = 'overview';
        } else {
            $this->currentTab = 'projects';
        }
    
        ksort($this->tabs);

        $this->msEmail = Cookie::get('msEmail');

        if ($this->client->certificate_location != null) {
            $this->current_cert = $this->client->files()->where('is_certificate', 1)->orderBy('created_at', 'desc')->first();

            $this->cert_uploader = User::find($this->current_cert->user_id)->name;
            $this->cert_original_name = $this->current_cert->file_name;
        }

        if ($this->client->onedrive_folder != null) {
            array_push($this->curDir, $this->client->onedrive_folder);
        }

        $this->clientAudits = $this->client->audits;
        $this->currentAuditID = $this->clientAudits->last() ? $this->clientAudits->last()->id : null;
    }


    public function render()
    {
        $backText = (Auth::user()->hasRole('Client') || Auth::user()->hasRole('Client Sub User'))
            ? 'all Companies'
            : 'all Clients';

        return view('livewire.clients.client-details')
            ->layoutData([
                'backText' => $backText,
            ]);
    }

    // Listener functions
    public function successFlash($message) { session()->flash('message', $message); }
    public function changesSaved() { $this->editing = false; }
    // End listener functions

    //gets manager/analyst initials
    protected function generateInitials($name)
    {
        $words = explode(" ", trim($name));
        if (count($words) == 0) return "";
        
        $initials = "";
        foreach ($words as $w) {
            $initials .= $w[0];
        }
        return $initials;
    }

    public function toggleCertModal()
    {
        $this->showCertUploadModal = true;
    }

    public function uploadCertERP()
    {
        // if($this->current_cert != null && $this->replace_cert == true) {
        //     if(Storage::exists($this->current_cert->file_path . '/' . $this->current_cert->file_name . '.' . $this->current_cert->type))  {
        //         Storage::delete($this->current_cert->file_path . '/' . $this->current_cert->file_name . '.' . $this->current_cert->type);
        //         $this->current_cert->delete();
        //         $this->replace_cert = false;
        //         session()->flash('message', 'New certificate successfully uploaded!');
        //     } else {
        //         dd('File not found');
        //     }
        // }

        $cert = File::make();

        $cert->file_name = $this->cert_name;
        $cert->file_path = 'uploads/' . preg_replace('/\s+/', '_', $this->client->name);
        $cert->client_id = $this->client->id;
        $cert->user_id = Auth::id();
        $cert->file_size = $this->cert_file->getSize()/1024;
        $cert->type = $this->cert_file->getClientOriginalExtension();
        $cert->reviewer_comments = $this->cert_comments;
        $cert->status = 'Accepted';
        $cert->is_certificate = true;
        $cert->expiry_date = $this->cert_exp_date;

        // $this->client->current_certificate_expiry = $this->cert_exp_date;
        // $this->client->certificate_location = 'ERP';

        $this->client->files()->save($cert);

        //saves certificate to files table
        $this->client->certificate_erp_key = $cert->id;
        //saves certificate location to clients table
        $this->client->save();

        $this->current_cert = $cert;
        $this->cert_uploader = User::find($this->current_cert->user_id)->name;

        $this->cert_file->storeAs('uploads/' . preg_replace('/\s+/', '_', $this->client->name), $cert->file_name . '.' . $this->cert_file->getClientOriginalExtension());
        // $this->emit('pg:eventRefresh-ClientFilesTable');
        $this->showCertUploadModal = false;

        $this->emit('certUploaded');
    }    

    public function changeTab($tabName) 
    {
        $this->currentTab = $tabName;
        $this->editing = false;
        $this->emit('tab_changed');
    }

    public function contactRedirect($id) { return redirect()->to('/contacts/' . $id); }

    public function setEdit()
    {
        $this->emit('editDetails');

        $this->editing = !$this->editing;
    }

    public function update()
    {
        $this->emit('saveClientDetails');
    }

    public function delete($id)
    {
        $this->authorize('delete clients');
        // $this->client->deleted = 1;
        // $this->client->save();
        Clients::find($id)->delete();
        return redirect()->to('/clients');
    }

    //Emails with ERP address
    public function sendEmail()
    {
        $to_email = $this->emailData['toAddress'];

        try {
            Mail::send('simple-mail', ['data' => nl2br($this->emailData['emailBody'])], function($message) use ($to_email) {
                $message->to($to_email)
                        ->subject($this->emailData['emailSubject']);
            });
            // $this->emit('email_sent');
            $this->showEmailModal = false;
            session()->flash('message', 'Email sent successfully!');
        } catch (Throwable $e) {
            // $this->emit('email_sent');
            dd($e);
        }
    }

    //--------------------------------------------------------
    //OneDrive Files
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

    //when client has no linked OneDrive Folder
    public function getClientListProperty()
    {
        $graph = $this->getGraph();

        try {
            $clients = $graph->createRequest('GET', '/drives/'.env('REMOTE_DRIVE_ID').'/items/'.env('REMOTE_ITEM_ID').'/children')
                ->setReturnType(Model\DriveItem::class)
                ->execute();
            return $clients;
        } catch(Throwable $e) {
            dd($e);
            return;
        }
    }

    //when client has a linked OneDrive folder
    public function getOdFilesProperty()
    {
        $graph = $this->getGraph();
        $dirString = join('/', $this->curDir);

        try {
            $files = $graph->createRequest('GET', '/drives/'.env('REMOTE_DRIVE_ID').'/items/'.env('REMOTE_ITEM_ID').':/'.$dirString.':/children')
                ->setReturnType(Model\DriveItem::class)
                ->execute();
                // dd($files[5]->getOdataType());
            return $files;
        } catch(Throwable $e) {
            dd("error");
            return;
        }
    }

    //Upload file to OneDrive
    public function updatedOneDriveFile()
    {
        $graph = $this->getGraph();

        $file_name = $this->oneDriveFile->getClientOriginalName();

        $media_path = $this->oneDriveFile->getRealPath();

        $postData = [
            'items' => [
                "@odata.type" => "microsoft.graph.driveItemUploadableProperties",
                "@microsoft.graph.conflictBehavior" => "rename",
                "name" => $file_name
            ]
        ];

        try {
            $post = $graph->createRequest('PUT', '/drives/' . env('REMOTE_DRIVE_ID') . '/items/' . env('REMOTE_ITEM_ID') .':/'. join('/', $this->curDir) . '/' . $file_name .':/content?@microsoft.graph.downloadUrl')
                ->attachBody($postData)
                ->upload($media_path);
            $this->oneDriveFile = null;
            session()->flash('message', 'File successfully uploaded to OneDrive!');
        } catch(\Illuminate\Http\Client\RequestException $e) {
            dd($e);
        }
    }

    public function createFolder()
    {
        $this->validate([
            'newFolderName' => 'required'
        ]);

        $graph = $this->getGraph();

        $postData = [
            'name' => $this->newFolderName,
            'folder' => new stdClass(),
            '@microsoft.graph.conflictBehavior' => 'rename'
        ];

        try {
            $post = $graph->createRequest('POST' ,'/drives/' . env('REMOTE_DRIVE_ID') . '/items/' . env('REMOTE_ITEM_ID') . ':/' . join('/', $this->curDir) . ':/children')
                ->attachBody($postData)
                ->execute();
            $this->newFolderName = '';
            $this->oneDriveNewFolder = false;
            session()->flash('message', 'New folder created');
        } catch(Throwable $e) {
            dd($e);
        }
        // dd($post);
    }

    public function enterFolder($folderName) { array_push($this->curDir, $folderName); }

    public function previousDir()
    {
        if(count($this->curDir) > 1) 
            array_pop($this->curDir);
        else
            return;
    }

    public function linkFolder()
    {
        if($this->selectedOdFolder == '') return;

        $this->client->onedrive_folder = $this->selectedOdFolder;
        $this->client->save();
        array_push($this->curDir, $this->client->onedrive_folder);
    }

    public function navigateTo($index)
    {
        // dd('hello');

        $lastIndex = count($this->curDir)-1;
        $selectedIndex = $index;
        
        for($i = 0; $i < $lastIndex-$index; $i++) {
            array_pop($this->curDir);
        }

        // $this->emit('loading_complete');
    }

    //Send Outlook emails
    public function closeEmailModal()
    {
        $this->attachments = [];
        $this->showEmailModal = false;
        
        $this->emailData['recipient'] = '';
        $this->emailData['subject'] = '';
        $this->emailData['body'] = '';
    }

    public function openEmailModal($fileIds)
    {
        foreach($fileIds as $fileId) {
            $file = File::find($fileId);
            $fileLocation = $file->file_path . '/' . $file->file_name . '.' . $file->type;
            $fileData = chunk_split(base64_encode(Storage::disk('local')->get($fileLocation)));
            array_push($this->attachments, [
                '@odata.type' => '#microsoft.graph.fileAttachment',
                'Name' => $file->file_name . '.' . $file->type,
                'ContentBytes' => $fileData,
                'contentType' => Storage::mimeType($fileLocation)
            ]);
        }

        $this->showEmailModal = true;
    }

    public function removeAttachment($id)
    {
        unset($this->attachments[$id]);
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

    // public function configureDefaultTasks()
    // {
    //     $this->showTaskSettings = !$this->showTaskSettings;
    // }

    public function createAudit()
    {
        return redirect()->to('/audits/create');
    }

    public function changeAudit($auditId)
    {
        $this->currentAuditID = $auditId;
    }
}