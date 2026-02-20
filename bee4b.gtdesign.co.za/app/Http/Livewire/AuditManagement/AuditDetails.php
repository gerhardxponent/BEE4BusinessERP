<?php

namespace App\Http\Livewire\AuditManagement;

use App\Models\Audit;
use App\Models\AuditFile;
use App\Models\File;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\AuditReferenceCategory;
use Illuminate\Support\Facades\DB;

class AuditDetails extends Component
{
    use WithFileUploads;

    public $audit;
    public $client;
    public $activities;

    public $tabs = ['details', 'edit-details','exports', 'activity'];
    public $currentTab = 'details';

    protected $listeners = [
        'downloadFile'
    ];

    protected $queryString = [
        'currentTab' => ['as' => 'tab']
    ];

    public function mount($id)
    {
        $this->audit = Audit::with('auditFiles', 'client', 'activities')->get()->where('id', $id)->first();
        $this->client = $this->audit->client()->withTrashed()->first();
        $this->activities = $this->audit->activities()->with('user')->get();

        // dd($this->audit->auditFiles->where('status', 0));
    }

    public function auditFileClicked($id): void
    {
        $this->activeFile = AuditFile::find($id);
        $this->showCommentsModal = true;
    }

    public function getPercentageProperty(): float|int
    {
        if (count($this->audit->auditFiles->where('file_id', '!=', null)) > 0) {
            return ((count($this->audit->auditFiles->where('status', 1)->where('file_id', '!=', null)) / count($this->audit->auditFiles->where('file_id', '!=', null))) * 100);
        } else {
            return 0;
        }
    }
    public function getPendingPercentageProperty(): float|int
    {
        if (count($this->audit->auditFiles->where('file_id', '!=', null)) > 0) {
            return ((count($this->audit->auditFiles->where('status', 0)->where('file_id', '!=', null)) / count($this->audit->auditFiles->where('file_id', '!=', null))) * 100);
        } else {
            return 0;
        }
    }
    public function getRejectedPercentageProperty(): float|int
    {
        if (count($this->audit->auditFiles->where('file_id', '!=', null)) > 0) {
            return ((count($this->audit->auditFiles->where('status', 2)->where('file_id', '!=', null)) / count($this->audit->auditFiles->where('file_id', '!=', null))) * 100);
        } else {
            return 0;
        }
    }

    protected function generateInitials($name): ?string
    {
        $words = explode(" ", $name);
        $initials = null;
        foreach ($words as $w) {
            $initials .= $w[0];
        }
        return $initials;
    }

    public function changeTab($tab): void
    {
        $this->currentTab = $tab;
    }

    public function downloadFile($id)
    {
        $file = File::find($id);
        return Storage::download($file->file_path . '/' . $file->file_name . '.' . $file->type);
    }

    public function delete()
    {
        // Legacy delete mapped to archive (soft delete)
        $this->archive();
    }

    public function archive(): void
    {
        if (!$this->audit->trashed()) {
            $this->audit->delete();
            // Refresh local instance to reflect trashed state
            $this->audit = Audit::withTrashed()->with('client')->find($this->audit->id);
            session()->flash('message', 'Audit archived');
        }
    }

    public function restore(): void
    {
        if ($this->audit->trashed()) {
            $this->audit->restore();
            $this->audit = Audit::with('client')->find($this->audit->id);
            session()->flash('message', 'Audit restored');
        }
    }

    public $searchTerm = ''; // Search term for filtering

    public function render()
    {
        return view('livewire.audit-management.audit-details', [
            'searchTerm' => $this->searchTerm, // Pass filter term to child component
        ]);
    }

    public function getProjectProgressProperty()
    {
        if (!$this->audit->board_id) {
            return null;
        }

        $boardId = $this->audit->board_id;

        $caseCategory = "
        CASE 
            WHEN bi.phase_id = 3 THEN 'Planning'
            WHEN bi.phase_id IN (4,5) THEN 'Implementation'
            WHEN bi.phase_id = 6 THEN 'Review'
            WHEN bi.phase_id IN (7,8) THEN 'Verification'
            ELSE 'Other'
        END
    ";

        $rows = DB::table('board_items as bi')
            ->join('boards as b', 'b.id', '=', 'bi.board_id')
            ->leftJoin('clients as c', 'c.id', '=', 'b.boardable_id')
            ->selectRaw('
            b.id as board_id,
            b.name as board_name,
            c.name as client_name,
            ' . $caseCategory . ' as category_group,
            COUNT(*) as total_tasks,
            SUM(CASE WHEN COALESCE(bi.status_id, 2) = 3 THEN 1 ELSE 0 END) as cnt_complete,
            SUM(CASE WHEN COALESCE(bi.status_id, 2) = 1 THEN 1 ELSE 0 END) as cnt_active,
            SUM(CASE WHEN COALESCE(bi.status_id, 2) = 2 THEN 1 ELSE 0 END) as cnt_inactive,
            SUM(CASE WHEN COALESCE(bi.status_id, 2) = 4 THEN 1 ELSE 0 END) as cnt_red_flag
        ')
            ->where('b.id', $boardId)
            ->whereIn('bi.phase_id', [3, 4, 5, 6, 7, 8])
            ->whereNull('c.deleted_at')
            ->whereNull('b.deleted_at')
            ->groupBy('b.id', 'b.name', 'c.name')
            ->groupBy(DB::raw($caseCategory))
            ->get();

        if ($rows->isEmpty()) {
            return null;
        }

        $project = [
            'board_id' => $boardId,
            'project' => $rows->first()->board_name,
            'client' => $rows->first()->client_name ?? 'Unknown Client',
            'categories' => [],
        ];

        $order = ['Planning' => 1, 'Implementation' => 2, 'Review' => 3, 'Verification' => 4];

        foreach ($rows as $r) {
            $total = (int) $r->total_tasks;
            $counts = [
                'complete' => (int) $r->cnt_complete,
                'active' => (int) $r->cnt_active,
                'inactive' => (int) $r->cnt_inactive,
                'red_flag' => (int) $r->cnt_red_flag,
            ];

            $pct = ['complete' => 0, 'active' => 0, 'inactive' => 0, 'red_flag' => 0];
            if ($total > 0) {
                foreach ($pct as $k => $_) {
                    $pct[$k] = round(($counts[$k] / $total) * 100);
                }
                $sum = array_sum($pct);
                if ($sum !== 100) {
                    $maxKey = array_keys($pct, max($pct))[0];
                    $pct[$maxKey] += (100 - $sum);
                }
            }

            $project['categories'][] = [
                'category' => $r->category_group,
                'total' => $total,
                'counts' => $counts,
                'percent' => $pct,
            ];
        }

        usort($project['categories'], function ($a, $b) use ($order) {
            $oa = $order[$a['category']] ?? 99;
            $ob = $order[$b['category']] ?? 99;
            return $oa <=> $ob;
        });

        $project['categories'] = array_values(array_filter(
            $project['categories'],
            fn($c) => in_array($c['category'], ['Planning', 'Implementation', 'Review', 'Verification'], true)
        ));

        return $project;
    }

}
