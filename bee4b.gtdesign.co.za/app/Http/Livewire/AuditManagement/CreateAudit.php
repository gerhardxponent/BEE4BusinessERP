<?php

namespace App\Http\Livewire\AuditManagement;

use App\Models\Audit;
use App\Models\AuditFile;
use App\Models\AuditReference;
use App\Models\AuditReferenceCategory;
use App\Models\Clients;
use App\Models\Board;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use App\Models\AuditTemplate;

class CreateAudit extends Component
{
    public $audit;
    public $auditCategories;
    public $clients;
    public $projects;
    public $selected = [];
    public $selectedCategories = [];
    public $newFolder;
    public $newAuditRef;
    public $showCreateNewFolderModal = false;
    public $showNewCategoryModal = false;
    public $showNewReferenceItemModal = false;
    public $currentFolderID;
    public $currentTopLevel = null;
    public $newTopLevelName = '';
    protected $listeners = [
        'open-folder-modal' => 'openNewFolderModal',
    ];
    public $templates = [];
    public $selectedTemplate = null;


    protected $rules = [
        'audit.name' => 'required|regex:/^[^_^\/\\]*$/|unique:audits,name',
        'audit.client_id' => 'required',
        'audit.board_id' => 'nullable|exists:boards,id',

        'newFolder.name' => 'required',

        'newAuditRef.name' => 'required',
        'newAuditRef.default' => 'required',
    ];

    public function mount()
    {
        // $audits = Audit::query()
        //     ->whereHas('auditFiles', fn($query) => $query->whereBetween('due_date', [Carbon::now()->subDays(1), Carbon::now()->addDays(30)]))
        //     ->with('auditFiles', fn($query) => $query->whereBetween('due_date', [Carbon::now()->subDays(1), Carbon::now()->addDays(30)]))
        //     ->with('mailList')
        //     ->get();
        // dd($audits);

        //This month
        // dd($audits);

        //This week
        // dd($audits->where('due_date', '<=', Carbon::now()->addWeek()->toDateString()));

        //Tomorrow
        // dd($audits->where('due_date', Carbon::now()->addDay()->toDateString()));
        // dd($audits[0]->auditFiles->where('due_date', Carbon::now()->addDay()->toDateString()));

        $this->audit = Audit::make();
        $this->projects = collect();
        $this->auditCategories = AuditReferenceCategory::query()
            ->where('is_active', 1)
            ->with([
                'referenceItems' => function ($q) {
                    $q->where('default', 1);
                }
            ])
            ->get();

        $this->selected = \App\Models\AuditReference::query()
            ->whereHas('folder', fn($q) => $q->where('is_active', 1))
            ->pluck('id')
            ->map(fn($id) => (int) $id)
            ->all();

        $this->clients = \App\Models\Clients::query()
            ->orderBy('name')
            ->get();
        $this->newFolder = AuditReferenceCategory::make();
        $this->newReferenceItem = AuditReference::make();
        $this->templates = AuditTemplate::orderBy('name')->get();
    }

    public function updatedAuditClientId($clientId)
    {
        $this->projects = collect();
        $this->audit->board_id = null;

        if (!$clientId) {
            return;
        }

        $this->projects = Board::query()
            ->where('boardable_type', 'App\\Models\\Clients') // Add this line
            ->where('boardable_id', $clientId) // Change from client_id to boardable_id
            ->orderBy('name')
            ->get();

        if ($this->projects->isEmpty()) {
            $this->projects = collect();
        }
    }

    public function render()
    {
        return view('livewire.audit-management.create-audit', [
            'templates' => $this->templates,
        ])->layoutData([
                    'backText' => 'all Audits'
                ]);
    }

