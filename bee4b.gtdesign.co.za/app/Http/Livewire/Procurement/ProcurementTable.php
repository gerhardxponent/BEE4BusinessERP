<?php

namespace App\Http\Livewire\Procurement;

use App\Models\Clients;
use App\Models\ProcurementLog;
use App\Models\ProcurementStatus;
use App\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\Database\QueryException;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use PowerComponents\LivewirePowerGrid\Column;
use PowerComponents\LivewirePowerGrid\PowerGrid;
use PowerComponents\LivewirePowerGrid\PowerGridEloquent;
use PowerComponents\LivewirePowerGrid\PowerGridComponent;
use PowerComponents\LivewirePowerGrid\Traits\ActionButton;

final class ProcurementTable extends PowerGridComponent
{
    use ActionButton;

    //Messages informing success/error data is updated.
    public bool $showUpdateMessages = true;

    public string $sortField = 'created_at';

    public string $sortDirection = 'desc';

    public bool $showDeleted = false;

    public bool $archives = true;

    public bool $bulkActions = true;

    public bool $showConfirmDeleteModal = false;

    protected $queryString = [
        'showDeleted' => ['as' => 'showArchived'],
    ];

    protected function getListeners(): array
    {
        return array_merge(
            parent::getListeners(),
            [
                'toggleShowDeleted',
            ]
        );
    }

    public function bulkArchive()
    {
        ProcurementLog::whereIn('id', $this->checkboxValues)->delete();
        $this->checkboxValues = [];
    }

    public function bulkRestore()
    {
        ProcurementLog::whereIn('id', $this->checkboxValues)->restore();
        $this->checkboxValues = [];
    }

    public function bulkPermanentlyDelete()
    {
        ProcurementLog::whereIn('id', $this->checkboxValues)->forceDelete();
        $this->checkboxValues = [];
        $this->showConfirmDeleteModal = false;
    }

    public function toggleShowDeleted()
    {
        $this->showDeleted = !$this->showDeleted;
        $this->checkboxValues = [];
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
        $this->showCheckBox()
            ->showPerPage()
            ->showSearchInput()
            ->showExportOption('download', ['excel', 'csv']);
    }

    public $clientId;

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
    * @return  \Illuminate\Database\Eloquent\Builder<\App\Models\ProcurementLog>|null
    */
    public function datasource(): ?Builder
    {
        return ProcurementLog::query()
            ->when(!Auth::user()->hasPermissionTo('view all projects'), function ($query) {
                $query->whereHas('client.boardsMorph', function ($query) {
                    $query
                        ->whereHas('consultant', fn($q) => $q->where('id', Auth::id()))
                        ->orWhereHas('analyst', fn($q) => $q->where('id', Auth::id()))
                        ->orWhereHas('jnrAnalyst', fn($q) => $q->where('id', Auth::id()))
                        ->orWhere('manager', Auth::id())
                        ->orWhere('analyst', Auth::id());
                });
            })
            ->with('client')
            ->with('client.getAnalyst')
            ->with('ppAnalyst')
            ->when($this->clientId != null, fn ($query) => $query->where('client_id', $this->clientId))
            ->when($this->showDeleted, fn($query) => $query->onlyTrashed());
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
            ->addColumn('procurement_status', function (ProcurementLog $model) {
                switch ($model->procurement_status_id) {
                    case 1:
                        return '<div wire:click="$emit(\'changeProcurementStatus\', \''.$model->id.'\')" class="cursor-pointer rounded-full ml-4 mr-4 w-6 h-6 bg-white border-2 border-gray-300"></div>';
                        break;
                    case 2:
                        return '<div wire:click="$emit(\'changeProcurementStatus\', \''.$model->id.'\')" class="cursor-pointer rounded-full ml-4 mr-4 w-6 h-6 bg-green-500 border-2 border-gray-300"></div>';
                        break;
                    case 3:
                        return
                            '<div wire:click="$emit(\'changeProcurementStatus\', \''.$model->id.'\')" class="flex justify-center items-center text-white cursor-pointer rounded-full ml-4 mr-4 w-6 h-6 bg-gray-500 border-2 border-gray-300">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-check" width="20" height="20" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                    <path d="M5 12l5 5l10 -10"></path>
                                </svg>
                            </div>';
                        break;
                    default:
                        return '<div wire:click="$emit(\'changeProcurementStatus\', \''.$model->id.'\')" class="cursor-pointer rounded-full ml-4 mr-4 w-6 h-6 bg-white border-2 border-gray-300"></div>';
                }
            })
            ->addColumn('procurement_status_export', function (ProcurementLog $model) {
                switch ($model->procurement_status_id) {
                    case 1:
                        return 'Inactive';
                        break;
                    case 2:
                        return 'Active';
                        break;
                    case 3:
                        return 'Complete';
                        break;
                    default:
                        return 'Inactive';
                }
            })
            ->addColumn('client_name', function (ProcurementLog $model) {
                return $model->client != null ?
                    $model->client->name :
                    '';
            })
            ->addColumn('date_allocated', function(ProcurementLog $model) {
                return $model->date_allocated != null ?
                    Carbon::parse($model->date_allocated)->format('d M Y') :
                    '';
            })
            ->addColumn('pp_analyst', function(ProcurementLog $model) {
                return $model->ppAnalyst()->first() != null ?
                    $model->ppAnalyst()->first()->name :
                    '';
            })
            ->addColumn('fye', function (ProcurementLog $model) {
                return $model->board != null ?
                    $model->board->name :
                    '';
            })
            ->addColumn('due_date')
            ->addColumn('scorecard_number')
            ->addColumn('notes')
            ->addColumn('analyst', function (ProcurementLog $model) {
                // return $this->users->where('id', $model->client->analyst)->first()->name;
                return ($model->board && $model->board->analyst) ?
                    $model->board->analyst->name :
                    '';
            })
            ->addColumn('notes')
            ->addColumn('created_at_formatted', function(ProcurementLog $model) {
                return Carbon::parse($model->created_at)->format('d M Y');
            });
    }

