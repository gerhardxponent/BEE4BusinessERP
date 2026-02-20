<?php

namespace App\Http\Livewire\GlobalComponents;

use App\Models\BoardItem;
use App\Models\TaskStatus;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Kanban extends Component
{   
    public $test = false;
    public $statuses;
    // public $type;
    // public $boardId = 113;
    public $viewAllTasks = false;

    public $recordFilter;
    public $typeFilter;
    public $boardFilter;
    public $showTips = true;
    public $sortByDate = false;
    public $filterUserId = null; // null|int|'all'
    public $dueStart = null;     // 'YYYY-MM-DD' or null
    public $dueEnd = null;       // 'YYYY-MM-DD' or null

    protected $query;

    protected $userId;

    protected $listeners = [
        'refreshKanban' => '$refresh',
        'toggleViewAll',
        'changeBoard',
        'update:task-deadline' => 'updateDeadline',
        'externalFiltersChanged' => 'applyFilters',
    ];

    protected $queryString = [
        'typeFilter' => ['as' => 'type'], 
        'recordFilter' => ['as' => 'record'],
        'boardFilter' => ['as' => 'board'],
    ];

    public function mount($query = '', $userId = null, $filterUserId = null, $dueStart = null, $dueEnd = null)
    {
        $this->statuses = TaskStatus::all()->sortBy('position');
        $this->query = $query == '' ? BoardItem::make() : $query;
        $this->userId = $userId;

        // initial filters from parent
        $this->filterUserId = $filterUserId;
        $this->dueStart = $dueStart;
        $this->dueEnd   = $dueEnd;
    }

    public function render()
    {
        return view('livewire.global-components.kanban');
    }

    public function toggleSort()
    {
        $this->sortByDate = !$this->sortByDate;
    }

    public function getTypesProperty()
    {
        return ['Clients', 'ManagementProcess', 'Lead'];
    }

    public function getRecordsProperty()
    {
        if(!$this->typeFilter) {
            return collect([]);
        } else {
            return ('App\Models\\' . $this->typeFilter)::all();
        }
    }

    public function getBoardsProperty()
    {
        if (!$this->recordFilter || !$this->typeFilter) {
            return collect([]);
        } else {
            $record = ('App\Models\\' . $this->typeFilter)::find($this->recordFilter);

            return $record->boards;
        }
    }

    public function changeBoard($board)
    {
        $this->boardFilter = $board;
    }

    public function toggleViewAll()
    {
        $this->viewAllTasks = !$this->viewAllTasks;
    }

    protected $rules = [
        'recordFilter' => 'required',
        'typeFilter' => 'required',
        'boardFilter' => 'required',
    ];

    public function updatedTypeFilter()
    {
        $this->recordFilter = null;
        $this->boardFilter = null;
    }

    public function updatedRecordFilter()
    {
        $this->boardFilter = null;
    }

    public function getTasksProperty()
    {
            return BoardItem::query()
            /** USER filter (overrides viewAllTasks when set) */
            ->when(true, function ($query) {
                $query->whereHas('users', function ($q) {
                    // a) Specific user selected
                    if (is_numeric($this->filterUserId)) {
                        $q->where('id', (int) $this->filterUserId);
                        return;
                   }

                    // b) "all" selected
                    if ($this->filterUserId === 'all') {
                        // if user lacks permission, lock to self
                        if (!Auth::user()->can('view all tasks')) {
                            $q->where('id', Auth::id());
                        }
                        return; // else truly all
                    }

                    // c) No explicit filter -> fall back to toggle
                    if (!$this->viewAllTasks) {
                        $q->where('id', $this->userId ? $this->userId : Auth::id());
                    }
                });
            })
            /** DUE DATE filter */
            ->when($this->dueStart && $this->dueEnd, fn($q) => $q->whereBetween('deadline', [$this->dueStart, $this->dueEnd]))
            ->when($this->dueStart && !$this->dueEnd, fn($q) => $q->whereDate('deadline', '>=', $this->dueStart))
            ->when(!$this->dueStart && $this->dueEnd, fn($q) => $q->whereDate('deadline', '<=', $this->dueEnd))
            ->when($this->typeFilter, function($query) {
                $query->whereHas('board', function($q) {
                    $q->where('boardable_type', ('App\Models\\' . $this->typeFilter));
                });
            })
            ->when($this->recordFilter, function($query) {
                $query->whereHas('board', function($q) {
                    $q->where('boardable_id', $this->recordFilter);
                });
            })
            ->when($this->boardFilter, function($query) {
                $query->where('board_id', $this->boardFilter);
            })
            ->with('board.boardable')
            ->with('tags')
            ->with('tags.colour')
            ->with('assignedUsers')
            ->get();
    }

    public function updateDeadline($value, $model, $id, $field)
    {
        $task = BoardItem::find($id);
        $task->{$field} = $value;
        $task->save();
    }

    /**
     * For updating the order of columns
     */
    // public function updateGroupOrder()
    // {
        
    // }

    public function updateTaskOrder($list)
    {
        $updates = [];

        foreach ($list as $group) {
            foreach ($group['items'] as $item) {
                array_push($updates, [
                    'id' => $item['value'],
                    'status_position' => $item['order'],
                    'status_id' => $group['value'],
                ]);
            }
        }

        DB::table('board_items')->upsert($updates, 'id', ['status_position', 'status_id']);
    }

    public function changeStatus($taskId)
    {
        $task = BoardItem::find($taskId);

        switch($task->status_id) {
            case 1:
                $task->status_id = 3;
                break;
            case 2: 
                $task->status_id = 1;
                break;
            case 3:
                $task->status_id = 2;
                break;
            default:
                $task->status_id = 2;
        }

        $task->status_position = null;
        $task->save();
    }

    public function getAllUsersProperty()
    {
        return User::all();
    }

    public $currentTask;

    // public function taskClicked($id)
    // {
    //     $this->currentTask = BoardItem::find($id);
    // }

    public function applyFilters(array $filters): void
    {
        $this->filterUserId = $filters['user']     ?? $this->filterUserId;
        $this->dueStart     = $filters['dueStart'] ?? $this->dueStart;
        $this->dueEnd       = $filters['dueEnd']   ?? $this->dueEnd;

        // Trigger a re-render (render() re-runs getTasksProperty())
        $this->dispatchBrowserEvent('kanban-filters-applied');
    }

}