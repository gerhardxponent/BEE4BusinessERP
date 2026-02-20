<?php

namespace App\Http\Livewire\Consultations;

use App\Models\Consultation;
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

final class ConsultationsTable extends PowerGridComponent
{
    use ActionButton;

    public string $tableName2 = 'consultationsTable';

    //Messages informing success/error data is updated.
    public bool $showUpdateMessages = true;

    public string $sortField = 'consultations.name';

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
    * @return  \Illuminate\Database\Eloquent\Builder<\App\Models\Consultation>|null
    */
    public function datasource(): ?Builder
    {
        return Consultation::query();
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
            ->addColumn('id')
            ->addColumn('namePlain', function(Consultation $model) {
                return $model->name;
            })
            ->addColumn('name', function(Consultation $model) {
                return '<a class="table-link" href="./consultations/'.$model->id.'">'.$model->name.'</a>';
            })
            ->addColumn('clientName', function(Consultation $model) {
                $client = $model->client();
                if(!isset($model->client_id)){
                    return 'No Client';
                }
                else{
                    if($client->first()!=null){
                        return $client->first()->name;
                    }
                    else{
                        return null;
                    }
                }
            }) 
            ->addColumn('client_id', function(Consultation $model) {
                $client = $model->client();
                if(!isset($model->client_id)){
                    return '';
                }
                else{
                    if($client->first()!=null){
                        return '<a class="table-link" href="./clients/'.$client->first()->id.'">'.$client->first()->name.'</a>';
                    }
                    else{
                        return null;
                    }
                    
                }
            }) 
            ->addColumn('consultationdate_formatted', function(Consultation $model) { 
                return Carbon::parse($model->consultationdate)->format('d/m/Y');
            })
            ->addColumn('starttime_formatted', function(Consultation $model) { 
                return Carbon::parse($model->starttime)->format('d/m/Y H:i:s');
            })
            ->addColumn('endtime_formatted', function(Consultation $model) { 
                return Carbon::parse($model->endtime)->format('d/m/Y H:i:s');
            })
            ->addColumn('created_at_formatted', function(Consultation $model) { 
                return Carbon::parse($model->created_at)->format('d/m/Y H:i:s');
            })
            ->addColumn('updated_at_formatted', function(Consultation $model) { 
                return Carbon::parse($model->updated_at)->format('d/m/Y H:i:s');
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
                ->title('ID')
                ->field('id')
                ->makeInputRange(),

            Column::add()
                ->title('NAME')
                ->field('namePlain')
                ->hidden()
                ->visibleInExport(true),

            Column::add()
                ->title('NAME')
                ->field('name')
                ->sortable()
                ->searchable()
                ->makeInputText()
                ->visibleInExport(false),

            Column::add()
                ->title('CLIENTNAME')
                ->field('clientName')
                ->hidden()
                ->visibleInExport(true),

            Column::add()
                ->title('CLIENTNAME')
                ->field('client_id')
                ->sortable()
                ->searchable()
                ->makeInputText()
                ->visibleInExport(false),

            Column::add()
                ->title('CONSULTATIONDATE')
                ->field('consultationdate_formatted', 'consultationdate')
                ->searchable()
                ->sortable()
                ->makeInputDatePicker('consultationdate'),

            Column::add()
                ->title('STARTTIME')
                ->field('starttime_formatted', 'starttime')
                ->searchable()
                ->sortable()
                ->makeInputDatePicker('starttime'),

            Column::add()
                ->title('ENDTIME')
                ->field('endtime_formatted', 'endtime')
                ->searchable()
                ->sortable()
                ->makeInputDatePicker('endtime'),

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
     * PowerGrid Consultation Action Buttons.
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
               ->route('consultation.edit', ['consultation' => 'id']),

           Button::add('destroy')
               ->caption('Delete')
               ->class('bg-red-500 cursor-pointer text-white px-3 py-2 m-1 rounded text-sm')
               ->route('consultation.destroy', ['consultation' => 'id'])
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
     * PowerGrid Consultation Action Rules.
     *
     * @return array<int, \PowerComponents\LivewirePowerGrid\Rules\RuleActions>
     */

    /*
    public function actionRules(): array
    {
       return [
           
           //Hide button edit for ID 1
            Rule::button('edit')
                ->when(fn($consultation) => $consultation->id === 1)
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
     * PowerGrid Consultation Update.
     *
     * @param array<string,string> $data
     */

    /*
    public function update(array $data ): bool
    {
       try {
           $updated = Consultation::query()->findOrFail($data['id'])
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
