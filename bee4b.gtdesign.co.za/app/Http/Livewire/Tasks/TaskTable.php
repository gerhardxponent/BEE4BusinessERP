<?php

namespace App\Http\Livewire\Tasks;

use App\Models\BoardItem;
use Illuminate\Support\Carbon;
use Illuminate\Database\QueryException;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use PowerComponents\LivewirePowerGrid\Button;
use PowerComponents\LivewirePowerGrid\Column;
use PowerComponents\LivewirePowerGrid\PowerGrid;
use PowerComponents\LivewirePowerGrid\PowerGridEloquent;
use PowerComponents\LivewirePowerGrid\PowerGridComponent;
use PowerComponents\LivewirePowerGrid\Traits\ActionButton;
use PowerComponents\LivewirePowerGrid\Rules\Rule;
use App\Models\Phase;
use App\Models\Priority;
use \Illuminate\Support\Collection;

final class TaskTable extends PowerGridComponent
{
    use ActionButton;

    public $viewAllTasks = false;
    public $filterUserId = null;  // null|int|'all'
    public $dueStart     = null;  // 'YYYY-MM-DD' or null
    public $dueEnd       = null;  // 'YYYY-MM-DD' or null

    public string $sortField = 'board_items.name';

    protected function getListeners(): array
    {
        return array_merge(
            parent::getListeners(), 
            [
                'toggleViewAll',
                'toggleViewAll',
                'externalFiltersChanged'
            ]);
    }

    public function toggleViewAll()
    {
        $this->viewAllTasks = !$this->viewAllTasks;
    }

    //Messages informing success/error data is updated.
    public bool $showUpdateMessages = true;

    public string $tableName = 'task-table';

