<?php

namespace App\Http\Livewire\Clients;

use App\Models\AuditProgress;
use App\Models\BeeLevel;
use App\Models\Clients;
use App\Models\Contact;
use App\Models\EngagementType;
use App\Models\Month;
use App\Models\RatingAgency;
use App\Models\Region;
use App\Models\ReportStatus;
use App\Models\Sector;
use App\Models\Size;
use App\Models\State;
use App\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\Database\QueryException;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use PowerComponents\LivewirePowerGrid\Column;
use PowerComponents\LivewirePowerGrid\PowerGrid;
use PowerComponents\LivewirePowerGrid\PowerGridEloquent;
use PowerComponents\LivewirePowerGrid\PowerGridComponent;
use PowerComponents\LivewirePowerGrid\Traits\ActionButton;

final class ClientsTable extends PowerGridComponent
{
    use ActionButton;

    public string $tableName2 = 'clientsTable';

    //Messages informing success/error data is updated.
    public bool $showUpdateMessages = true;

    // public string $tableName = 'clientsTable';

    public bool $showDeleted = false;

    public string $sortField = 'clients.name';

    public User $user;

    public bool $archives = true;

    protected function getListeners(): array
    {
        return array_merge(
            parent::getListeners(), 
            [
                'toggleShowDeleted',
                // 'updateValue',
            ]
        );
    }

    // public function updateValue()
    // {
    //     dd('hello');
    // }

    public function toggleShowDeleted()
    {
        $this->showDeleted = !$this->showDeleted;
        $this->emitSelf('pg:eventRefresh-' . $this->tableName);
    }

    /*
    |--------------------------------------------------------------------------
    |  Features Setup
    |--------------------------------------------------------------------------
    | Setup Table's general features
    |
    */
    public function setUp(): void
    {
        $this->user = User::find(Auth::id());

        $this->persist(['columns', 'filters']);

        $this->showCheckBox()
            ->showPerPage(0)
            ->showSearchInput()
            ->showToggleColumns()
            ->showExportOption('download', ['excel', 'csv']);
    }

    /*
    |--------------------------------------------------------------------------
    |  Datasource
    |--------------------------------------------------------------------------
    | Provides data to your Table using a Model or Collection
    |
    */

