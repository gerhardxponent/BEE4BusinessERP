<?php

namespace App\Http\Livewire\AuditManagement\Components;

use App\Models\Audit;
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

final class AuditTable extends PowerGridComponent
{
    use ActionButton;

    //Messages informing success/error data is updated.
    public bool $showUpdateMessages = true;

    public string $tableName2 = 'auditsTable';

    public bool $showDeleted = false;

    public string $sortField = 'audits.name';

    protected function getListeners(): array
    {
        return array_merge(
            parent::getListeners(), 
            [
                'toggleShowDeleted'
            ]);
    }

    public function toggleShowDeleted()
    {
        $this->showDeleted = !$this->showDeleted;
        $this->emit('pg:eventRefresh-auditsTable');
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
    * @return  \Illuminate\Database\Eloquent\Builder<\App\Models\Audit>|null
    */
    public function datasource(): ?\Illuminate\Database\Eloquent\Builder
{
    $user = auth()->user();

    return \App\Models\Audit::query()
        // Visibility rules
        ->when(!$user->hasPermissionTo('view all projects'), function ($q) use ($user) {

            // Clients / Client Sub Users → restrict by CSV client_id
            if ($user->hasAnyRole(['Client', 'Client Sub User'])) {
                $ids = collect(explode(',', (string) $user->client_id))
                    ->map(fn($v) => (int) trim($v))
                    ->filter()
                    ->values()
                    ->all();

                // if they have no linked companies, show nothing
                return $q->when(count($ids) > 0, fn($qq) => $qq->whereIn('audits.client_id', $ids),
                                         fn($qq) => $qq->whereRaw('1=0'));
            }

            // Analyst / Junior Analyst → only audits with files assigned to them
            if ($user->hasAnyRole(['Analyst', 'Jnr Analyst'])) {
                return $q->whereExists(function ($sub) use ($user) {
                    $sub->from('audit_files')
                        ->whereColumn('audit_files.audit_id', 'audits.id')
                        ->where('audit_files.responsible_person_id', $user->id);
                });
            }

            // Other roles without the permission → (no additional filter)
            return $q;
        })

        // Soft-deleted toggle
        ->when($this->showDeleted, fn($q) => $q->onlyTrashed())

        // Joins for display
        ->leftJoin('clients', 'audits.client_id', '=', 'clients.id')
        ->leftJoin('rating_agencies', 'clients.rating_agency_id', '=', 'rating_agencies.id')

        // Selects expected by the table
        ->select([
            'audits.id as id',
            'audits.name as audit_name',
            'clients.name as client_name',
            'clients.fye as financial_year_end',
            'rating_agencies.name as rating_agency_name',
            'clients.planned_audit_date as planned_audit_date',
            'audits.created_at as audit_created_at',
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
            ->addColumn('id')
            ->addColumn('audit_name', function (Audit $model) {
                $url = $this->showDeleted 
                    ? 'javascript:void(0)' 
                    : url('audits', ['audit' => $model->id]);

                $attributes = $this->showDeleted 
                    ? 'wire:click="$emit(\'toggleRestoreModal\', \'Audit\', ' . $model->id . ', \'auditsTable\')"'
                    : '';

                return '<a class="table-link" href="' . $url . '" ' . $attributes . '>' . $model->audit_name . '</a>';
            })
            ->addColumn('client_name')
            ->addColumn('rating_agency_name') // ✅ New: Show Rating Agency Name
            ->addColumn('planned_audit_date', function (Audit $model) {
                return Carbon::parse($model->planned_audit_date)->format('d/m/Y'); // ✅ Formatting
            })
            ->addColumn('financial_year_end', function (Audit $model) {
                return Carbon::parse($model->financial_year_end)->format('d/m/Y'); // ✅ Formatting FYE
            }) 
            ->addColumn('audit_created_at')
            ->addColumn('audit_created_at_formatted', function (Audit $model) {
                return Carbon::parse($model->audit_created_at)->format('d/m/Y H:i:s');
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
                ->searchable()
                ->sortable(),

            Column::add()
                ->title('NAME')
                ->field('audit_name')
                ->searchable()
                ->makeInputText('audits.name')
                ->sortable(),

            Column::add()
                ->title('CLIENT')
                ->field('client_name')
                ->searchable()
                ->makeInputText('clients.name')
                ->sortable(),

            Column::add()
                ->title('RATING AGENCY') // ✅ Updated title
                ->field('rating_agency_name') // ✅ Display Rating Agency Name
                ->searchable()
                ->makeInputText('rating_agencies.name') // ✅ Allow searching by name
                ->sortable(),

            Column::add()
                ->title('PLANNED AUDIT DATE (FROM CLIENT TAB)') // ✅ Existing column
                ->field('planned_audit_date')
                ->makeInputDatePicker('clients.planned_audit_date') // ✅ Date Picker for filtering
                ->searchable()
                ->sortable(),

            Column::add()
                ->title('FINANCIAL YEAR END') // ✅ NEW COLUMN
                ->field('financial_year_end')
                ->makeInputDatePicker('clients.fye') // ✅ Allow filtering by date
                ->searchable()
                ->sortable(),

            Column::add()
                ->title('Created at')
                ->field('audit_created_at')
                ->hidden(),

            Column::add()
                ->title('Created at')
                ->field('audit_created_at_formatted')
                ->makeInputDatePicker('audits.created_at') // Explicitly qualify the table name
                ->searchable()
        ];
    }


    /*
    |--------------------------------------------------------------------------
    | Actions Method
    |--------------------------------------------------------------------------
    | Enable the method below only if the Routes below are defined in your app.
    |
    */

     /**
     * PowerGrid Audit Action Buttons.
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
               ->route('audit.edit', ['audit' => 'id']),

           Button::add('destroy')
               ->caption('Delete')
               ->class('bg-red-500 cursor-pointer text-white px-3 py-2 m-1 rounded text-sm')
               ->route('audit.destroy', ['audit' => 'id'])
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
     * PowerGrid Audit Action Rules.
     *
     * @return array<int, \PowerComponents\LivewirePowerGrid\Rules\RuleActions>
     */

    /*
    public function actionRules(): array
    {
       return [
           
           //Hide button edit for ID 1
            Rule::button('edit')
                ->when(fn($audit) => $audit->id === 1)
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
     * PowerGrid Audit Update.
     *
     * @param array<string,string> $data
     */

    /*
    public function update(array $data ): bool
    {
       try {
           $updated = Audit::query()
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
