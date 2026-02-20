<?php

namespace App\Http\Livewire\GlobalComponents;

use App\Exports\ActivityExport;
use App\Models\Activity as ModelsActivity;
use App\Models\File;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;

class Activity extends Component
{
    use WithPagination;
    
    // public $activities;
    public $showPath = false;
    public $showFileDetailsModal = false;
    public $selectedFile;
    public $selectedFileOriginalName = '';
    public $editFile = false;
    
    public $model;
    public $entityID;
    public $userID = null;
    public $itemsPerPage = 10;
    public $showPages = true;
    public $showHeader = true;

    public $searchString = '';

    public $filters = [
        'type' => '',
        'user' => '',
        'date' => '',
    ];

    // protected $listeners = [
    //     'fileSelected'
    // ];

    protected $rules = [
        'selectedFile.file_name' => 'required',
        'selectedFile.client_comments' => 'required',
        'selectedFile.reviewer_comments' => 'required',
        'selectedFile.status' => 'required',
    ];

    public function mount()
    {
        // dd(ModelsActivity::query()
            // ->where('activityable_id', $this->entityID)
            // ->where('activityable_type', $this->model)
            // ->orderByDesc('created_at'));

        // dd($this->activities);
        // $this->activities = $activities;
        // $this->activities = $activities->sortByDesc('created_at');
        $this->selectedFile = File::make(); 

        // $this->export();

        // $act = ModelsActivity::find(414);

        // $arr = explode(' / ', strip_tags($act->path));
        // dd(end($arr));
    }

    public function render()
    {
        $actvityQuery = ModelsActivity::query();

        if ($this->userID != null) {
            $actvityQuery = $actvityQuery->where('user_id', $this->userID);
        } else {
            $actvityQuery = 
                $actvityQuery
                    ->where('activityable_id', $this->entityID)
                    ->where('activityable_type', $this->model);
        }

        $actvityQuery = 
            $actvityQuery
                ->with('user')
                ->when($this->searchString, function($query) {
                    $query
                        ->where('title', 'like', '%' . $this->searchString . '%')
                        ->orWhere('body', 'like', '%' . $this->searchString . '%')
                        ->orWhereHas('user', function($query) {
                            $query->where('users.name', 'like', '%' . $this->searchString . '%');
                        });
                })
                ->when($this->filters['type'], function($query) {
                    $query->where('activity_type', $this->filters['type']);
                })
                ->when($this->filters['user'], function($query) {
                    $query->where('user_id', $this->filters['user']);
                })
                ->when($this->filters['date'], function($query) {
                    $range = explode(' to ', $this->filters['date']);
                    if (count($range) === 1) {
                        $query->whereDate('created_at', $range[0]);    
                    } else {
                        $query
                            ->whereDate('created_at', '>=', $range[0])
                            ->whereDate('created_at', '<=', $range[1]);
                    }
                })
                ->orderByDesc('created_at')
                ->paginate($this->itemsPerPage);

        return view('livewire.global-components.activity', [
            'activities' => $actvityQuery
        ]);
    }

    public function export()
    {
        $actvityQuery = ModelsActivity::query();

        if ($this->userID != null) {
            $actvityQuery = $actvityQuery->where('user_id', $this->userID);
        } else {
            $actvityQuery = 
                $actvityQuery
                    ->where('activityable_id', $this->entityID)
                    ->where('activityable_type', $this->model);
        }

        $actvityQuery = 
            $actvityQuery
                ->when($this->searchString, function($query) {
                    $query
                        ->where('title', 'like', '%' . $this->searchString . '%')
                        ->orWhere('body', 'like', '%' . $this->searchString . '%');
                })
                ->when($this->filters['type'], function($query) {
                    $query->where('activity_type', $this->filters['type']);
                })
                ->when($this->filters['user'], function($query) {
                    $query->where('user_id', $this->filters['user']);
                })
                ->when($this->filters['date'], function($query) {
                    $range = explode(' to ', $this->filters['date']);
                    if (count($range) === 1) {
                        $query->whereDate('created_at', $range[0]);    
                    } else {
                        $query
                            ->whereDate('created_at', '>=', $range[0])
                            ->whereDate('created_at', '<=', $range[1]);
                    }
                })
                ->get();

        return Excel::download(new ActivityExport($actvityQuery), 'activities.xlsx');
    }

    public function getTypesProperty()
    {
        return DB::table('activities')->select('activity_type')->groupBy('activity_type')->get();
    }

    public function clearFilters()
    {
        $this->searchString = '';
        foreach ($this->filters as $key => $value) {
            $this->filters[$key] = '';
        }

        $this->emit('clear_flatpickr');
        $this->emit('clearSelect2');
    }

    protected function generateInitials($name)
    {
        $words = explode(" ", $name);
        $initials = null;
        foreach ($words as $w) {
            $initials .= $w[0];
        }
        return $initials;
    }

    public function activityTime($time)
    {
        $humanDate = $time->day . ' ' . $time->englishMonth . ' ' . $time->year;
        $humanTime = ($time->hour < 10 ? '0' . $time->hour : $time->hour) . ':' . (($time->minute < 10) ? ('0' . $time->minute) : ($time->minute));

        if (Carbon::now()->diffInDays($time) == 0) {
            if(Carbon::now()->diffInHours($time) == 0) {
                if(Carbon::now()->diffInMinutes($time) == 0) {
                    return Carbon::now()->diffInSeconds($time) . ' seconds ago';
                } else {
                    return Carbon::now()->diffInMinutes($time) . ' minutes ago';
                }
            } else {
                return Carbon::now()->diffInHours($time) . ' hours ago';
            }
        } else {
            if(Carbon::now()->diffInDays($time) >= 5) {
                return $humanDate . ', ' . $humanTime;
            } else {
                return Carbon::now()->diffInDays($time) . ' days ago';
            }
        }

        return 'right now';
    }

    // public function fileSelected($id)
    // {
    //     $this->selectedFile = File::find($id);
    //     $this->selectedFileOriginalName = $this->selectedFile->file_name;
    //     $this->showFileDetailsModal = true;
    // }

    public function toggleFileEdit()
    {
        if($this->editFile) {
            $this->selectedFile = File::find($this->selectedFile->id);
        }
        $this->editFile = !$this->editFile;
    }

    public function updateFile()
    {
        if($this->selectedFile->file_name == '') $this->selectedFile->file_name = File::find($this->selectedFile->id)->file_name;
        // $this->validate();

        if($this->selectedFileOriginalName != $this->selectedFile->file_name) {
            Storage::move(
                $this->selectedFile->file_path . '/' . $this->selectedFileOriginalName . '.' . $this->selectedFile->type,
                $this->selectedFile->file_path . '/' . $this->selectedFile->file_name . '.' . $this->selectedFile->type
            );
        }

        $this->selectedFile->save();
        // $this->emit('pg:eventRefresh-GlobalFilesTable');
        $this->editFile = false;
        $this->showFileDetailsModal = false;
    }

    public function downloadSelected() 
    { 
        return Storage::download($this->selectedFile->file_path . '/' . $this->selectedFile->file_name . '.' . $this->selectedFile->type); 
    }
}
