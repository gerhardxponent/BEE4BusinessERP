<?php

namespace App\Http\Livewire\Clients;

use App\Models\BeeLevel;
use Livewire\Component;
use App\Models\Clients;
use App\Models\EngagementType;
use App\Models\RatingAgency;
use App\Models\Region;
use App\Models\ReportStatus;
use App\Models\Sector;
use App\Models\Size;
use App\Models\State;
use App\Models\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class CreateClient extends Component
{
    use AuthorizesRequests;

    public Clients $client;

    public $dropDownTableName;
    public $dropDownClass;
    public $newDropDownItemModal = false;
    public $newDropDownItemName;

    protected function rules()
    {
        return [
            'client.name' => 'required|regex:/^[^_^\/^\\\\]*$/|unique:clients,name,' . $this->client->id,
            'client.email' => 'required|email',
            'client.phone' => 'required',
            'client.address' => 'required',
            'client.city' => 'required',
            'client.province' => 'required',
            'client.postal_code' => 'required',
            'client.country' => 'required',
            'client.engagement_type' => 'required',

            'client.size' => 'nullable',
            'client.sector' => 'nullable',
            'client.region' => 'nullable',
            'client.state' => 'nullable',

            'client.engagement_type_id' => 'nullable',
            'client.report_status_id' => 'nullable',
            'client.rating_agency_id' => 'nullable',
            'client.bee_level_id' => 'nullable',
            
            'client.vat_number' => 'nullable',
            'client.registration_number' => 'nullable',

            'client.planned_audit_date' => 'nullable',
            'client.date_cert_issued' => 'nullable',
            'client.current_certificate_expiry' => 'nullable',
            'client.date_engaged' => 'nullable',

            'client.fye' => 'nullable',
            // 'client.deadline' => 'nullable',
            'client.next_report_required' => 'nullable',
            'client.next_audit' => 'nullable',
        ];
    }

    protected function messages()
    {
        return [
            'client.name.regex' => 'The name cannot contain slashes or underscores.',
            'client.engagement_type.required' => 'The engagement type field is required',
        ];
    }

    public $breadcrumbs = [];

    public function mount()
    {
        $this->client = Clients::make();
        $this->breadcrumbs = ['Clients', 'Create Client'];
    }

    public function render()
    {
        return view('livewire.clients.create-client')
            ->layoutData([
                'backText' => 'all Clients'
            ]);
    }

    public function getSizesProperty()    { return Size::all(); }
    public function getSectorsProperty()  { return Sector::all(); }
    public function getRegionsProperty()  { return Region::all(); }
    public function getStatesProperty()   { return State::all(); }
    public function getManagersProperty() { return User::role('Manager')->get(); }
    public function getAnalystsProperty() { return User::role('Analyst')->get(); }

    public function getEngagementTypesProperty()   { return EngagementType::all(); }
    public function getReportStatusesProperty()   { return ReportStatus::all(); }
    public function getRatingAgenciesProperty()   { return RatingAgency::all(); }
    public function getBeeLevelsProperty()   { return BeeLevel::all(); }
    // public function getAllUsersProperty() { return User::all(); }

    //modal to create new dropdown items
    public function showDropDownModal($dropdown)
    {
        // $this->dropDownTableName = $dropdown;
        $this->dropDownClass = $dropdown;
        $this->newDropDownItemModal = true;
    }

    public function cancelDropdownItem()
    {
        $this->newDropDownItemModal = false;
        $this->newDropDownItemName = '';
        $this->resetErrorBag();
    }

    //for creating new dropdown item
    public function newDropDownItem()
    {
        $tableName = ('\\App\\Models\\' . $this->dropDownClass)::make()->getTable();

        $this->validate([
            'newDropDownItemName' => 'required|unique:' . $tableName . ',name'
        ], [
            'newDropDownItemName.required' => 'Please enter ' . strtolower($this->dropDownClass) . ' name',
            'newDropDownItemName.unique' => 'The following ' . strtolower($this->dropDownClass) . ' already exists',
        ]);

        $newItem = ('\\App\\Models\\' . $this->dropDownClass)::create([
            'name' => $this->newDropDownItemName,
        ]);

        $fieldName = strtolower($this->dropDownClass);

        $this->client->$fieldName = $newItem->id;

        $this->emit('updateData', [
            'id' => $newItem->id,
            'text' => $newItem->name,
            'elementName' => 'client-'. $this->dropDownClass .'-select2',
        ]);

        $this->newDropDownItemModal = false;
        $this->dispatchBrowserEvent('notify-success', ['message' => 'New ' . $this->dropDownClass . ' created successfully']);
        $this->newDropDownItemName = '';
    }

    public function submit()
    {
        $this->authorize('create clients');

        $this->client->fye = $this->client->fye === '' ? null : $this->client->fye;
        // $this->client->deadline = $this->client->deadline === '' ? null : $this->client->deadline;
        $this->client->next_report_required = $this->client->next_report_required === '' ? null : $this->client->next_report_required;
        $this->client->next_audit = $this->client->next_audit === '' ? null : $this->client->next_audit;

        $this->validate();
        $this->client->save();
        session()->flash('created_client', 'Client successfully created!');
        return redirect()->to('/clients');
    }
}
