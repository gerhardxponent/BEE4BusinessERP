<?php

namespace App\Http\Livewire\AuditManagement;

use App\Models\AuditReference;
use App\Models\AuditReferenceCategory;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class AuditDefaults extends Component
{
    // public $auditCategories;
    // public $user;
    public $newAuditRef;
    public $newAuditFolder;
    public $currentFolderID;
    public $showNewReferenceItemModal = false;
    public $showNewFolderModal = false;

    protected $rules = [
        'newAuditRef.name' => 'required',
        'newAuditFolder.name' => 'required',
    ];

    protected $listeners = [
        'refreshComponent' => '$refresh'
    ];

    public function mount()
    {
        $this->newAuditRef = AuditReference::make();
        $this->newAuditFolder = AuditReferenceCategory::make();

        // Fetch existing top-level categories for all categories
        $this->topLevelCategories = AuditReferenceCategory::pluck('top_level', 'id')->toArray();
    }

    public function render()
    {
        return view('livewire.audit-management.audit-defaults');
    }

    public function showCreateReferenceItemModal($id)
    {
        $this->currentFolderID = $id;
        $this->showNewReferenceItemModal = true;
    }

    public function createNewReferenceItem()
    {
        $this->validate([
            'newAuditRef.name' => 'required',
        ]);

        $newAuditRef = AuditReference::make();
        $newAuditRef->default = 1;
        $newAuditRef->name = $this->newAuditRef->name;
        $newAuditRef->folder_id = $this->currentFolderID;
        $newAuditRef->save();

        $this->showNewReferenceItemModal = false;
        $this->newAuditRef->name = null;
        $this->emitSelf('refreshComponent');
    }

    public function createNewFolder()
    {
        $this->validate([
            'newAuditFolder.name' => 'required'
        ]);

        $this->newAuditFolder->save();

        $this->newAuditFolder = \App\Models\AuditReferenceCategory::make();

        $this->resetErrorBag('newAuditFolder.name');
        $this->resetValidation();

        $this->showNewFolderModal = false;
        $this->emitSelf('refreshComponent');

    }

    public function updatedShowNewFolderModal($isOpen)
    {
        if ($isOpen) {
            // Reset the form model and validation whenever the modal is opened
            $this->newAuditFolder = \App\Models\AuditReferenceCategory::make();
            // Ensure it's blank
            $this->newAuditFolder->name = '';
            $this->resetErrorBag('newAuditFolder.name');
            $this->resetValidation();
        }
    }

    public function updateCategoryOrder($list)
    {
        foreach ($list as $index => $item) {
            AuditReferenceCategory::where('id', $item['value'])->update([
                'position' => $index + 1 // Ensuring a sequential order
            ]);
        }

        // Refresh Livewire component after update
        $this->emitSelf('refreshComponent');
    }

    public function updateTopLevelCategory($categoryId)
    {
        if (!isset($this->topLevelCategories[$categoryId])) {
            return;
        }

        // Find the category
        $category = AuditReferenceCategory::find($categoryId);

        if ($category) {
            $category->top_level = $this->topLevelCategories[$categoryId];
            $category->save();

            // Show a success message
            $this->dispatchBrowserEvent('notify-success', [
                'message' => 'Top-Level Category updated successfully!',
            ]);
        }
    }

    public $topLevelCategories = [];

    public $searchTerm = '';

    public function getAuditCategoriesProperty()
    {
        return collect(
            AuditReferenceCategory::query()
                ->where('is_active', 1)
                ->with([
                    'referenceItems' => function ($query) {
                        $query->where('audit_references.is_active', 1);
                    }
                ])
                ->orderBy('top_level') // Group by top-level category
                ->orderBy('position')
                ->get()
        )->map(function ($category) {
            // Filter reference items (files) inside each category
            $category->referenceItems = $category->referenceItems->filter(function ($item) {
                return str_contains(strtolower($item->name), strtolower($this->searchTerm));
            });

            return $category;
        })
            ->filter(function ($category) {
                // Show the category if:
                // - The category name matches
                // - The top-level category matches
                // - The category contains any filtered reference items
                return str_contains(strtolower($category->top_level), strtolower($this->searchTerm)) ||
                    str_contains(strtolower($category->name), strtolower($this->searchTerm)) ||
                    $category->referenceItems->isNotEmpty();
            })
            ->groupBy('top_level'); // Group categories by their master category
    }


    /** Soft-delete (hide) a default audit reference */
    public function hideReference(int $id): void
    {
        $ref = AuditReference::find($id);
        if (!$ref)
            return;

        $ref->is_active = 0;
        $ref->save();

        $this->dispatchBrowserEvent('notify-success', [
            'message' => 'Field hidden. It will no longer appear in Templates or when creating a new audit.',
        ]);

        $this->emitSelf('refreshComponent');
    }

    /**
     * Soft-delete (hide) a whole folder and all its items.
     */
    public function hideFolder(int $categoryId): void
    {
        $cat = AuditReferenceCategory::find($categoryId);
        if (!$cat)
            return;

        // Hide the folder
        $cat->is_active = 0;
        $cat->save();

        // Hide all items under it
        AuditReference::where('folder_id', $categoryId)->update(['is_active' => 0]);

        $this->dispatchBrowserEvent('notify-success', [
            'message' => 'Folder hidden. All items in this folder are now hidden too.',
        ]);

        $this->emitSelf('refreshComponent');
    }

}