    public function createAudit()
    {
        $this->validate([
            'audit.name' => 'required|regex:/^[^_\/\\\\]*$/|unique:audits,name',
            'audit.client_id' => 'required',
            'audit.board_id' => 'nullable|exists:boards,id'
        ], [
            'audit.name.regex' => 'The name cannot contain slashes or underscores.',
            'audit.client_id.required' => 'Please select a client.'
        ]);

        if ($this->selected === []) {
            return;
        }

        $availableProjects = $this->projects instanceof \Illuminate\Support\Collection
            ? $this->projects
            : collect($this->projects);

        if ($availableProjects->isNotEmpty() && empty($this->audit->board_id)) {
            $this->addError('audit.board_id', 'Please select a project for this client.');
            return;
        }

        $this->audit->user_id = Auth::id();

        $this->audit->save();
        $this->audit->audit_references()->sync($this->selected);

        // For each selected audit reference, create an entry in audit_files
        foreach ($this->selected as $auditReferenceId) {
            $auditFile = new \App\Models\AuditFile();
            $auditFile->audit_reference_id = $auditReferenceId;
            $auditFile->audit_id = $this->audit->id;
            $auditFile->status = 3;
            $auditFile->save();
        }

        return redirect()->to('audits/' . $this->audit->id);
    }

    public function selectFolder($id)
    {
        $new = AuditReference::where([
            ['folder_id', $id],
            ['default', 1]
        ])
            ->pluck('id')->toArray();

        if (in_array($id, $this->selectedCategories)) {
            $this->selected = array_diff($this->selected, $new);
            $this->selectedCategories = array_diff($this->selectedCategories, array($id));
        } else {
            $this->selected = array_merge($this->selected, $new);
            array_push($this->selectedCategories, $id);
        }
    }

    public function itemClicked($id)
    {
        if (in_array($id, $this->selected)) {
            $this->selected = array_diff($this->selected, array($id));
        } else {
            array_push($this->selected, $id);
        }
    }

    public function setShowCreateNewFolderModal()
    {
        $this->newFolder = AuditReferenceCategory::make();
        $this->showCreateNewFolderModal = true;
    }

    public function openNewFolderModal(string $topLevel = ''): void
    {
        $this->currentTopLevel = $topLevel;
        $this->newFolder = AuditReferenceCategory::make();
        $this->showCreateNewFolderModal = true;
    }

    public function openNewFolderByCategory(int $categoryId): void
    {
        $cat = AuditReferenceCategory::find($categoryId);
        $this->currentTopLevel = $cat?->top_level ?? '';
        $this->newFolder = AuditReferenceCategory::make();
        $this->showCreateNewFolderModal = true;
    }

    public function createFolder()
    {
        if ($this->currentTopLevel) {
            $this->newFolder->top_level = $this->currentTopLevel;
        }
        $this->newFolder->save();
        $this->showCreateNewFolderModal = false;

        // Create a placeholder item so the new folder is visible immediately
        try {
            $placeholder = new AuditReference();
            $placeholder->name = 'New Item';
            $placeholder->folder_id = $this->newFolder->id;
            // mark as default so it is visible in the selector immediately
            $placeholder->default = 1;
            $placeholder->is_active = 1;
            $placeholder->save();

            // ensure it will be included when creating the audit
            $current = array_map('intval', $this->selected ?? []);
            $current[] = (int) $placeholder->id;
            $this->selected = array_values(array_unique($current));
        } catch (\Throwable $e) {
            // fail silently; folder will still exist
        }

        $this->emitSelf('refreshComponent');
    }

    public function openNewCategoryModal()
    {
        $this->newTopLevelName = '';
        $this->showNewCategoryModal = true;
    }

    public function createTopLevelCategory()
    {
        $this->validate([
            'newTopLevelName' => 'required|string|min:2',
        ]);

        $cat = new AuditReferenceCategory();
        $cat->top_level = $this->newTopLevelName;
        $cat->name = 'New Folder';
        $cat->is_active = 1;
        $cat->save();

        $this->showNewCategoryModal = false;
        $this->newTopLevelName = '';
        $this->emitSelf('refreshComponent');
    }

    public function setShowNewReferenceItemModal($id)
    {
        $this->currentFolderID = $id;
        $this->newAuditRef = AuditReference::make();
        $this->showNewReferenceItemModal = true;
    }

    public function createNewReferenceItem()
    {
        // Validate input
        $this->validate([
            'newAuditRef.name' => 'required|string|min:3',
            'newAuditRef.default' => 'nullable|boolean',
        ]);

        // Create a new Audit Reference
        $newAudit = new AuditReference();
        $newAudit->name = $this->newAuditRef['name']; // ✅ Use modal input
        $newAudit->folder_id = $this->currentFolderID;
        $newAudit->audit_id = $this->audit->id;
        $newAudit->default = $this->newAuditRef['default'] ?? 0; // Default to 0 if not set
        $newAudit->save();

        // Reset modal inputs
        $this->newAuditRef = AuditReference::make();

        // Hide the modal
        $this->showNewReferenceItemModal = false;

        // Refresh component
        $this->emitSelf('refreshComponent');
    }

