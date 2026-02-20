<?php

namespace App\Http\Livewire\Leads;

use Exception;
use App\Models\Lead;
use App\Models\User;
use App\Models\Activity;
use App\Models\Clients;
use App\Models\Contact;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Models\Setting;

class LeadDetails extends Component
{
    use WithFileUploads;

    public $lead;
    public $currentUser;
    public $editing = false; 
    public $showDeleteConfirmModal = false;
    public $tabs = ['overview', 'consultations', 'projects', 'files', 'activity'];
    public $currentTab = 'overview';
    public $showConversionErrorModal = false;

    public $showEmailApplicationModal = false;
    public $emailTo;
    public $emailSubject = "Application Form";
    public $emailBody = "Dear Applicant,\n\nPlease find attached the application form.\n\nBest regards,\nBEE4Business";

    protected $queryString = [
        'currentTab' => ['as' => 'tab'],
    ];

    protected $listeners = [
        'refreshComponent' => '$refresh',
        'changeTab',
        'consultationCreated',
        'changeLeadStatus'
    ];

    public function mount($id)
    {
        try {
            $this->lead = Lead::findOrFail($id);
            $this->currentUser = User::findOrFail(Auth::id());

            // Prefill the email recipient
            $this->emailTo = $this->lead->email_address ?? '';

             // Load defaults from Settings (initial page load)
            $this->hydrateEmailFromSettings();

        } catch (Exception $e) {
            Log::error($e->getMessage());
            return redirect('leads');
        }
    }

        /**
     * Replace {{lead.*}} placeholders in the settings template.
     */
    protected function renderLeadTemplate(string $template): string
    {
        $map = [
            '{{lead.name}}'          => (string) $this->lead->name,
            '{{lead.company_name}}'  => (string) $this->lead->company_name,
            '{{lead.email_address}}' => (string) $this->lead->email_address,
            '{{lead.primary_phone}}' => (string) $this->lead->primary_phone,
            '{{lead.city}}'          => (string) $this->lead->city,
            '{{lead.province}}'      => (string) $this->lead->province,
            '{{lead.country}}'       => (string) $this->lead->country,
        ];
        return strtr($template, $map);
    }

    /**
     * Pull the latest subject/body from Settings and render placeholders.
     */
    protected function hydrateEmailFromSettings(): void
    {
        $this->emailSubject = Setting::get('lead_app_email_subject', 'Application Form');
        $template = Setting::get('lead_app_email_body', "Dear {{lead.name}},\n\nPlease find attached the application form.\n\nBest regards,\nBEE4Business");
        $this->emailBody = $this->renderLeadTemplate($template);
    }

    /**
     * Open the modal and refresh values from Settings (in case they changed).
     */
    public function openEmailApplicationModal(): void
    {
        $this->hydrateEmailFromSettings();
        $this->showEmailApplicationModal = true;
    }

    public function sendApplicationFormEmail()
    {
        if (!$this->emailTo) {
            session()->flash('message', 'Email address is required.');
            return;
        }

        // Resolve attachment path from Settings (public disk path like "application_forms/…")
        $stored = Setting::get('lead_app_form_path'); 
        $pdfPath = $stored
            ? storage_path('app/public/' . $stored)
            : storage_path('app/public/Application_Form.pdf'); // fallback

        Mail::send([], [], function ($message) use ($pdfPath) {
            $message->to($this->emailTo)
                ->cc(['xiiphoid@gmail.com', 'reg@bee4business.co.za'])
                ->subject($this->emailSubject)
                ->attach($pdfPath, [
                    'as' => "Application_Form.pdf",
                    'mime' => 'application/pdf',
                ])
                ->setBody(nl2br($this->emailBody), 'text/html');
        });

        // Log the activity
        Activity::create([
            'user_id' => auth()->id(),
            'body' => 'Sent an application form to ' . $this->emailTo,
            'activity_type' => 'email',
            'activityable_id' => $this->lead->id,
            'activityable_type' => Lead::class,
            'title' => 'Sent an email',
            'path' => ''
        ]);

        // Close modal and show success message
        $this->showEmailApplicationModal = false;
        session()->flash('message', 'Application form emailed successfully.');
        // Show a success notification in the frontend
        $this->dispatchBrowserEvent('notify-success', ['message' => 'Email sent successfully!']);
    }

    public function render()
    {
        return view('livewire.leads.lead-details')
            ->layoutData([
                'backText' => 'all Leads'
            ]);
    }

    public function changeTab($tab)
    {
        $this->editing = false;
        $this->currentTab = $tab;
    }

    protected function generateInitials()
    {
        if($this->lead->name == '') return '';

        $words = explode(" ", trim($this->lead->name));
        $initials = null;
        foreach ($words as $w) {
            $initials .= $w[0];
        }
        return $initials;
    }

