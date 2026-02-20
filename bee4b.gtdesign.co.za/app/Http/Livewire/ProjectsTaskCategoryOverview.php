<?php

namespace App\Http\Livewire;

use Illuminate\Support\Facades\DB;
use Livewire\Component;

class ProjectsTaskCategoryOverview extends Component
{
    public string $search = '';

    public function render()
    {
        $rows = $this->fetchAggregates();

        // 1) First: shape rows -> projects (board) -> categories
        $projects = [];
        foreach ($rows as $r) {
            $pid = $r->board_id;

            if (!isset($projects[$pid])) {
                $projects[$pid] = [
                    'board_id'     => $pid,
                    'project'      => $r->board_name,
                    'client'       => $r->client_name ?? 'Unknown Client',
                    'client_id'    => $r->client_id,
                    'created_at'   => $r->board_created_at,
                    'red_flagged'  => (bool) ($r->red_flagged ?? false),
                    'categories'   => [],
                ];
            }

            $total  = (int) $r->total_tasks;
            $counts = [
                'complete'  => (int) $r->cnt_complete,
                'active'    => (int) $r->cnt_active,
                'inactive'  => (int) $r->cnt_inactive,
                'red_flag'  => (int) $r->cnt_red_flag,   // NEW
            ];

            // Percentages for 4 buckets, normalized to 100
            $pct = ['complete' => 0, 'active' => 0, 'inactive' => 0, 'red_flag' => 0];
            if ($total > 0) {
                foreach ($pct as $k => $_) {
                    $pct[$k] = round(($counts[$k] / $total) * 100);
                }
                $sum = array_sum($pct);
                if ($sum !== 100) {
                    // Adjust the currently largest bucket to absorb rounding diff
                    $maxKey = array_keys($pct, max($pct))[0];
                    $pct[$maxKey] += (100 - $sum);
                }
            }

            $projects[$pid]['categories'][] = [
                'category' => $r->category_group,
                'total'    => $total,
                'counts'   => $counts,
                'percent'  => $pct,
            ];

            /** --------------- B: accumulate project totals here ---------------- */
            if (!isset($projects[$pid]['__totals'])) {
                $projects[$pid]['__totals'] = ['total' => 0, 'complete' => 0];
            }
            $projects[$pid]['__totals']['total']    += $total;
            $projects[$pid]['__totals']['complete'] += $counts['complete'];
            /** ------------------------------------------------------------------ */
        }

        // --------------- C: order categories + compute visible incompletes --------
        $order = ['Planning' => 1, 'Implementation' => 2, 'Review' => 3, 'Verification' => 4];

        foreach ($projects as &$p) {
            // order categories
            usort($p['categories'], function ($a, $b) use ($order) {
                $oa = $order[$a['category']] ?? 99;
                $ob = $order[$b['category']] ?? 99;
                return $oa <=> $ob;
            });

            // keep only the four visible buckets
            $p['categories'] = array_values(array_filter(
                $p['categories'],
                fn($c) => in_array($c['category'], ['Planning', 'Implementation', 'Review', 'Verification'], true)
            ));

            // compute totals **based on what we show**
            $visibleTotal      = 0;
            $visibleComplete   = 0;
            $visibleIncomplete = 0;

            foreach ($p['categories'] as $c) {
                $t    = (int) ($c['total'] ?? 0);
                $done = (int) ($c['counts']['complete'] ?? 0);
                $visibleTotal      += $t;
                $visibleComplete   += $done;
                $visibleIncomplete += max(0, $t - $done);   // explicit incomplete count
            }

            $p['__visible_total']      = $visibleTotal;
            $p['__visible_complete']   = $visibleComplete;
            $p['__visible_incomplete'] = $visibleIncomplete;
        }
        unset($p);

        // filter here once (keeps any project that has *some* visible incomplete work)
        $projects = array_filter($projects, fn($p) => (int) ($p['__visible_incomplete'] ?? 0) > 0);

        // 2) Optional search across client/project
        if ($this->search !== '') {
            $needle = mb_strtolower($this->search);
            $projects = array_filter(
                $projects,
                fn($p) => str_contains(mb_strtolower($p['client'] . ' ' . $p['project']), $needle)
            );
        }

        $parseNameDate = function (string $name): ?int {
            // accepts "YYYY-MM-DD" anywhere in the name; returns unix timestamp or null
            if (preg_match('/\b(\d{4})-(\d{2})-(\d{2})\b/', $name, $m)) {
                $ts = strtotime("{$m[1]}-{$m[2]}-{$m[3]} 00:00:00");
                return $ts ?: null;
            }
            return null;
        };

        $byClient = [];
        foreach ($projects as $p) {
            $client = $p['client'] ?? 'Unknown Client';

            // sort key: derived from name if possible, else created_at, else 0
            $nameTs   = $parseNameDate($p['project']);
            $createdTs= $p['created_at'] ? strtotime($p['created_at']) : 0;
            $sortKey  = $nameTs ?: $createdTs;

            $p['__sort'] = $sortKey;
            $byClient[$client][] = $p;
        }

        // sort each client’s projects by sortKey desc and keep 2
        $clients = [];
        foreach ($byClient as $clientName => $plist) {
            usort($plist, fn($a, $b) => ($b['__sort'] <=> $a['__sort']));
            $kept = array_slice($plist, 0, 2);
            // filter out fully complete here
            $kept = array_values(array_filter($kept, fn($p) => (int) ($p['__visible_incomplete'] ?? 0) > 0));

            // drop helper
            foreach ($kept as &$k) unset($k['__sort']);
            unset($k);

            if (count($kept) > 0) {
                $clients[] = [
                    'client'   => $clientName,
                    'projects' => $kept,
                ];
            }
        }

        // sort clients alphabetically
        usort($clients, fn($a, $b) => strcasecmp($a['client'], $b['client']));

        return view('livewire.projects-task-category-overview', [
            'clients' => $clients,
        ]);
    }