    /*
    |--------------------------------------------------------------------------
    |  Features Setup
    |--------------------------------------------------------------------------
    | Setup Table's general features
    |
    */
    public function setUp(): void
    {
        $this->showPerPage()
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
    * @return  \Illuminate\Database\Eloquent\Builder<\App\Models\BoardItem>|null
    */
    public function datasource(): ?Builder
    {
        $q = BoardItem::query()
            ->whereHas('users', function($q) {
                // If specific user selected -> constrain to that user
                if (is_numeric($this->filterUserId)) {
                    $q->where('id', (int)$this->filterUserId);
                } else {
                    // If "all" chosen but user lacks permission, lock to themselves
                    if ($this->filterUserId !== 'all') {
                        $q->where('id', Auth::id());
                    } else if (!Auth::user()->can('view all tasks')) {
                        $q->where('id', Auth::id());
                    }
                    // else: truly all users
                }
            })
            ->leftJoin('boards', 'board_items.board_id', 'boards.id')
            ->leftJoin('clients', 'boards.client_id', 'clients.id')
            ->leftJoin('phases', 'board_items.phase_id', 'phases.id')
            ->leftJoin('priorities', 'board_items.priority_id', 'priorities.id')
            ->leftJoin('users', 'board_items.responsible_person', 'users.id')
            ->select([
                'boards.name as board_name',
                'board_items.id',
                'board_items.name as item_name',
                'clients.name as client_name',
                'clients.id as client_id',
                'phases.name as phase_name',
                'board_items.deadline as deadline',
                'priorities.name as priority_name',
                'users.name as responsible_person',
                'board_items.status as status',
                'board_items.completed_at as completed_at'
            ]);

        // Due date filtering
        if ($this->dueStart && $this->dueEnd) {
            $q->whereBetween('board_items.deadline', [$this->dueStart, $this->dueEnd]);
        } elseif ($this->dueStart) {
            $q->whereDate('board_items.deadline', '>=', $this->dueStart);
        } elseif ($this->dueEnd) {
            $q->whereDate('board_items.deadline', '<=', $this->dueEnd);
        }

        return $q;
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
            ->addColumn('status', function(BoardItem $model) {
                if($model->status == 'active')
                    return '<div wire:click="$emit(\'changeStatus\', \''.$model->id.'\')" class="cursor-pointer rounded-full ml-4 mr-4 w-6 h-6 bg-green-500 border-2 border-gray-300"></div>';
                else if($model->status == 'inactive')
                    return '<div wire:click="$emit(\'changeStatus\', \''.$model->id.'\')" class="cursor-pointer rounded-full ml-4 mr-4 w-6 h-6 bg-white border-2 border-gray-300"></div>';
                else if($model->status == 'complete')
                    return '<div wire:click="$emit(\'changeStatus\', \''.$model->id.'\')" class="text-white cursor-pointer rounded-full ml-4 mr-4 w-6 h-6 bg-gray-500 border-2 border-gray-300"><svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-check" width="19" height="19" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M5 12l5 5l10 -10"></path></svg></div>';
            })
            ->addColumn('item_name', function(BoardItem $model) {
                if($model->status == 'complete')
                    return '<div class="line-through text-blue-600 hover:underline cursor-pointer" wire:click="$emit(\'taskClicked\', \''.$model->id.'\')">'.$model->item_name.'</div>';
                else
                    return '<div class="text-blue-600 hover:underline cursor-pointer" wire:click="$emit(\'taskClicked\', \''.$model->id.'\')">'.$model->item_name.'</div>';
            })
            ->addColumn('board_name')
            ->addColumn('client_name', function($model) {
                return '<a class="text-blue-600 hover:underline cursor-pointer" href="../../clients/'.$model->client_id.'">'.$model->client_name.'</a>';
            })
            ->addColumn('phase_name')
            ->addColumn('deadline')
            ->addColumn('completed_at')
            ->addColumn('priority_name')
            ->addColumn('responsible_person');
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
                ->field('status', 'board_items.status')
                ->makeInputSelect(BoardItem::select('status')->distinct()->get(), 'status', 'status', ['live-search' => true])
                ->searchable()
                ->sortable(),

            Column::add()
                ->title('TASK NAME')
                ->field('item_name', 'board_items.name')
                ->makeInputText()
                ->searchable()
                ->sortable(),

            Column::add()
                ->title('PHASE')
                ->field('phase_name', 'phases.name')
                ->makeInputMultiSelect(Phase::all(), 'name', 'phases.id')
                ->searchable()
                ->sortable(),

            Column::add()
                ->title('PROJECT NAME')
                ->field('board_name', 'boards.name')
                ->makeInputText()
                ->searchable()
                ->sortable(),

            Column::add()
                ->title('CLIENT NAME')
                ->field('client_name', 'clients.name')
                ->makeInputText()
                ->searchable()
                ->sortable(),

            Column::add()
                ->title('DUE DATE')
                ->field('deadline', 'board_items.deadline')
                ->searchable()
                ->sortable()
                ->makeInputDatePicker('board_items.deadline'),

            Column::add()
                ->title('COMPLETED AT')
                ->field('completed_at', 'board_items.completed_at')
                ->searchable()
                ->sortable()
                ->makeInputDatePicker('board_items.completed_at'),
            
            Column::add()
                ->title('PRIORITY')
                ->field('priority_name', 'priorities.name')
                ->makeInputMultiSelect(Priority::all(), 'name', 'priorities.id')
                ->searchable()
                ->sortable(),

            Column::add()
                ->title('RESPONSIBLE PERSON')
                ->field('responsible_person', 'users.name')
                ->makeInputText()
                ->searchable()
                ->sortable(),
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
     * PowerGrid BoardItem Action Buttons.
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
               ->route('board-item.edit', ['board-item' => 'id']),

           Button::add('destroy')
               ->caption('Delete')
               ->class('bg-red-500 cursor-pointer text-white px-3 py-2 m-1 rounded text-sm')
               ->route('board-item.destroy', ['board-item' => 'id'])
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
     * PowerGrid BoardItem Action Rules.
     *
     * @return array<int, \PowerComponents\LivewirePowerGrid\Rules\RuleActions>
     */

    /*
    public function actionRules(): array
    {
       return [
           
           //Hide button edit for ID 1
            Rule::button('edit')
                ->when(fn($board-item) => $board-item->id === 1)
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
     * PowerGrid BoardItem Update.
     *
     * @param array<string,string> $data
     */

    /*
    public function update(array $data ): bool
    {
       try {
           $updated = BoardItem::query()->findOrFail($data['id'])
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

    
    /** Receive filters from parent */
    public function externalFiltersChanged(array $filters): void
    {
        $this->filterUserId = $filters['user']     ?? $this->filterUserId;
        $this->dueStart     = $filters['dueStart'] ?? $this->dueStart;
        $this->dueEnd       = $filters['dueEnd']   ?? $this->dueEnd;
        // force refresh
        $this->fillData();
    }
}
