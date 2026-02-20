<?php

namespace App\Http\Livewire\Settings;

use Livewire\Component;
use App\Models\AuditReference;
use App\Models\AuditReferenceCategory;

class AuditFields extends Component
{
    public $showInactive = false;
    public $search = '';

    protected $listeners = ['refreshComponent' => '$refresh'];

    public function render()
    {
        return view('livewire.settings.audit-fields', [
            'folders' => $this->folders,
            'grouped' => $this->groupedFields,
        ]);
    }

    public function getFoldersProperty()
    {
        return AuditReferenceCategory::orderBy('top_level')->orderBy('position')->get();
    }

    public function getGroupedFieldsProperty()
    {
        $q = AuditReference::query()
            ->with('folder')
            ->when(!$this->showInactive, fn($qq) => $qq->where('is_active', 1))
            ->when($this->search, function ($qq) {
                $s = trim($this->search);
                $qq->where('name', 'like', "%{$s}%");
            })
            ->orderBy('folder_id')
            ->orderBy('position');

        return $q->get()->groupBy('folder_id');
    }

    public function deactivateField(int $id): void
    {
        if ($ref = AuditReference::find($id)) {
            $ref->is_active = 0;
            $ref->save();
            $this->dispatchBrowserEvent('notify-success', ['message' => 'Field hidden. It will no longer appear in Templates or New Audit.']);
            $this->emitSelf('refreshComponent');
        }
    }

    public function activateField(int $id): void
    {
        if ($ref = AuditReference::find($id)) {
            $ref->is_active = 1;
            $ref->save();
            $this->dispatchBrowserEvent('notify-success', ['message' => 'Field restored.']);
            $this->emitSelf('refreshComponent');
        }
    }
}