    public function newActivity($title, $body, $type)
    {
        $activity = Activity::make();

        $activity->user_id = $this->currentUser->id;
        $activity->title = ' ' . $title;
        $activity->body = $body;
        $activity->activity_type = $type;
        $activity->path = 'Leads / ' . $this->lead->name;
        $this->lead->activities()->save($activity);
    }

    public function update()
    {
        $this->newActivity('updated this lead', '', 'update');
        $this->editing = false;
        $this->emit('updateLead');
        $this->emitSelf('refreshComponent');
        session()->flash('message', 'Changes saved successfully');
    }

    public function createClient()
    {
        $client = Clients::make([
            'name' => $this->lead->company_name, 
            'email' => $this->lead->email_address,
            'phone' => $this->lead->primary_phone,
            'sector' => $this->lead->sector_id,
            'address' => $this->lead->address,
            'city' => $this->lead->city,
            'province' => $this->lead->province,
            'country' => $this->lead->country,
        ]);
        $client->save();

        if (isset($this->lead->contact)) {
            $this->lead->contact->contactable()->save($client);
        }

        $this->lead->client_id = $client->id;
        $this->lead->save();

        $this->emitSelf('refreshComponent');
        $this->dispatchBrowserEvent('notify-success', ['message' => 'New client created']);
    }

    public function createContact()
    {
        $contact = Contact::make([
            'name' => $this->lead->name,
            'jobtitle' => '',
            'email' => $this->lead->email_address,
            'phone_primary' => $this->lead->primary_phone,
            'phone_secondary' => $this->lead->secondary_phone,
        ]);

        $contact->save();

        if (isset($this->lead->client)) {
            $this->lead->client->contactsMorph()->save($contact);
        }

        $this->lead->contact_id = $contact->id;
        $this->lead->save();

        $this->emitSelf('refreshComponent');
        $this->dispatchBrowserEvent('notify-success', ['message' => 'New contact created']);
    }

    public function convertLead()
    {
        if ($this->lead->company_name === null || $this->lead->email_address === null) {
            $this->showConversionErrorModal = true;
            return;
        }

        $client = Clients::make([
            'name' => $this->lead->company_name, 
            'email' => $this->lead->email_address,
            'phone' => $this->lead->primary_phone,
            'sector' => $this->lead->sector_id,
            'address' => $this->lead->address,
            'city' => $this->lead->city,
            'province' => $this->lead->province,
            'country' => $this->lead->country,
        ]);

        $client->save();

        $contact = Contact::make([
            'name' => $this->lead->name,
            'jobtitle' => '',
            'email' => $this->lead->email_address,
            'phone_primary' => $this->lead->primary_phone,
            'phone_secondary' => $this->lead->secondary_phone,
        ]);

        $client->contactsMorph()->save($contact);

        $this->lead->client_id = $client->id;
        $this->lead->contact_id = $contact->id;
        $this->lead->lead_status_id = 1; // Mark as converted
        //$this->lead->lead_status_id = null;
        //$this->lead->status = 1;
        $this->lead->deleted_at = now();
        $this->lead->save();

        foreach ($this->lead->files as $file) {
            $file->fileable_type = 'App\Models\Clients';
            $file->fileable_id = $client->id;
            $file->save();
        }

        //$this->lead->delete();

        $this->emitSelf('refreshComponent');
        $this->newActivity('converted this lead', '', 'lead conversion');
        $this->dispatchBrowserEvent('notify-success', ['message' => 'Lead converted - New contact and client created']);
    }

    public function delete()
{
    // Log the activity before deletion
    $this->newActivity(
        'has deleted a lead: <span class="font-bold">' . $this->lead->name . '</span>',
        '',
        'delete'
    );

    $this->lead->lead_status_id = 3;
    $this->lead->deleted_at = now();
    $this->lead->save();
    return redirect()->to('/leads');
}


    public function toggleEdit()
    {
        $this->editing = !$this->editing;

        $this->emit('toggleEditLead');
    }

    public function sendOutlookEmail()
    {
        $this->emit('showOutlookEmailModal', []);
    }

    public function newConsultation()
    {
        $this->emit('createConsultation');
    }

    public function changeLeadStatus()
    {
        // 1.green -> 3.red -> 2.yellow -> 1.green
        switch ($this->lead->lead_status_id) {
            case 1:
                $this->lead->lead_status_id = 3;
                break;
            case 2:
                $this->lead->lead_status_id = 1;
                break;
            case 3:
                $this->lead->lead_status_id = 2;
                break;
            default: 
                $this->lead->lead_status_id = 1;
        }

        $this->lead->save();
    }

    public function consultationCreated()
    {
        $this->emit('pg:eventRefresh-leadConsultationsTable');
    }
}