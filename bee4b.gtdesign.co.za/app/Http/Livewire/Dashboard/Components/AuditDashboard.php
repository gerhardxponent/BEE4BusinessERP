<?php

namespace App\Http\Livewire\Dashboard\Components;

use App\Models\Month;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Audit;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class AuditDashboard extends Component
{
    use WithPagination;

    public $perPage = 2;
    // Filters
    public $search = '';
    public $agency = '';
    public $analyst = '';

    /** currently selected year (shown in the tabs) */
    // ✅ untyped, so Livewire can freely set it
   

    /** list of years for the tabs */
    public $year = 0;          // <- remove the int type
public array $years = [];
protected $queryString = ['year', 'search', 'agency', 'analyst']; // keep filters in URL

public function mount(): void
{
    // Initialize from URL on first load
    $this->year = (int) request('year', now()->year);
    $this->search = trim((string) request('search', $this->search ?? ''));
    // Keep original case from URL; do case-insensitive comparisons when filtering
    $this->agency = trim((string) request('agency', $this->agency ?? ''));
    $this->analyst = trim((string) request('analyst', $this->analyst ?? ''));

    $min = \DB::table('clients')->selectRaw('MIN(YEAR(next_audit)) y')->value('y');
    $max = \DB::table('clients')->selectRaw('MAX(YEAR(next_audit)) y')->value('y');
    if (!$min || !$max) $min = $max = $this->year;

    $this->years = range((int)$max, (int)$min);
}

/** computed property used by your Blade as $this->months */
public function getMonthsProperty()
{
    $y = (int) $this->year;

    return \App\Models\Month::with([
        'clients' => function ($q) use ($y) {
            $q->whereNotNull('next_audit')
              ->whereYear('next_audit', $y)
              ->orderBy('next_audit');
        },
        'clients.getAnalyst',
        'clients.ratingAgency',
        'clients.ratingAnalyst',
    ])->get();
}

/** fires whenever $year changes (button click or URL) */
public function updatedYear($value): void
{
    if (method_exists($this, 'resetPage')) $this->resetPage();
    $this->emitSelf('$refresh');
}


    public function changeYear(int $y): void
    {
        $this->year = $y;          // updatedYear() will handle the rest
    }

    // URL navigation happens client-side via Alpine; no server redirect on property updates
    public function updatedSearch($value): void {}
    public function updatedAgency($value): void {}
    public function updatedAnalyst($value): void {}

    protected function redirectWithFilters(): void
    {
        $params = http_build_query([
            'year' => (int) $this->year,
            'search' => (string) $this->search,
            'agency' => (string) $this->agency,
            'analyst' => (string) $this->analyst,
        ]);
        $base = route('dashboard');
        $url = $base . '?' . $params;
        // Use Livewire redirect to force browser URL update
        $this->redirect($url);
    }

    public function resetFilters(): void
    {
        $this->search = '';
        $this->agency = '';
        $this->analyst = '';
        $this->redirectWithFilters();
    }



    public function render()
    {
        return view('livewire.dashboard.components.audit-new-dashboard', [
            'months' => $this->getAuditsGroupedByMonth(), // <-- your existing method
        ]);
    }

    private function getAudits()
    {
        return Audit::with(['auditFiles.fileDetails']) // Load related files
            ->latest() // Order audits by latest first
            ->get()
            ->map(function ($audit) {
                $totalFiles = $audit->auditFiles->where('file_id', '!=', null)->count();

                return [
                    'auditName' => $audit->auditFiles->first()?->fileDetails?->file_name ?? 'No File Name',
                    'audit' => $audit,
                    'percentage' => $totalFiles > 0 ? $audit->auditFiles->where('status', 1)->count() / $totalFiles * 100 : 0,
                    'pendingPercentage' => $totalFiles > 0 ? $audit->auditFiles->where('status', 0)->count() / $totalFiles * 100 : 0,
                    'rejectedPercentage' => $totalFiles > 0 ? $audit->auditFiles->where('status', 2)->count() / $totalFiles * 100 : 0,
                ];
            });
    }


    public function getAuditsGroupedByMonth()
    {
        $STATUS_APPROVED = 1;
        $STATUS_PENDING = 0;
        $STATUS_REJECTED = 2;

        return Audit::query()
            ->join('clients', 'clients.id', '=', 'audits.client_id')
            ->with([
                'auditFiles:id,audit_id,status,file_id',
                'client:id,name,next_audit,planned_audit_date,rating_agency_id,rating_analyst_id,analyst',
                'client.ratingAgency:id,name',
                'client.ratingAnalyst:id,name',
                'client.getAnalyst:id,name',
            ])
            // 🔹 filter by selected tab year using next_audit (fallback: audit created_at)
            ->whereYear(DB::raw('COALESCE(clients.next_audit, audits.created_at)'), $this->year)
            ->select('audits.*') // important after join
            ->latest('audits.created_at')
            ->get()

            // 🔹 group heading = month of next_audit (fallback created_at)
            ->groupBy(function ($audit) {
                $dt = $audit->client?->next_audit
                    ? Carbon::parse($audit->client->next_audit)
                    : $audit->created_at;
                return $dt->format('F Y');
            })
            ->sortKeysDesc()

            ->map(function ($audits) use ($STATUS_APPROVED, $STATUS_PENDING, $STATUS_REJECTED) {
                return $audits->map(function ($audit) use ($STATUS_APPROVED, $STATUS_PENDING, $STATUS_REJECTED) {

                    $files = $audit->auditFiles->filter(fn($f) => !is_null($f->file_id));
                    $total = $files->count();
                    $approved = $files->where('status', $STATUS_APPROVED)->count();
                    $pending = $files->where('status', $STATUS_PENDING)->count();
                    $rejected = $files->where('status', $STATUS_REJECTED)->count();
                    $pct = fn($n, $d) => $d > 0 ? (int) round($n / $d * 100) : 0;

                    // table “Audit Date” = clients.next_audit (fallback audit->audit_date or created_at)
                    $auditDate = $audit->client?->next_audit
                        ? Carbon::parse($audit->client->next_audit)
                        : ($audit->audit_date ?? $audit->created_at);

                    $engagementRaw = $audit->client?->planned_audit_date;
                    $engagementDate = $engagementRaw
                        ? optional(Carbon::parse($engagementRaw))->format('Y-m-d')
                        : null;

                    return [
                        'id' => $audit->id,
                        'client_id' => $audit->client?->id,
                        'client_name' => $audit->client?->name ?? '—',
                        'analyst_initials' => optional($audit->client?->getAnalyst)->name
                            ? $this->generateInitials($audit->client->getAnalyst->name)
                            : (optional($audit->client?->analyst)->name
                                ? $this->generateInitials($audit->client->analyst->name)
                                : ''),
                        'audit_date' => optional($auditDate)->format('Y-m-d'),
                        'engagement_date' => $engagementDate,
                        'agency' => $audit->client?->ratingAgency?->name ?? '—',
                        'rating_analyst' => $audit->client?->ratingAnalyst?->name ?? '—',
                        'approvedPct' => $pct($approved, $total),
                        'pendingPct' => $pct($pending, $total),
                        'rejectedPct' => $pct($rejected, $total),
                    ];
                });
            });
    }

    private function getAuditsGroupedByMonth1()
    {
        return Audit::with(['auditFiles.fileDetails']) // Load related files
            ->get()
            ->groupBy(function ($audit) {
                return $audit->created_at->format('F Y'); // Group audits by their creation month and year
            })
            ->sortKeysDesc()
            ->map(function ($audits) {
                return $audits->map(function ($audit) {
                    $totalFiles = $audit->auditFiles->where('file_id', '!=', null)->count();

                    return [
                        'auditName' => $audit->auditFiles->first()?->fileDetails?->file_name ?? 'No File Name',
                        'audit' => $audit,
                        'percentage' => $totalFiles > 0 ? $audit->auditFiles->where('status', 1)->count() / $totalFiles * 100 : 0,
                        'pendingPercentage' => $totalFiles > 0 ? $audit->auditFiles->where('status', 0)->count() / $totalFiles * 100 : 0,
                        'rejectedPercentage' => $totalFiles > 0 ? $audit->auditFiles->where('status', 2)->count() / $totalFiles * 100 : 0,
                    ];
                });
            });
    }

    protected function generateInitials($name)
    {
        $words = explode(" ", trim($name));
        if (count($words) == 0)
            return "";

        $initials = "";
        foreach ($words as $w) {
            $initials .= $w[0];
        }
        return $initials;
    }

    protected array $progressCache = [];

    // inside the AuditDashboard class
    public function auditProgressFor(int $clientId): array
    {
        // cache so repeated Blade calls don't requery
        if (isset($this->progressCache[$clientId])) {
            return $this->progressCache[$clientId];
        }

        // tweak if your status codes differ
        $STATUS_APPROVED = 1;
        $STATUS_PENDING = 0;
        $STATUS_REJECTED = 2;

        $audit = Audit::with([
            'auditFiles' => function ($q) {
                $q->select('id', 'audit_id', 'status', 'file_id');
            }
        ])
            ->where('client_id', $clientId)
            ->latest()
            ->first();

        if (!$audit) {
            return $this->progressCache[$clientId] = ['approved' => 0, 'pending' => 0, 'rejected' => 0];
        }

        $files = $audit->auditFiles->filter(fn($f) => !is_null($f->file_id));
        $total = $files->count();

        if ($total === 0) {
            return $this->progressCache[$clientId] = ['approved' => 0, 'pending' => 0, 'rejected' => 0];
        }

        $approved = $files->where('status', $STATUS_APPROVED)->count();
        $pending = $files->where('status', $STATUS_PENDING)->count();
        $rejected = $files->where('status', $STATUS_REJECTED)->count();

        $pct = fn($n, $d) => (int) round($n / $d * 100);

        return $this->progressCache[$clientId] = [
            'approved' => $pct($approved, $total),
            'pending' => $pct($pending, $total),
            'rejected' => $pct($rejected, $total),
        ];
    }

}