    protected function fetchAggregates()
    {
        $boardsTable      = 'boards';
        $boardItemsTable  = 'board_items';
        $clientsTable     = 'clients';

        $caseCategory = "
        CASE 
            WHEN bi.phase_id = 3 THEN 'Planning'
            WHEN bi.phase_id IN (4,5) THEN 'Implementation'
            WHEN bi.phase_id = 6 THEN 'Review'
            WHEN bi.phase_id IN (7,8) THEN 'Verification'   -- was Audit
            ELSE 'Other'
        END
        ";

        return DB::table("$boardItemsTable as bi")
            ->join("$boardsTable as b", 'b.id', '=', 'bi.board_id')
            ->leftJoin("$clientsTable as c", 'c.id', '=', 'b.boardable_id')
            ->selectRaw('
                b.id as board_id,
                b.name as board_name,
                b.created_at as board_created_at,
                b.red_flagged, 
                c.id as client_id,
                c.name as client_name,
                ' . $caseCategory . ' as category_group,
                COUNT(*) as total_tasks,
                SUM(CASE WHEN COALESCE(bi.status_id, 2) = 3 THEN 1 ELSE 0 END) as cnt_complete,
                SUM(CASE WHEN COALESCE(bi.status_id, 2) = 1 THEN 1 ELSE 0 END) as cnt_active,
                SUM(CASE WHEN COALESCE(bi.status_id, 2) = 2 THEN 1 ELSE 0 END) as cnt_inactive,
                SUM(CASE WHEN COALESCE(bi.status_id, 2) = 4 THEN 1 ELSE 0 END) as cnt_red_flag
            ')
            ->whereIn('bi.phase_id', [3, 4, 5, 6, 7, 8])
            ->whereNull('c.deleted_at')
            ->whereNull('b.deleted_at')
            ->groupBy('b.id', 'b.name', 'b.created_at', 'c.id', 'c.name', 'b.red_flagged')
            ->groupBy(DB::raw($caseCategory))
            ->get();
    }
}