    /**
    * PowerGrid datasource.
    *
    * @return  \Illuminate\Database\Eloquent\Builder<\App\Models\Clients>|null
    */
    public function datasource(): ?Builder
{
    return Clients::query()
        ->when(!$this->user->hasPermissionTo('view all projects'), function($query) {
            $user = $this->user;

            $query->where(function($query) use ($user) {

                // 1) Clients & Client Sub Users → restrict to CSV list
                if ($user->hasRole('Client') || $user->hasRole('Client Sub User')) {
                    $csv = (string) $user->client_id;
                    $ids = collect(explode(',', $csv))
                        ->map(fn($v) => (int) trim($v))
                        ->filter()      // removes empty / zeros
                        ->values()
                        ->all();

                    if (count($ids)) {
                        $query->whereIn('clients.id', $ids);
                    } else {
                        // No assigned companies → show none
                        $query->whereRaw('1=0');
                    }
                    return; // early exit for client roles
                }

                // 2) Analyst & Jnr Analyst → ONLY clients allocated to them
                if ($user->hasAnyRole(['Analyst', 'Jnr Analyst'])) {
                    $query->where(function($q) use ($user) {
                        $q->where('clients.analyst', $user->id)
                          ->orWhereHas('boardsMorph.analyst', fn($aq) => $aq->where('id', $user->id))
                          ->orWhereHas('boardsMorph.jnrAnalyst', fn($jq) => $jq->where('id', $user->id));
                    });
                    return; // early exit for analyst roles
                }

                // 3) Other roles (e.g. Manager, Admin without "view all projects"):
                //    your original allocated-to-me logic
                $query->whereHas('boardsMorph.consultant', fn($q) => $q->where('id', $user->id))
                      ->orWhereHas('boardsMorph.analyst', fn($q) => $q->where('id', $user->id))
                      ->orWhereHas('boardsMorph.jnrAnalyst', fn($q) => $q->where('id', $user->id))
                      ->orWhere('clients.manager', $user->id)
                      ->orWhere('clients.analyst', $user->id);
            });
        })
        ->when($this->showDeleted, function($query) {
            $query->onlyTrashed();
        })
        ->leftJoin('sizes', 'clients.size', 'sizes.id')
        ->leftJoin('sectors', 'clients.sector', 'sectors.id')
        ->leftJoin('regions', 'clients.region', 'regions.id')
        ->leftJoin('users as u1', 'clients.manager', 'u1.id')
        ->leftJoin('users as u2', 'clients.analyst', 'u2.id')
        ->leftJoin('engagement_types', 'clients.engagement_type_id', 'engagement_types.id')
        ->leftJoin('states', 'clients.state', 'states.id')
        ->leftJoin('bee_levels', 'clients.bee_level_id', 'bee_levels.id')
        ->leftJoin('report_statuses', 'clients.report_status_id', 'report_statuses.id')
        ->leftJoin('audit_progress', 'clients.audit_progress_id', 'audit_progress.id')
        ->leftJoin('rating_agencies', 'clients.rating_agency_id', 'rating_agencies.id')
        ->leftJoin('contacts', 'clients.rating_analyst_id', 'contacts.id')
        ->leftJoin('months as m1', 'clients.fye_id', 'm1.id')
        ->leftJoin('months as m2', 'clients.planned_audit_month_id', 'm2.id')
        ->select([
            DB::raw('MONTH(clients.planned_audit_date)'),
            'clients.id as id',
            'clients.name as client_name',
            'clients.fye as fye',
            'clients.report_notes as report_notes',
            'clients.due_date_report as due_date_report',
            'clients.planned_audit_date as planned_audit_date',
            'clients.date_engaged as date_engaged',
            'clients.next_audit as next_audit',
            'clients.date_cert_issued as date_cert_issued',
            'sizes.id as size_id',
            'sizes.name as size',
            'sectors.name as sector',
            'regions.name as region',
            'u1.name as manager',
            'u2.name as analyst',
            'engagement_types.name as engagement_type_id',
            'states.name as state',
            'bee_levels.name as bee_level_id',
            'clients.current_certificate_expiry as current_certificate_expiry',
            'report_statuses.name as report_status_id',
            'audit_progress.name as audit_progress_id',
            'rating_agencies.name as rating_agency_id',
            'contacts.name as rating_analyst_id',
            'm1.name as fye_id',
            'm2.name as planned_audit_month_id',
        ]);
}




    /*
    |--------------------------------------------------------------------------
    |  Relationship Search
    |--------------------------------------------------------------------------
    | Configure here relationships to be used by the Search and Table Filters.
    |
    */

    /**
     * Relationship search.
     *
     * @return array<string, array<int, string>>
     */
    public function relationSearch(): array
    {
        return [];
    }

    /*
    |--------------------------------------------------------------------------
    |  Add Column
    |--------------------------------------------------------------------------
    | Make Datasource fields available to be used as columns.
    | You can pass a closure to transform/modify the data.
    |
    */
    public function addColumns(): ?PowerGridEloquent
    {
        return PowerGrid::eloquent()
            ->addColumn('rownum')
            ->addColumn('client_name', function(Clients $model) {
                return !$this->showDeleted ? 
                    '<a class="table-link" href="clients/'. $model->id .'">'. $model->client_name .'</a>' : 
                    '<a class="table-link" wire:click="$emit(\'showRestoreModal\','. $model->id .')" >'. $model->client_name .'</a>';
            })
            ->addColumn('client_name_export', fn(Clients $model) => $model->client_name) 
            // ->addColumn('fye', fn(Clients $model) => Carbon::parse($model->fye)->format('M Y'))
            ->addColumn('size')
            ->addColumn('sector')
            ->addColumn('region')
            ->addColumn('manager')
            ->addColumn('analyst')
            ->addColumn('engagement_type_id')
            ->addColumn('state')
            ->addColumn('bee_level_id')
            ->addColumn('current_certificate_expiry')
            ->addColumn('report_status_id')
            ->addColumn('report_notes')
            ->addColumn('due_date_report')
            ->addColumn('audit_progress_id')
            ->addColumn('planned_audit_date', fn(Clients $model) => Carbon::parse($model->planned_audit_date)->format('M Y'))
            ->addColumn('date_engaged')
            ->addColumn('rating_agency_id')
            ->addColumn('rating_analyst_id')
            ->addColumn('next_audit')
            ->addColumn('date_cert_issued')
            ->addColumn('fye_id')
            ->addColumn('planned_audit_month_id')
            // ->addColumn('monthcol', function ($client) {
            //     return 
            // });
            ->addColumn('monthscol', function ($client) {
                return Clients::
                    codes()
                    ->firstWhere(
                        'month', 
                        Carbon::parse($client->planned_audit_date)->month
                    )['label'];
            });
    }

