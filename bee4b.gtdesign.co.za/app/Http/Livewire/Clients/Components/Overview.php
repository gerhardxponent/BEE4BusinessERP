<?php

namespace App\Http\Livewire\Clients\Components;

use App\Models\AuditProgress;
use App\Models\BeeLevel;
use App\Models\Clients;
use App\Models\EngagementType;
use App\Models\File;
use App\Models\Month;
use App\Models\RatingAgency;
use App\Models\Region;
use App\Models\ReportStatus;
use App\Models\Sector;
use App\Models\Size;
use App\Models\State;
use App\Models\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Spatie\Permission\Models\Role;
use Throwable;

class Overview extends Component
{
    use AuthorizesRequests;

    protected $listeners = [ 
        'refreshOverview' => '$refresh',
        'editDetails', 
        'saveClientDetails',
        'tab_changed',
        'certUploaded'
    ];

    public Clients $client;
    public Clients $clientBackup;
    public $primaryContact;
    public $editing = false;
    public $showCreateDropDownItemModal = false;
    public $dropDownModelName = '';
    public $newDropDownItemName = '';
    public $current_cert;
    public $cert_original_name = '';
    public $users;

    public $user;
    public $showCreateUserModal = false;
    public $newUserRole = '';
    public $managerSelect;
    public $analystSelect;

    public $isReplacing = false;
    public $newCertificate;

    protected $rules = [
        'client.name' => 'required',
        'client.email' => 'required',
        'client.phone' => 'required',
        'client.address' => 'required',
        'client.city' => 'required',
        'client.province' => 'required',
        'client.postal_code' => 'nullable',
        'client.country' => 'required',
        'client.onedrive_folder' => 'required',
        'client.size' => 'required',
        'client.sector' => 'required',
        'client.region' => 'required',
        'client.manager' => 'required',
        'client.analyst' => 'required',
        'client.state' => 'required',
        'client.fye' => 'required',
        // 'client.deadline' => 'required',
        'client.next_report_required' => 'required',
        'client.next_audit' => 'required',
        'client.engagement_type' => 'required',

        'client.engagement_type_id' => 'required',
        'client.report_status_id' => 'required',
        'client.rating_agency_id' => 'required',
        'client.bee_level_id' => 'required',
        // 'client.planned_audit_date' => 'required',
        'client.planned_audit_month_id' => 'nullable',
        'client.date_cert_issued' => 'required',
        'client.current_certificate_expiry' => 'required',
        'client.date_engaged' => 'required',
        'client.report_notes' => 'nullable',

        'client.vat_number' => 'nullable',
        'client.registration_number' => 'nullable',

        'current_cert.file_name' => 'required',
        'current_cert.expiry_date' => 'required',
        'current_cert.reviewer_comments' => 'required',

        'user.name' => 'required|min:2',
        'user.email' => 'required|email',
        'user.password' => 'required|min:4',
    ];

    protected function clientDetailsRules()
    {
        return [
            'client.name' => 'required|regex:/^[^_^\/^\\\\]*$/|unique:clients,name,' . $this->client->id,
            'client.email' => 'required',
            'client.phone' => 'required',
            'client.address' => 'nullable',
            'client.city' => 'nullable',
            'client.province' => 'nullable',
            'client.postal_code' => 'nullable',
            'client.country' => 'nullable',
            // 'client.engagement_type' => 'required',

            'client.size' => 'nullable',
            'client.sector' => 'nullable',
            'client.region' => 'nullable',
            'client.state' => 'nullable',

            'client.engagement_type_id' => 'nullable',
            'client.report_status_id' => 'nullable',
            'client.rating_agency_id' => 'nullable',
            'client.bee_level_id' => 'nullable',
            'client.planned_audit_date' => 'nullable',
            'client.planned_audit_month_id' => 'nullable',
            'client.date_cert_issued' => 'nullable',
            'client.current_certificate_expiry' => 'nullable',
            'client.date_engaged' => 'nullable',

            'client.fye' => 'nullable',
            // 'client.deadline' => 'nullable',
            'client.next_report_required' => 'nullable',
            'client.next_audit' => 'nullable',
        ];
    }

    public function mount($clientID)
    {
        // try{
        //     $test = app()->make('App\Models\Clients');
        //     dd($test);
        // }catch(Throwable $e) {
        //     dd('error');
        // }

        $this->users = User::select('id', 'name')->get()->map(function($user) {
            return [
                'key' => $user->name,
                'value' => $user->name,
                'id' => $user->id
            ];
        });

        $this->client = Clients::find($clientID);

        $this->clientBackup = $this->client;
        $this->primaryContact = $this->client->contactsMorph->first();
        if($this->client->certificate_erp_key) {
            $this->current_cert = File::find($this->client->certificate_erp_key);
            $this->cert_original_name = $this->current_cert->file_name;
        }
    }

    public function render()
    {
        return view('livewire.clients.components.overview');
    }

    public function tab_changed()
    {
        $this->editing = false;
    }

