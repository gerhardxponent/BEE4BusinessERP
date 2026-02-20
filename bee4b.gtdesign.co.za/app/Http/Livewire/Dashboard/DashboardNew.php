<?php

namespace App\Http\Livewire\Dashboard;

use App\Models\Board;
use App\Models\BoardItem;
use App\Models\Clients;
use App\Models\Region;
use App\Models\Sector;
use App\Models\Size;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Livewire\Component;

class DashboardNew extends Component
{
    public User $user;
    public $board;
    public $clients;
    public $audits;
    public $analysts;
    public $managers;

    public $analystData = [];
    public $clientData = [];
    public $auditData = [];
    public $managerData = [];
    public $sectorData = [];
    public $regionData = [];
    public $sizeData = [];
    public $groups = ["Active Clients", "Inactive Clients"];

    public $tabs = ["audits","clients","analysts"];
    public $currentTab;

    public function mount()
    {
        $this->user = User::find(Auth::id());
        $this->board = Board::first();
        $this->clients = Clients::all();

        $this->currentTab = Cookie::get('dashboard_tab') ?? "audits";
    }

    public function render()
    {
        return view('livewire.dashboard.dashboard-new')
            ->layoutData([
                'title' => 'Dashboard'
            ]);
    }

    public function changeTab($tab)
    {
        Cookie::queue('dashboard_tab', $tab, 525600);

        $this->currentTab = $tab;
    }

    protected function generateInitials($name)
    {
        $words = explode(" ", trim($name));
        if (count($words) == 0) return "";
        
        $initials = "";
        foreach ($words as $w) {
            $initials .= $w[0];
        }
        return $initials;
    }

    public function allChartData($board)
    {
        $activeCount    = count($board->boardItems->where('status_id', 1)->where('overdue', 0));
        $inactiveCount  = count($board->boardItems->where('status_id', 2)->where('overdue', 0));
        $completeCount  = count($board->boardItems->where('status_id', 3)->where('overdue', 0));
        $overdueCount   = count($board->boardItems->where('overdue', 1));

        return [
            'remainingCount' => $activeCount + $inactiveCount + $overdueCount,
            'data' => [
                $activeCount, 
                $inactiveCount, 
                $completeCount, 
                $overdueCount
            ],
            'labels' => [
                $activeCount . ' Active', 
                $inactiveCount . ' Inactive', 
                $completeCount . ' Complete',
                $overdueCount . ' Overdue',
            ],
            'colours' => [
                "#4ade80",  // Active
                "#94a3b8",  // Inactive
                "#60a5fa",  // Complete
                "#f87171",  // Overdue
            ]
        ];
    }

    public function getChartDataProperty()
    {
        return 
            Clients::query()
                ->whereHas('boardsMorph.boardItems.assignedUsers', function($query) {
                    $query->where('users.id', Auth::id());
                })
                ->with('boardsMorph', function($query) {
                    $query
                        ->with('boardItems', function($q) {
                            $q->whereHas('assignedUsers', function($q2) {
                                $q2->where('users.id', Auth::id());
                            });
                        });
                        // ->orderBy('created_at')
                        // ->limit(1);
                })
                // ->with('boards.boardItems', function($query) {
                //     $query->orderByDesc('boards.created_at')->limit(1);
                // })
                ->get();
    }

    // Charts
    public function buildAllocationsPerAnalystChart()
    {
        //select only certain fields
        $analysts = User::role('analyst')->get();

        $names = ["x"];
        $activeValues = ["Active Clients"];
        $inactiveValues = ["Inactive Clients"];

        foreach($analysts as $analyst) {
            array_push($names, $analyst->name);
            array_push($activeValues, count($analyst->analysingClients->where('state', 1)));
            array_push($inactiveValues, count($analyst->analysingClients->where('state', 2)));
        }

        array_push($this->analystData, $names);
        array_push($this->analystData, $activeValues);
        array_push($this->analystData, $inactiveValues);
    }

    public function buildAllocationsPerManagerChart()
    {
        //select only certain fields
        $managers = User::role('manager')->get();

        $names = ["x"];
        $activeValues = ["Active Clients"];
        $inactiveValues = ["Inactive Clients"];

        foreach($managers as $manager) {
            array_push($names, $manager->name);
            array_push($activeValues, count($manager->managingClients->where('state', 1)));
            array_push($inactiveValues, count($manager->managingClients->where('state', 2)));
        }

        array_push($this->managerData, $names);
        array_push($this->managerData, $activeValues);
        array_push($this->managerData, $inactiveValues);
    }

    public function buildSectorCodeChart()
    {
        $sectors = Sector::all();

        $names = ["x"];
        $values = ["Clients"];

        foreach($sectors as $sector) {
            array_push($names, $sector->name);
            array_push($values, count($sector->clients));
        }

        array_push($this->sectorData, $names);
        array_push($this->sectorData, $values);
    }

    public function buildTotalPerRegionChart()
    {
        $regions = Region::all();

        $names = ["x"];
        $values = ["Clients"];

        foreach($regions as $region) {
            array_push($names, $region->name);
            array_push($values, count($region->clients));
        }

        array_push($this->regionData, $names);
        array_push($this->regionData, $values);
    }

    public function buildTotalPerSizeChart()
    {
        $sizes = Size::all();

        $names = ["x"];
        $values = ["Clients"];

        foreach($sizes as $size) {
            array_push($names, $size->name);
            array_push($values, count($size->clients));
        }

        array_push($this->sizeData, $names);
        array_push($this->sizeData, $values);
    }
    // End charts

    public function setCompleted($index)
    {
        $item = BoardItem::find($index);

        if($item->completed == 1) $item->completed = 0;
        else $item->completed = 1;

        $item->save();
    }

    public function clientRedirect($id)
    {
        return redirect()->to('/clients/' . $id);
    }
}