    public $searchTerm = '';

    public function getAuditDataProperty()
    {
        return AuditReferenceCategory::query()
            ->where('is_active', 1)
            ->with(['referenceItems'])
            ->orderBy('top_level')
            ->orderBy('position')
            ->get()
            ->groupBy('top_level') // Group categories by top-level
            ->map(function ($categories, $topLevel) {
                // Filter categories & reference items
                $filteredCategories = $categories->map(function ($category) {
                    $category->referenceItems = $category->referenceItems->filter(function ($item) {
                        return str_contains(strtolower($item->name), strtolower($this->searchTerm));
                    });

                    return $category;
                })->filter(function ($category) {
                    return str_contains(strtolower($category->name), strtolower($this->searchTerm)) ||
                        $category->referenceItems->isNotEmpty();
                });

                return $filteredCategories;
            })
            ->filter(function ($categories) {
                return $categories->isNotEmpty(); // Remove empty top-level categories
            });
    }

    public function selectAll()
    {
        $ids = $this->getAllVisibleItemIds();
        $current = array_map('intval', $this->selected ?? []);
        $this->selected = array_values(array_unique(array_merge($current, $ids)));
    }

    public function deselectAll()
    {
        $this->selected = [];
    }

    public function selectTopLevel($topLevel)
    {
        $ids = $this->getTopLevelItemIds($topLevel);
        $current = array_map('intval', $this->selected ?? []);
        $this->selected = array_values(array_unique(array_merge($current, $ids)));
    }

    public function deselectTopLevel($topLevel)
    {
        $ids = $this->getTopLevelItemIds($topLevel);
        $current = array_map('intval', $this->selected ?? []);
        $this->selected = array_values(array_diff($current, $ids));
    }

    public function selectCategory($categoryId)
    {
        $ids = $this->getCategoryItemIds((int) $categoryId);
        $current = array_map('intval', $this->selected ?? []);
        $this->selected = array_values(array_unique(array_merge($current, $ids)));
    }

    public function deselectCategory($categoryId)
    {
        $ids = $this->getCategoryItemIds((int) $categoryId);
        $current = array_map('intval', $this->selected ?? []);
        $this->selected = array_values(array_diff($current, $ids));
    }

    public function updatedSelectedTemplate($templateId)
    {
        if ($templateId) {
            $template = AuditTemplate::with('fields')->find($templateId);
            $this->selected = $template
                ? $template->fields->pluck('id')->toArray()
                : [];
        } else {
            // If they clear the dropdown, deselect everything (or
            // optionally reload your defaults: AuditReference::where('default',1)->pluck('id')->toArray())
            $this->selected = [];
        }
    }

    private function getCategoryItemIds(int $categoryId): array
    {
        return \App\Models\AuditReference::query()
            ->where('folder_id', $categoryId)
            ->where(function ($q) {
                // hide soft-removed fields if you use a flag like `is_hidden`
                $q->whereNull('is_active')->orWhere('is_active', 1);
            })
            ->pluck('id')
            ->map(fn($id) => (int) $id)
            ->all();
    }

    private function getTopLevelItemIds(?string $topLevel): array
    {
        // Treat empty string from blade (“{{ $topLevel }}”) as NULL top-level
        $resolved = ($topLevel === '' ? null : $topLevel);

        $categoryIds = \App\Models\AuditReferenceCategory::query()
            ->when(
                is_null($resolved),
                fn($q) => $q->whereNull('top_level'),
                fn($q) => $q->where('top_level', $resolved)
            )
            ->pluck('id');

        return \App\Models\AuditReference::query()
            ->whereIn('folder_id', $categoryIds)
            ->where(function ($q) {
                $q->whereNull('is_active')->orWhere('is_active', 1);
            })
            ->pluck('id')
            ->map(fn($id) => (int) $id)
            ->all();
    }

    private function getAllVisibleItemIds(): array
    {
        return \App\Models\AuditReference::query()
            ->whereHas('folder', fn($q) => $q->where('is_active', 1))
            ->pluck('id')
            ->map(fn($id) => (int) $id)
            ->all();
    }
}