    // Computed Properties
    public function getSizesProperty()    { return Size::all()->sortBy('position'); }
    public function getSectorsProperty()  { return Sector::all()->sortBy('position'); }
    public function getRegionsProperty()  { return Region::all()->sortBy('position'); }
    public function getStatesProperty()   { return State::all()->sortBy('position'); }
    public function getEngagementTypesProperty()   { return EngagementType::all()->sortBy('position'); }
    public function getReportStatusesProperty()   { return ReportStatus::all()->sortBy('position'); }
    public function getRatingAgenciesProperty()   { return RatingAgency::all()->sortBy('position'); }
    public function getBeeLevelsProperty()   { return BeeLevel::all()->sortBy('position'); }
    public function getAuditProgressesProperty()   { return AuditProgress::all()->sortBy('position'); }

    public function getManagersProperty() { return User::role('Manager')->get(); }
    public function getAnalystsProperty() { return User::role('Analyst')->get(); }
    public function getAllUsersProperty() { return User::all(); }
    public function getMonthsProperty() { return Month::all(); }
    // End computed properties

    //gets manager/analyst initials
    protected function generateInitials($name)
    {
        $words = explode(" ", $name);
        $initials = null;
        foreach ($words as $w) {
            $initials .= $w[0];
        }
        return $initials;
    }

    public function editDetails()
    {
        if($this->editing) {
            $this->client = $this->clientBackup;
        }

        $this->editing = !$this->editing;
    }

    public function certUploaded()
    {
        if($this->client->certificate_erp_key) {
            $this->current_cert = File::find($this->client->certificate_erp_key);
        }
        $this->emit('refreshOverview');
    }

    public function saveClientDetails()
    {
        $this->validate($this->clientDetailsRules());

        try {
            if($this->client->certificate_erp_key != null) {
                //if file name changed
                if($this->current_cert->file_name != $this->cert_original_name) {
                    //rename
                    Storage::move(
                        $this->current_cert->file_path . '/' . $this->cert_original_name . '.' . $this->current_cert->type, 
                        $this->current_cert->file_path . '/' . $this->current_cert->file_name . '.' . $this->current_cert->type
                    );
                }

                $this->current_cert->save();
                $this->editing = false;
            }
        } catch(Throwable $e) {
            session()->flash('error_flash', 'File error');
        }

        try {
            $this->client->save();
            // session()->flash('message', 'Changes saved successfully!');
            $this->editing = false;
        } catch(Throwable $e) {
            session()->flash('error_flash', 'Client update error');
        }
        
        $this->emit('changesSaved');
        //REMOVE
        $this->emitSelf('refreshOverview');
        //-----------
        $this->emit('successFlash', 'Changes saved successfully!');
        $this->emit('newActivity', 'has updated ' . $this->client->name . ' (Client)', '', 'update');
    }

    //modal to create new dropdown items
    public function showDropDownModal($dropdown)
    {
        $this->dropDownModelName = $dropdown;
        $this->showCreateDropDownItemModal = true;
    }

    //for creating new dropdown item
    public function newDropDownItem()
    {
        $item = ('App\\Models\\' . $this->dropDownModelName)::create([
            'name' => $this->newDropDownItemName,
        ]);

        $this->showCreateDropDownItemModal = false;

        $this->emit('updateData', [
            'id' => $item->id,
            'text' => $item->name,
            'elementName' => 'client-' . $this->dropDownModelName . '-select2',
        ]);

        session()->flash('message', 'New ' . substr_replace($this->dropDownModelName, "", -1) . ' created successfully!');
        $this->newDropDownItemName = '';
    }

    public function downloadCertificate()
    {
        return Storage::download($this->current_cert->file_path . '/' . $this->current_cert->file_name . '.' . $this->current_cert->type);
    }

    public function contactRedirect($id) { return redirect()->to('/contacts/' . $id); }

    public function showUserModal($title)
    {
        $this->authorize('create users');
        $this->newUserRole = $title;
        $this->showCreateUserModal = true;
    }

    // For creating new Manager/Analyst
    public function createNewUser()
    {
        $this->authorize('create users');
        $this->validate([
            'user.name' => 'required',
            'user.email' => 'required|email',
            'user.password' => 'required'
        ]);

        // dd($this->user);
        $newUser = User::make([
            'name' => $this->user['name'],
            'email' => $this->user['email'],
            'password' => bcrypt($this->user['password'])
        ]);

        $newUser->save();

        $newUser->assignRole(Role::where('name', $this->newUserRole)->first());
        $this->user = [];
        $this->showCreateUserModal = false;
        $this->emit('successFlash', 'New ' . lcfirst($this->newUserRole) . ' created!');
    }
    
    public function setUser($key)
    {
        if($key == 'm' && $this->managerSelect != '') {
            $this->client->manager = $this->managerSelect;
            // $this->newActivity(
            //     'updated the manager for ' . $this->client->name, 
            //     User::find($this->managerSelect)->name . ' is the new manager', 
            //     'update'
            // );
        }
        else if($key == 'a' && $this->analystSelect != '') {
            $this->client->analyst = $this->analystSelect;
            // $this->newActivity(
            //     'updated the analyst for ' . $this->client->name, 
            //     User::find($this->analystSelect)->name . ' is the new analyst', 
            //     'update'
            // );
        }
        else 
            return;

        $this->client->save();
        session()->flash('message', 'Changes saved successfully!');
    }

    public function changeDirName()
    {
        Storage::rename('uploads/Tesla_Motors/', 'uploads/New_name');
    }
}