    /*
    |--------------------------------------------------------------------------
    |  Include Columns
    |--------------------------------------------------------------------------
    | Include the columns added columns, making them visible on the Table.
    | Each column can be configured with properties, filters, actions...
    |
    */

     /**
     * PowerGrid Columns.
     *
     * @return array<int, Column>/
     */
    public function columns(): array
    {
        return [
            Column::add()
                ->title('#')
                ->field('rownum')
                ->bodyAttribute('sticky left-0 top-0 bg-white pr-3', 'box-shadow: inset 0px 0.8px 0px 0px #e5e7eb;')
                ->headerAttribute('sticky left-0 pr-3', 'top: -1px; z-index: 999999'),

            Column::add()
                ->title('NAME')
                ->field('client_name')
                ->sortable()
                ->searchable()
                ->visibleInExport(false)
                ->makeInputText('clients.name')
                ->bodyAttribute('sticky top-0 bg-white', 'left: 35px; box-shadow: inset 0px 0.8px 0px 0px #e5e7eb, inset -1px 0px 0px 0px #e5e7eb;')
                ->headerAttribute('sticky', 'left: 35px; top: -1px; z-index: 999999; box-shadow: inset -1px 0px 0px 0px #d1d5db;'),
            
            Column::add()
                ->title('NAME')
                ->field('client_name_export')
                ->visibleInExport(true)
                ->hidden(),

            Column::add()
                ->title('MANAGER')
                ->field('manager')
                ->sortable()
                // ->makeInputText('u1.name')
                ->makeInputMultiSelect(User::role('Administrator')->get(), 'name', 'u1.id')
                ->type('select')
                ->dropdownOptions($this->users->pluck('name', 'id')->toArray())
                ->editOnClick($this->user->hasPermissionTo('edit clients'), 'manager'),

            Column::add()
                ->title('ANALYST')
                ->field('analyst')
                ->sortable()
                // ->makeInputText('u2.name')
                ->makeInputMultiSelect(User::role('Analyst')->get(), 'name', 'u2.id')
                ->editOnClick($this->user->hasPermissionTo('edit clients'), 'analyst')
                ->type('select')
                ->dropdownOptions($this->users->pluck('name', 'id')->toArray()),

            Column::add()
                ->title('FYE')
                ->field('fye_id')
                ->makeInputMultiSelect($this->months, 'name', 'm1.id')
                ->searchable()
                ->sortable()
                ->editOnClick($this->user->hasPermissionTo('edit clients'), 'fye_id')
                ->type('select')
                ->dropdownOptions($this->months->pluck('name', 'id')->toArray()),

            Column::add()
                ->title('REPORT STATUS')
                ->field('report_status_id')
                ->makeInputMultiSelect($this->reportStatuses, 'name', 'report_statuses.id')
                ->searchable()
                ->sortable()
                ->editOnClick($this->user->hasPermissionTo('edit clients'), 'report_status_id')
                ->type('select')
                ->dropdownOptions($this->reportStatuses->pluck('name', 'id')->toArray()),

            Column::add()
                ->title('REPORT NOTES')
                ->field('report_notes')
                ->editOnClick($this->user->hasPermissionTo('edit clients'), 'report_notes')
                ->type('text'),

            Column::add()
                ->title('DUE DATE (REPORT)')
                ->field('due_date_report')
                ->searchable()
                ->sortable()
                ->makeInputDatePicker('due_date_report')
                ->editOnClick($this->user->hasPermissionTo('edit clients'), 'due_date_report')
                ->type('date'),

            Column::add()
                ->title('AUDIT PROGRESS')
                ->field('audit_progress_id', 'audit_progress.name')
                ->makeInputMultiSelect($this->auditProgress, 'name', 'audit_progress.id')
                ->searchable()
                ->sortable()
                ->editOnClick($this->user->hasPermissionTo('edit clients'), 'audit_progress_id')
                ->type('select')
                ->dropdownOptions($this->auditProgress->pluck('name', 'id')->toArray()),

            Column::add()
                ->title('PLANNED AUDIT MONTH')
                ->field('planned_audit_month_id')
                ->makeInputMultiSelect($this->months, 'name', 'm2.id')
                ->searchable()
                ->sortable()
                ->editOnClick($this->user->hasPermissionTo('edit clients'), 'planned_audit_month_id')
                ->type('select')
                ->dropdownOptions($this->months->pluck('name', 'id')->toArray()),

            Column::add()
                ->title('NEXT AUDIT')
                ->field('next_audit')
                ->searchable()
                ->sortable()
                ->makeInputDatePicker('next_audit')
                ->editOnClick($this->user->hasPermissionTo('edit clients'), 'next_audit')
                ->type('date'),
            
            Column::add()
                ->title('DATE ENGAGED')
                ->field('date_engaged')
                ->searchable()
                ->sortable()
                ->makeInputDatePicker('date_engaged')
                ->editOnClick($this->user->hasPermissionTo('edit clients'), 'date_engaged')
                ->type('date'),

            Column::add()
                ->title('RATING AGENCY')
                ->field('rating_agency_id', 'rating_agencies.name')
                ->makeInputMultiSelect($this->ratingAgencies, 'name', 'rating_agencies.id')
                ->searchable()
                ->sortable()
                ->editOnClick($this->user->hasPermissionTo('edit clients'), 'rating_agency_id')
                ->type('select')
                ->dropdownOptions($this->ratingAgencies->pluck('name', 'id')->toArray()),

            Column::add()
                ->title('RATING ANALYST')
                ->field('rating_analyst_id', 'contacts.name')
                ->makeInputMultiSelect($this->contacts, 'name', 'contacts.id')
                ->searchable()
                ->sortable()
                ->editOnClick($this->user->hasPermissionTo('edit clients'), 'rating_analyst_id')
                ->type('select')
                ->dropdownOptions($this->contacts->pluck('name', 'id')->toArray()),

            Column::add()
                ->title('SIZE')
                ->field('size', 'sizes.name')
                ->makeInputMultiSelect($this->sizes, 'name', 'sizes.id')
                ->searchable()
                ->sortable()
                ->editOnClick($this->user->hasPermissionTo('edit clients'), 'size')
                ->type('select')
                ->dropdownOptions($this->sizes->pluck('name', 'id')->toArray()),
            
            Column::add()
                ->title('SECTOR')
                ->field('sector', 'sectors.name')
                ->makeInputMultiSelect($this->sectors, 'name', 'sectors.id')
                ->searchable()
                ->sortable()
                ->editOnClick($this->user->hasPermissionTo('edit clients'), 'sector')
                ->type('select')
                ->dropdownOptions($this->sectors->pluck('name', 'id')->toArray()),

            Column::add()
                ->title('REGION')
                ->field('region', 'regions.name')
                ->makeInputMultiSelect($this->regions, 'name', 'regions.id')
                ->searchable()
                ->sortable()
                ->editOnClick($this->user->hasPermissionTo('edit clients'), 'region')
                ->type('select')
                ->dropdownOptions($this->regions->pluck('name', 'id')->toArray()),

            Column::add()
                ->title('ENGAGEMENT TYPE')
                ->field('engagement_type_id', 'engagement_types.name')
                ->makeInputMultiSelect($this->engagementTypes, 'name', 'engagement_types.id')
                ->searchable()
                ->sortable()
                ->editOnClick($this->user->hasPermissionTo('edit clients'), 'engagement_type_id')
                ->type('select')
                ->dropdownOptions($this->engagementTypes->pluck('name', 'id')->toArray()),

            Column::add()
                ->title('STATUS')
                ->field('state', 'states.name')
                ->makeInputMultiSelect($this->states, 'name', 'states.id')
                ->searchable()
                ->sortable()
                ->editOnClick($this->user->hasPermissionTo('edit clients'), 'state')
                ->type('select')
                ->dropdownOptions($this->states->pluck('name', 'id')->toArray()),

            Column::add()
                ->title('BEE LEVEL')
                ->field('bee_level_id', 'bee_levels.name')
                ->makeInputMultiSelect($this->beeLevels, 'name', 'bee_levels.id')
                ->searchable()
                ->sortable()
                ->editOnClick($this->user->hasPermissionTo('edit clients'), 'bee_level_id')
                ->type('select')
                ->dropdownOptions($this->beeLevels->pluck('name', 'id')->toArray()),

            Column::add()
                ->title('CERTIFICATE ISSUED')
                ->field('date_cert_issued', 'clients.date_cert_issued')
                ->searchable()
                ->sortable()
                ->makeInputDatePicker('clients.date_cert_issued')
                ->editOnClick($this->user->hasPermissionTo('edit clients'), 'date_cert_issued')
                ->type('date'),

            Column::add()
                ->title('CERTIFICATE EXPIRY')
                ->field('current_certificate_expiry', 'clients.current_certificate_expiry')
                ->searchable()
                ->sortable()
                ->makeInputDatePicker('clients.current_certificate_expiry')
                ->editOnClick($this->user->hasPermissionTo('edit clients'), 'current_certificate_expiry')
                ->type('date'),
        ];
    }


