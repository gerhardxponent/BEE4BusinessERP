<?php

namespace App\Http\Livewire\Leads;

use App\Models\Lead;
use App\Models\LeadStatus;
use Illuminate\Support\Carbon;
use Illuminate\Database\QueryException;
use Illuminate\Database\Eloquent\Builder;
use PowerComponents\LivewirePowerGrid\Button;
use PowerComponents\LivewirePowerGrid\Column;
use PowerComponents\LivewirePowerGrid\PowerGrid;
use PowerComponents\LivewirePowerGrid\PowerGridEloquent;
use PowerComponents\LivewirePowerGrid\PowerGridComponent;
use PowerComponents\LivewirePowerGrid\Traits\ActionButton;
use PowerComponents\LivewirePowerGrid\Rules\Rule;

final class LeadsTable extends PowerGridComponent
{
    use ActionButton;

    //Messages informing success/error data is updated.
    public bool $showUpdateMessages = true;

    public string $tableName2 = 'leadsTable';

    public string $sortField = 'leads.first_name';

    public bool $showDeleted = false;

    public bool $archives = true;

    protected function getListeners(): array
    {
        return array_merge(
            parent::getListeners(), 
            [
                'toggleShowDeleted',
            ]
        );
    }

    public function toggleShowDeleted()
    {
        $this->showDeleted = !$this->showDeleted;
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
            ->showPerPage(0)
            ->showSearchInput()
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
    * @return  \Illuminate\Database\Eloquent\Builder<\App\Models\Lead>|null
    */
    public function datasource(): ?Builder
    {
        return Lead::query()->when($this->showDeleted, fn($query) => $query->onlyTrashed());
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

    protected function isExportRequest(): array
    {
        // return request()->query('export') === 'excel';
        return request()->all();
    }

    /*
    |--------------------------------------------------------------------------
    |  Add Column
    |--------------------------------------------------------------------------
    | Make Datasource fields available to be used as columns.
    | You can pass a closure to transform/modify the data.
    |
    */
    // public function addColumns(): ?PowerGridEloquent
    // {


    //     if(isset($this->isExportRequest()['updates'][0]['payload']['method'])){
    //         if($this->isExportRequest()['updates'][0]['payload']['method']==='exportToXLS'){
    //             return PowerGrid::eloquent()
    //                     ->addColumn('id')
    //                     ->addColumn('lead_status', function (Lead $model) {
    //                         switch ($model->lead_status_id) {
    //                             case 1: 
    //                                 return 'Active';
    //                                 break;
    //                             case 2: 
    //                                 return 'Pending';
    //                                 break;
    //                             case 3:
    //                                 return 'Cancelled';
    //                                 break;
    //                             default:
    //                                 return 'Pending';
    //                         }
    //                     })
    //                     ->addColumn('name', function(Lead $model) {
    //                         return $model->name;
    //                     })
    //                     ->addColumn('company_name')
    //                     ->addColumn('contact_number')
    //                     ->addColumn('email_address')
    //                     ->addColumn('enquiry')
    //                     ->addColumn('created_at_formatted', function(Lead $model) { 
    //                         return Carbon::parse($model->created_at)->format('d/m/Y H:i:s');
    //                     })
    //                     ->addColumn('updated_at_formatted', function(Lead $model) { 
    //                         return Carbon::parse($model->updated_at)->format('d/m/Y H:i:s');
    //                     });
    //         }
    //     }
    //     else{
    //         return PowerGrid::eloquent()
    //         ->addColumn('id')
    //         ->addColumn('lead_status', function (Lead $model) {
    //             switch ($model->lead_status_id) {
    //                 case 1: 
    //                     return '<div wire:click="$emit(\'changeLeadStatus\', \''.$model->id.'\')" class="cursor-pointer rounded-full ml-4 mr-4 w-6 h-6 bg-green-500 border-2 border-gray-300"></div>';
    //                     break;
    //                 case 2: 
    //                     return '<div wire:click="$emit(\'changeLeadStatus\', \''.$model->id.'\')" class="cursor-pointer rounded-full ml-4 mr-4 w-6 h-6 bg-amber-500 border-2 border-gray-300"></div>';
    //                     break;
    //                 case 3:
    //                     return '<div wire:click="$emit(\'changeLeadStatus\', \''.$model->id.'\')" class="cursor-pointer rounded-full ml-4 mr-4 w-6 h-6 bg-red-500 border-2 border-gray-300"></div>';
    //                     break;
    //                 default:
    //                     return '<div wire:click="$emit(\'changeLeadStatus\', \''.$model->id.'\')" class="cursor-pointer rounded-full ml-4 mr-4 w-6 h-6 bg-white border-2 border-gray-300"></div>';
    //             }
    //         })
    //         ->addColumn('name', function(Lead $model) {
    //             return !$this->showDeleted ? 
    //                 '<a class="table-link" href="leads/'. $model->id .'">'. $model->name .'</a>' : 
    //                 '<a class="table-link" wire:click="$emit(\'showRestoreModal\','. $model->id .')" >'. $model->name .'</a>';
    //         })
    //         ->addColumn('company_name')
    //         ->addColumn('contact_number')
    //         ->addColumn('email_address')
    //         ->addColumn('enquiry')
    //         ->addColumn('created_at_formatted', function(Lead $model) { 
    //             return Carbon::parse($model->created_at)->format('d/m/Y H:i:s');
    //         })
    //         ->addColumn('updated_at_formatted', function(Lead $model) { 
    //             return Carbon::parse($model->updated_at)->format('d/m/Y H:i:s');
    //         });
    //     }
    // }

    public function addColumns(): ?PowerGridEloquent
    {
        $powerGrid = PowerGrid::eloquent()
            ->addColumn('id')
            ->addColumn('lead_status', function (Lead $model) {
                switch ($model->lead_status_id) {
                    case 1: 
                        return 'Active';
                    case 2: 
                        return 'Pending';
                    case 3:
                        return 'Cancelled';
                    default:
                        return 'Pending';
                }
            })
            ->addColumn('name', function(Lead $model) {
                return $model->name;
            })
            ->addColumn('company_name')
            ->addColumn('contact_number')
            ->addColumn('email_address')
            ->addColumn('enquiry')
            ->addColumn('created_at_formatted', function(Lead $model) { 
                return Carbon::parse($model->created_at)->format('d/m/Y H:i:s');
            })
            ->addColumn('updated_at_formatted', function(Lead $model) { 
                return Carbon::parse($model->updated_at)->format('d/m/Y H:i:s');
            });

        if (isset($this->isExportRequest()['updates'][0]['payload']['method']) && 
            $this->isExportRequest()['updates'][0]['payload']['method'] === 'exportToXLS') {
            
            return $powerGrid;
        }

        return $powerGrid
            ->addColumn('lead_status', function (Lead $model) {
                switch ($model->lead_status_id) {
                    case 1: 
                        return '<div wire:click="$emit(\'changeLeadStatus\', \''.$model->id.'\')" class="cursor-pointer rounded-full ml-4 mr-4 w-6 h-6 bg-green-500 border-2 border-gray-300"></div>';
                    case 2: 
                        return '<div wire:click="$emit(\'changeLeadStatus\', \''.$model->id.'\')" class="cursor-pointer rounded-full ml-4 mr-4 w-6 h-6 bg-amber-500 border-2 border-gray-300"></div>';
                    case 3:
                        return '<div wire:click="$emit(\'changeLeadStatus\', \''.$model->id.'\')" class="cursor-pointer rounded-full ml-4 mr-4 w-6 h-6 bg-red-500 border-2 border-gray-300"></div>';
                    default:
                        return '<div wire:click="$emit(\'changeLeadStatus\', \''.$model->id.'\')" class="cursor-pointer rounded-full ml-4 mr-4 w-6 h-6 bg-white border-2 border-gray-300"></div>';
                }
            })
            ->addColumn('name', function(Lead $model) {
                return !$this->showDeleted ? 
                    '<a class="table-link" href="leads/'. $model->id .'">'. $model->name .'</a>' : 
                    '<a class="table-link" wire:click="$emit(\'showRestoreModal\','. $model->id .')" >'. $model->name .'</a>';
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
     * @return array<int, Column>
     */
    public function columns(): array
    {
        return [
            Column::add()
                ->title('STATUS')
                ->field('lead_status', 'lead_status_id')
                ->makeInputSelect(LeadStatus::all(), 'name', 'lead_status_id', ['live-search' => true])
                ->searchable()
                ->sortable(),

            // Column::add()
            //     ->title('ID')
            //     ->field('id')
            //     ->makeInputRange(),

            Column::add()
                ->title('NAME')
                ->field('name')
                ->sortable()
                ->searchable()
                ->makeInputText(),

            Column::add()
                ->title('COMPANY NAME')
                ->field('company_name')
                ->sortable()
                ->searchable()
                ->makeInputText(),

            Column::add()
                ->title('CONTACT NUMBER')
                ->field('contact_number')
                ->sortable()
                ->searchable()
                ->makeInputText(),

            Column::add()
                ->title('EMAIL ADDRESS')
                ->field('email_address')
                ->sortable()
                ->searchable()
                ->makeInputText(),

            Column::add()
                ->title('ENQUIRY')
                ->field('enquiry')
                ->sortable()
                ->searchable()
                ->makeInputText(),

            Column::add()
                ->title('CREATED AT')
                ->field('created_at_formatted', 'created_at')
                ->searchable()
                ->sortable()
                ->makeInputDatePicker('created_at'),

            Column::add()
                ->title('UPDATED AT')
                ->field('updated_at_formatted', 'updated_at')
                ->searchable()
                ->sortable()
                ->makeInputDatePicker('updated_at'),

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
     * PowerGrid Lead Action Buttons.
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
               ->route('lead.edit', ['lead' => 'id']),

           Button::add('destroy')
               ->caption('Delete')
               ->class('bg-red-500 cursor-pointer text-white px-3 py-2 m-1 rounded text-sm')
               ->route('lead.destroy', ['lead' => 'id'])
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
     * PowerGrid Lead Action Rules.
     *
     * @return array<int, \PowerComponents\LivewirePowerGrid\Rules\RuleActions>
     */

    /*
    public function actionRules(): array
    {
       return [
           
           //Hide button edit for ID 1
            Rule::button('edit')
                ->when(fn($lead) => $lead->id === 1)
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
     * PowerGrid Lead Update.
     *
     * @param array<string,string> $data
     */

    /*
    public function update(array $data ): bool
    {
       try {
           $updated = Lead::query()->findOrFail($data['id'])
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
    */
}
