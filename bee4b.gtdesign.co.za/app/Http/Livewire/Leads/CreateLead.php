<?php

namespace App\Http\Livewire\Leads;

use App\Jobs\EmailJob;
use App\Models\Activity;
use App\Models\Lead;
use App\Models\Sector;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class CreateLead extends Component
{
    public $lead;
    public $users;
    public $sectors;
    public $selectedUser;

    protected $rules = [
        'lead.company_name' => 'required',
        'lead.website' => 'nullable',
        'lead.sector_id' => 'nullable',

        'lead.assigned_to' => 'required',
        'lead.name' => 'required',
        'lead.first_name' => 'required',
        'lead.last_name' => 'required',
        'lead.primary_phone' => 'required',
        'lead.secondary_phone' => 'nullable',
        'lead.email_address' => 'required',

        'lead.enquiry' => 'nullable',
        'lead.source' => 'nullable',
        'lead.description' => 'nullable',

        'lead.address' => 'required',
        'lead.city' => 'required',
        'lead.province' => 'required',
        'lead.country' => 'required',
    ];

    public function mount()
    {
        $this->lead = Lead::make();
        $this->users = User::all();
        $this->sectors = Sector::all();
    }

    public function render()
    {
        return view('livewire.leads.create-lead')
            ->layoutData([
                'backText' => 'all Leads'
            ]);
    }

    public function createLead()
    {
        $this->validate([
            'lead.name' => 'required|regex:/^[^_^\/^\\\\]*$/',
            // 'lead.first_name' => 'required|regex:/^[^_^\/^\\\\]*$/',
            // 'lead.last_name' => 'required|regex:/^[^_^\/^\\\\]*$/',
            'lead.primary_phone' => 'required',
        ], [
            'lead.name.regex' => 'The first name cannot contain slashes or underscores.', 
            // 'lead.first_name.regex' => 'The first name cannot contain slashes or underscores.', 
            // 'lead.last_name.regex' => 'The last name cannot contain slashes or underscores.', 
        ]);
        
        $this->lead->save();

        $activity = Activity::make();
        $activity->user_id = Auth::id();
        $activity->title = ' created a lead named <span class="font-bold">' . $this->lead->name . '</span>';
        $activity->body = '';
        $activity->path = 'Leads / ' . $this->lead->name;
        $activity->activity_type = 'creation';
        $this->lead->activities()->save($activity);

        $currentUser = Auth::user();

        $recipients = [
            env('B4B_OPS_EMAIL'),
            'ops@bee4business.co.za',
            'reg@bee4business.co.za',
            'raginie@bee4business.co.za',
            'jerain@bee4business.co.za',
            'xiiphoid@gmail.com'
        ];

        // Send multiple emails
        $currentUser = Auth::user();
        $subject = $currentUser->name . ' has created a new lead';
        $message = 'A new lead named ' . $this->lead->name . ' has been created by ' . $currentUser->name;
        $url = env('APP_URL') . '/leads/' . $this->lead->id;


        foreach ($recipients as $recipient) {
            dispatch(new EmailJob(
                $recipient,
                null,
                $currentUser->name,
                $subject,
                $message,
                $url
            ));
        }
        // dispatch(
        //     new EmailJob(
        //         env('B4B_OPS_EMAIL'),
        //         null,
        //         $currentUser->name,
        //         $currentUser->name . ' has created a new lead',
        //         'A new lead named ' . $this->lead->name . ' has been created by ' . $currentUser->name,
        //         env('APP_URL') . '/leads/' . $this->lead->id
        //     )
        // );

        session()->flash('message', 'Lead created successfully');
        return redirect()->to("/leads/{$this->lead->id}");
    }
}