    public function getUsersProperty() { return User::all(); }
    public function getSizesProperty() { return Size::all()->sortBy('position'); }
    public function getMonthsproperty() { return Month::all(); }
    public function getStatesProperty() { return State::all()->sortBy('position'); }
    public function getSectorsProperty() { return Sector::all()->sortBy('position'); }
    public function getRegionsProperty() { return Region::all()->sortBy('position'); }
    public function getContactsProperty() { return Contact::all(); } 
    public function getBeeLevelsProperty() { return BeeLevel::all()->sortBy('position'); }
    public function getReportStatusesProperty() { return ReportStatus::all()->sortBy('position'); }
    public function getAuditProgressProperty() { return AuditProgress::all()->sortBy('position'); }
    public function getRatingAgenciesProperty() { return RatingAgency::all()->sortBy('position'); } 
    public function getEngagementTypesProperty() { return EngagementType::all()->sortBy('position'); }

    /*
    |--------------------------------------------------------------------------
    | Actions Method
    |--------------------------------------------------------------------------
    | Enable the method below only if the Routes below are defined in your app.
    |
    */

     /**
     * PowerGrid Clients Action Buttons.
     *
     * @return array<int, \PowerComponents\LivewirePowerGrid\Button>
     */

    /*
    public function actions(): array
    {
       return [
           Button::add('edit')
               ->caption('Edit')
               ->class('bg-indigo-500 cursor-pointer text-white px-3 py-2.5 m-1 rounded text-sm')
               ->route('clients.edit', ['clients' => 'id']),

           Button::add('destroy')
               ->caption('Delete')
               ->class('bg-red-500 cursor-pointer text-white px-3 py-2 m-1 rounded text-sm')
               ->route('clients.destroy', ['clients' => 'id'])
               ->method('delete')
        ];
    }
    */

