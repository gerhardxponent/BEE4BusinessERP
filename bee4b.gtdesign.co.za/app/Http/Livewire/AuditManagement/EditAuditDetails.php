<?php

namespace App\Http\Livewire\AuditManagement;

use App\Models\Audit;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class EditAuditDetails extends Component
{
    public int $auditId;
    public $audit;
    public $client;

    public array $form = [
        'planned_audit_month_id' => null,
        'date_va_engaged' => null,
        'next_audit_date' => null,
        'rating_agency_id' => null,
        'rating_analyst_id' => null,
    ];

    public $analystOptions = [];
    public $ratingAgencyOptions = [];
    public $monthOptions = [];
    public $savedMessage = null;

    protected $rules = [
        'form.planned_audit_month_id' => 'nullable|integer',
        'form.date_va_engaged' => 'nullable|date',
        'form.next_audit_date' => 'nullable|date',
        'form.rating_agency_id' => 'nullable|exists:rating_agencies,id',
        'form.rating_analyst_id' => 'nullable|exists:users,id',
    ];

    public function mount(int $auditId): void
    {
        $this->auditId = $auditId;
        $this->audit = Audit::with('client')->findOrFail($auditId);
        $this->client = $this->audit->client;

        $this->hydrateFormFromClient();
        $this->loadOptions();
    }

    protected function hydrateFormFromClient(): void
    {
        $this->form['planned_audit_month_id'] = $this->client->planned_audit_month_id ?? null;
        $this->form['date_va_engaged']        = $this->client->date_engaged ?? null;
        $this->form['next_audit_date']        = $this->client->next_audit ?? null;
        $this->form['rating_agency_id']       = $this->client->rating_agency_id ?? null;
        $this->form['rating_analyst_id']      = $this->client->rating_analyst_id ?? null;
    }

    protected function loadOptions(): void
    {
        $this->analystOptions = User::query()
            ->where('enabled', 1)
            ->whereHas('roles', function ($q) {
                $q->whereIn('name', ['Analyst', 'Admin']);
            })
            ->orderBy('name')
            ->get(['id', 'name']);

        if (DB::getSchemaBuilder()->hasTable('rating_agencies')) {
            $this->ratingAgencyOptions = DB::table('rating_agencies')->orderBy('name')->get(['id', 'name']);
        } else {
            $this->ratingAgencyOptions = collect();
        }

        if (DB::getSchemaBuilder()->hasTable('months')) {
            $this->monthOptions = DB::table('months')->orderBy('id')->get(['id', 'name']);
        } else {
            $this->monthOptions = collect();
        }
    }

    public function save(): void
    {
        $this->validate();

        $this->client->planned_audit_month_id = $this->form['planned_audit_month_id'] ?: null;
        $this->client->date_engaged           = $this->form['date_va_engaged'] ?: null;
        $this->client->next_audit             = $this->form['next_audit_date'] ?: null;
        $this->client->rating_agency_id       = $this->form['rating_agency_id'] ?: null;
        $this->client->rating_analyst_id      = $this->form['rating_analyst_id'] ?: null;
        $this->client->save();

        $this->savedMessage = 'Audit details updated.';
        $this->emit('refreshComponent');
    }

    public function render()
    {
        return view('livewire.audit-management.edit-audit-details');
    }
}