    public function getUsersProperty()
    {
        return User::all();
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
     * @return array<int, Column>
     */
    public function columns(): array
    {
        return [
            Column::add()
                ->title('STATUS')
                ->field('procurement_status', 'procurement_status_id')
                ->makeInputSelect(ProcurementStatus::all(), 'name', 'procurement_status_id', ['live-search' => true])
                ->searchable()
                ->sortable()
                ->visibleInExport(false),

            Column::add()
                ->title('STATUS')
                ->field('procurement_status_export')
                ->visibleInExport(true)
                ->hidden(),

            Column::add()
                ->title('CLIENT')
                ->field('client_name', 'client_id')
                ->sortable()
                ->makeInputSelect(Clients::orderBy('name')->get(), 'name', 'client_id', ['live-search' => true]),

            Column::add()
                ->title('DATE ALLOCATED')
                ->field('date_allocated')
                ->editOnClick(true, 'date_allocated')
                ->type('date')
                ->searchable()
                ->sortable()
                ->makeInputDatePicker('date_allocated'),

            Column::add()
                ->title('ANALYST')
                ->field('analyst'),

            Column::add()
                ->title('PP ANALYST')
                ->field('pp_analyst'),

            Column::add()
                ->title('FYE')
                ->field('fye'),

            Column::add()
                ->title('DUE DATE')
                ->field('due_date')
                ->editOnClick(true, 'due_date')
                ->type('date')
                ->searchable()
                ->sortable()
                ->makeInputDatePicker('due_date'),

            // Column::add()
            //     ->title('scorecard_number')
            //     ->field('scorecard_number')
            //     ->editOnClick(true, 'scorecard_number')
            //     ->type('text'),

            Column::add()
                ->title('SCORECARD NUMBER')
                ->field('scorecard_number')
                ->sortable()
                ->searchable()
                ->makeInputText(),

            Column::add()
                ->title('notes')
                ->field('notes')
                ->editOnClick(true, 'notes')
                ->makeInputText()
                ->searchable()
                ->type('text'),

            Column::add()
                ->title('CREATED AT')
                ->field('created_at_formatted', 'created_at')
                ->searchable()
                ->sortable()
                ->makeInputDatePicker('created_at'),

        ]
;
    }

    /*
    |--------------------------------------------------------------------------
    | Actions Method
    |--------------------------------------------------------------------------
    | Enable the method below only if the Routes below are defined in your app.
    |
    */

     /**
     * PowerGrid ProcurementLog Action Buttons.
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
               ->route('procurement-log.edit', ['procurement-log' => 'id']),

           Button::add('destroy')
               ->caption('Delete')
               ->class('bg-red-500 cursor-pointer text-white px-3 py-2 m-1 rounded text-sm')
               ->route('procurement-log.destroy', ['procurement-log' => 'id'])
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
     * PowerGrid ProcurementLog Action Rules.
     *
     * @return array<int, \PowerComponents\LivewirePowerGrid\Rules\RuleActions>
     */

    /*
    public function actionRules(): array
    {
       return [

           //Hide button edit for ID 1
            Rule::button('edit')
                ->when(fn($procurement-log) => $procurement-log->id === 1)
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
     * PowerGrid ProcurementLog Update.
     *
     * @param array<string,string> $data
     */

    // public function update(array $data ): bool
    // {
    //    try {
    //        $updated = ProcurementLog::query()->findOrFail($data['id'])
    //             ->update([
    //                 $data['field'] => $data['value'],
    //             ]);
    //    } catch (QueryException $exception) {
    //        $updated = false;
    //    }
    //    return $updated;
    // }
    public function update(array $data ): bool
    {
       try {
            
            // dd($data);
           
            $updated = ProcurementLog::query()->withTrashed()->findOrFail($data['id'])
                ->update([
                    $data['field'] => $data['value'],
                ]);
       } catch (QueryException $exception) {
           $updated = false;
       }
       return $updated;
    }

    /*
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
    */
}