    /*
    |--------------------------------------------------------------------------
    | Actions Rules
    |--------------------------------------------------------------------------
    | Enable the method below to configure Rules for your Table and Action Buttons.
    |
    */

     /**
     * PowerGrid Clients Action Rules.
     *
     * @return array<int, \PowerComponents\LivewirePowerGrid\Rules\RuleActions>
     */

    /*
    public function actionRules(): array
    {
       return [
           
           //Hide button edit for ID 1
            Rule::button('edit')
                ->when(fn($clients) => $clients->id === 1)
                ->hide(),
        ];
    }
    */

    /*
    |--------------------------------------------------------------------------
    | Edit Method
    |--------------------------------------------------------------------------
    | Enable the method below to use editOnClick() or toggleable() methods.
    | Data must be validated and treated (see "Update Data" in PowerGrid doc).
    |
    */

     /**
     * PowerGrid Clients Update.
     *
     * @param array<string,string> $data
     */

    
    public function update(array $data ): bool
    {
       try {
            // $client = Clients::query()->findOrFail($data['id']);
            
            // $client->{$data['field']} = $data['value'] == '' ? null : $data['value'];
            // $client->save();
            // $updated = true;

            $updated = Clients::query()->withTrashed()->findOrFail($data['id'])
                ->update([
                    $data['field'] => $data['value'],
                ]);
       } catch (QueryException $exception) {
           $updated = false;
       }
       return $updated;
    }

    public function updateMessages(string $status = 'error', string $field = '_default_message'): string
    {
        $updateMessages = [
            'success'   => [
                '_default_message' => __('Data has been updated successfully!'),
                //'custom_field'   => __('Custom Field updated successfully!'),
            ],
            'error' => [
                '_default_message' => __('Error updating the data.'),
                //'custom_field'   => __('Error updating custom field.'),
            ]
        ];

        $message = ($updateMessages[$status][$field] ?? $updateMessages[$status]['_default_message']);

        return (is_string($message)) ? $message : 'Error!';
    }
    
}
