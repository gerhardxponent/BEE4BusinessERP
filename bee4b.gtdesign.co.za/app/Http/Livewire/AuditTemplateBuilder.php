<?php

namespace App\Http\Livewire;

use App\Models\AuditTemplate;
use App\Models\AuditReference;
use App\Models\AuditReferenceCategory;
use Livewire\Component;

class AuditTemplateBuilder extends Component
{
    public $templates;
    public $selectedTemplate = null;
    public $name = '';
    public $checked = [];               // was “selected” in create-audit
    public $newFolder;
    public $newAuditRef;
    public $showCreateNewFolderModal = false;
    public $showNewReferenceItemModal = false;
    public $currentFolderID;
    public $searchTerm = '';

    protected $rules = [
        'name'                 => 'required|string|max:255',
        'newFolder.name'       => 'required|string|min:1',
        'newAuditRef.name'     => 'required|string|min:1',
        'newAuditRef.default'  => 'nullable|boolean',
    ];

    public function mount()
    {
        // load existing templates for dropdown
        $this->templates   = AuditTemplate::orderBy('name')->get();
        $this->newFolder   = AuditReferenceCategory::make();
        $this->newAuditRef = AuditReference::make();
    }

    // when user picks a template, load its name + fields into our form
    public function updatedSelectedTemplate($templateId)
    {
        if ($templateId) {
            $template = AuditTemplate::with('fields')->find($templateId);
            $this->name    = $template->name;
            $this->checked = $template->fields
                                      ->pluck('id')
                                      ->mapWithKeys(fn($id)=>[$id=>true])
                                      ->toArray();
        } else {
            $this->name    = '';
            $this->checked = [];
        }
    }

    // save (create or update) template + its pivoted fields
    public function saveTemplate()
    {
        $this->validate(['name' => 'required|string|max:255']);

        $template = AuditTemplate::updateOrCreate(
            ['id'   => $this->selectedTemplate],
            ['name' => $this->name]
        );

        $template->fields()->sync(array_keys($this->checked));

        session()->flash('message', 'Template saved!');
        $this->templates        = AuditTemplate::orderBy('name')->get();
        $this->selectedTemplate = $template->id;

        // fire a custom event with a message payload
        $this->dispatchBrowserEvent('template-saved', [
        'message' => 'Template saved successfully!'
        ]);
    }

    public function render()
    {
        // same grouping/filter logic as your create-audit page
        $categories = AuditReferenceCategory::with('referenceItems')
            ->where('is_active', 1)
            ->orderBy('top_level')
            ->orderBy('position')
            ->get()
            ->groupBy('top_level')
            ->map(fn($cats, $topLevel) => $cats
                ->map(fn($cat) => tap($cat, fn($c) =>
                    $c->referenceItems = $c->referenceItems
                        ->filter(fn($item) =>
                            str_contains(strtolower($item->name), strtolower($this->searchTerm))
                        )
                ))
                ->filter(fn($cat) =>
                    str_contains(strtolower($cat->name), strtolower($this->searchTerm))
                    || $cat->referenceItems->isNotEmpty()
                )
            )
            ->filter(fn($cats) => $cats->isNotEmpty());

        return view('livewire.audit-management.audit-template-builder', [
            'categories' => $categories,
            'templates'  => $this->templates,
        ])->layoutData([
            'backText' => 'All Templates',
        ]);
    }

    // Bulk select / deselect
    public function selectAll()
    {
        $this->checked = AuditReference::pluck('id')
            ->mapWithKeys(fn($id)=>[$id=>true])
            ->toArray();
    }

    public function deselectAll()
    {
        $this->checked = [];
    }

    // Top-level grouping
    public function selectTopLevel($topLevel)
    {
        $ids = AuditReference::whereIn(
            'folder_id',
            AuditReferenceCategory::where('top_level', $topLevel)->pluck('id')
        )->pluck('id');

        foreach ($ids as $id) {
            $this->checked[$id] = true;
        }
    }

    public function deselectTopLevel($topLevel)
    {
        $ids = AuditReference::whereIn(
            'folder_id',
            AuditReferenceCategory::where('top_level', $topLevel)->pluck('id')
        )->pluck('id');

        foreach ($ids as $id) {
            unset($this->checked[$id]);
        }
    }

    // Per-category select/deselect
    public function selectCategory($categoryId)
    {
        $ids = AuditReference::where('folder_id', $categoryId)->pluck('id');
        foreach ($ids as $id) {
            $this->checked[$id] = true;
        }
    }

    public function deselectCategory($categoryId)
    {
        $ids = AuditReference::where('folder_id', $categoryId)->pluck('id');
        foreach ($ids as $id) {
            unset($this->checked[$id]);
        }
    }

    // “New Folder” modal
    public function setShowCreateNewFolderModal()
    {
        $this->newFolder               = AuditReferenceCategory::make();
        $this->showCreateNewFolderModal = true;
    }

    public function createFolder()
    {
        $this->validate(['newFolder.name' => 'required|string|min:1']);
        $this->newFolder->save();
        $this->showCreateNewFolderModal = false;
    }

    // “New Item” modal
    public function setShowNewReferenceItemModal($id)
    {
        $this->currentFolderID         = $id;
        $this->newAuditRef             = AuditReference::make();
        $this->showNewReferenceItemModal = true;
    }

    public function createNewReferenceItem()
    {
        $this->validate([
            'newAuditRef.name'    => 'required|string|min:1',
            'newAuditRef.default' => 'nullable|boolean',
        ]);

        $ref = new AuditReference();
        $ref->name      = $this->newAuditRef['name'];
        $ref->folder_id = $this->currentFolderID;
        $ref->default   = $this->newAuditRef['default'] ?? 0;
        $ref->save();

        $this->showNewReferenceItemModal = false;
        $this->emitSelf('refreshComponent');
    }
}
