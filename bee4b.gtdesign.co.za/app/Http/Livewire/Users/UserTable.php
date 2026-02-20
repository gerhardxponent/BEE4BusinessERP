<?php

namespace App\Http\Livewire\Users;

use App\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\Database\QueryException;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use PowerComponents\LivewirePowerGrid\Button;
use PowerComponents\LivewirePowerGrid\Column;
use PowerComponents\LivewirePowerGrid\PowerGrid;
use PowerComponents\LivewirePowerGrid\Rules\Rule;
use PowerComponents\LivewirePowerGrid\PowerGridEloquent;
use PowerComponents\LivewirePowerGrid\PowerGridComponent;
use PowerComponents\LivewirePowerGrid\Traits\ActionButton;
use Spatie\Permission\Models\Role;

final class UserTable extends PowerGridComponent
{
    use ActionButton;

    //Messages informing success/error data is updated.
    public bool $showUpdateMessages = true;

    public string $primaryKey = 'users.id';

    public $showDeletedOnly = false;

    public string $sortField = 'users.id';
    public string $sortDirection = 'asc';


    protected $listeners = [
        'toggleShowDeletedOnly' => 'toggleShowDeletedOnly',
        'restoreUser' => 'restoreUser',
    ];

    public function toggleShowDeletedOnly(): void
    {
        $this->showDeletedOnly = !$this->showDeletedOnly;

        // reset pagination to page 1
        if (method_exists($this, 'resetPage')) {
            $this->resetPage();
        }

        // ✅ refresh PowerGrid dataset (covers multiple versions)
        if (method_exists($this, 'fillData')) {
            // PG <= 4.0
            $this->fillData();
        }

        // PG refresh events (works with tableName set in setUp())
        $this->emit('pg:eventRefresh');                     // generic
        $this->emit('pg:eventRefresh-UserTable');           // by name
        $this->dispatchBrowserEvent('pg:eventRefresh');     // browser event
        $this->dispatchBrowserEvent('pg:eventRefresh-UserTable');
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
        $this->tableName = 'UserTable';

        // make sure PG never falls back to plain "id"
        $this->sortField     = 'users.id';
        $this->sortDirection = 'asc';

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
     * @return  \Illuminate\Database\Eloquent\Builder<\App\Models\User>|null
     */
    public function datasource(): ?Builder
    {
        return User::query()
            ->when(auth()->user()->client_id, function ($query) {
                $query->where('users.client_id', auth()->user()->client_id);
            })
            // Only show active or deleted, never both
            ->when(!$this->showDeletedOnly, fn ($q) => $q->where('users.enabled', 1))
            ->when($this->showDeletedOnly, fn ($q) => $q->where('users.enabled', 0))

            // No joins, no groupBy — role_names via correlated subquery
            ->select([
                'users.id',
                'users.name',
                'users.email',
                'users.enabled',
                DB::raw("(SELECT GROUP_CONCAT(r.name ORDER BY r.name SEPARATOR ', ')
                        FROM model_has_roles m
                        JOIN roles r ON r.id = m.role_id
                        WHERE m.model_id = users.id) as role_names"),
                DB::raw("CASE WHEN users.enabled = 1 THEN 'Active' ELSE 'Deleted' END AS status_label"),
                'users.created_at',
                'users.updated_at',
            ]);
    }

    public function updatedShowDeletedOnly()
    {
        if (method_exists($this, 'resetPage'))
            $this->resetPage();
        if (method_exists($this, 'fillData'))
            $this->fillData();
        $this->emit('pg:eventRefresh-UserTable');
        $this->dispatchBrowserEvent('pg:eventRefresh-UserTable');
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
            ->addColumn('namePlain', function (User $model) {
                return $model->name;
            })
            ->addColumn('name', function (User $model) {
                return '<a class="table-link" href="users/' . $model->id . '">' . $model->name . '</a>';
            })
            ->addColumn('email')
            // ->addColumn('role_name')
            ->addColumn('role_names', function (User $model) {
                return $model->role_names; // Use concatenated role names
            })
            ->addColumn('enabled', fn(User $model) => (int) $model->enabled)
            ->addColumn('status_label', fn(User $model) => $model->enabled ? 'Active' : 'Deleted')

            ->addColumn('created_at_formatted', function (User $model) {
                return Carbon::parse($model->created_at)->format('d/m/Y H:i:s');
            })
            ->addColumn('updated_at_formatted', function (User $model) {
                return Carbon::parse($model->updated_at)->format('d/m/Y H:i:s');
            });
    }

    public function actions(): array
    {
        return [
            Button::add('restore')
                ->caption('Restore')
                ->class('bg-emerald-600 cursor-pointer text-white px-3 py-2 m-1 rounded text-xs')
                ->emit('restoreUser', ['id' => 'id']),
        ];
    }

    public function actionRules(): array
    {
        return [
            // Hide restore button for active users
            Rule::button('restore')
                ->when(fn($row) => (int) ($row->enabled ?? 1) === 1)
                ->hide(),
        ];
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
                ->field('id', 'users.id')
                ->sortable()
                ->makeInputRange(),

            Column::add()
                ->title('NAME')
                ->field('namePlain', 'users.name')
                ->hidden()
                ->visibleInExport(true),

            Column::add()
                ->title('NAME')
                ->field('name', 'users.name')
                ->sortable()
                ->searchable()
                ->makeInputText()
                ->visibleInExport(false),

            Column::add()
                ->title('EMAIL')
                ->field('email')
                ->sortable()
                ->searchable()
                ->makeInputText(),

            // Column::add()
            //     ->title('ROLE')
            //     ->field('role_name', 'roles.name')
            //     ->sortable()
            //     ->makeInputSelect(Role::all(), 'name', 'roles.id'),

            Column::add()
                ->title('ROLES') // Update the column title to plural
                ->field('role_names', 'roles.name') // Use the concatenated field
                ->sortable()
                ->makeInputSelect(Role::all(), 'name', 'roles.id'),

            Column::add()
                ->title('STATUS')
                ->field('status_label', 'users.enabled')
                ->sortable(),


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

    public function restoreUser($payload): void
    {
        $id = is_array($payload) ? ($payload['id'] ?? null) : $payload;
        if (!$id)
            return;

        $user = User::find($id);
        if (!$user)
            return;

        // Only restore if currently disabled
        if ((int) $user->enabled === 0) {
            $user->enabled = 1;
            $user->save();
            $this->dispatchBrowserEvent('notify', [
                'type' => 'success',
                'message' => "User '{$user->name}' restored.",
            ]);
            // If we're viewing "deleted only", it will auto-disappear from the table after refresh
            $this->fillData();
        }
    }


    /*
    |--------------------------------------------------------------------------
    | Actions Method
    |--------------------------------------------------------------------------
    | Enable the method below only if the Routes below are defined in your app.
    |
    */

    /**
     * PowerGrid User Action Buttons.
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
               ->route('user.edit', ['user' => 'id']),

           Button::add('destroy')
               ->caption('Delete')
               ->class('bg-red-500 cursor-pointer text-white px-3 py-2 m-1 rounded text-sm')
               ->route('user.destroy', ['user' => 'id'])
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
     * PowerGrid User Action Rules.
     *
     * @return array<int, \PowerComponents\LivewirePowerGrid\Rules\RuleActions>
     */

    /*
    public function actionRules(): array
    {
       return [

           //Hide button edit for ID 1
            Rule::button('edit')
                ->when(fn($user) => $user->id === 1)
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
     * PowerGrid User Update.
     *
     * @param array<string,string> $data
     */

    /*
    public function update(array $data ): bool
    {
       try {
           $updated = User::query()->findOrFail($data['id'])
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
