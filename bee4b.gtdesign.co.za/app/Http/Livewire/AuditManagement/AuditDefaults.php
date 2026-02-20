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
    public $showNewCategoryModal = false;
    public $newTopLevelName = '';
    public $currentTopLevel = null;
    public $showRenameCategoryModal = false;
    public $renameFrom = '';
    public $renameTo = '';

    protected $rules = [
        'newAuditRef.name' => 'required',
        'newAuditFolder.name' => 'required',
    ];

    protected $listeners = [
        'refreshComponent'   => '$refresh',
        'open-folder-modal'  => 'openNewFolderModal',
        'quick-create-folder'=> 'quickCreateFolderDefaults',
        'delete-top-level'   => 'deleteTopLevel',
        'rename-top-level-quick' => 'renameTopLevelQuick',
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

    public function openNewFolderModal($topLevel)
    {
        $this->currentTopLevel = $topLevel ?: '';
        $this->showNewFolderModal = true;
        // reset folder model
        $this->newAuditFolder = AuditReferenceCategory::make();
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

        // attach to selected top-level
        if ($this->currentTopLevel !== null) {
            $this->newAuditFolder->top_level = $this->currentTopLevel;
        }

        $this->newAuditFolder->save();

        $this->newAuditFolder = \App\Models\AuditReferenceCategory::make();

        $this->resetErrorBag('newAuditFolder.name');
        $this->resetValidation();

        $this->showNewFolderModal = false;
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

        // Create a top-level by inserting a starter folder under it so it appears immediately
        $cat = new AuditReferenceCategory();
        $cat->top_level = $this->newTopLevelName;
        $cat->name = 'New Folder';
        $cat->is_active = 1;
        $cat->save();

        $this->showNewCategoryModal = false;
        $this->newTopLevelName = '';
        $this->emitSelf('refreshComponent');
    }

    /**
     * Prompt-less creation: create a folder directly under a top-level category.
     * Used by the JS prompt flow to avoid modal issues.
     */
    public function quickCreateFolderDefaults(string $topLevel, string $name): void
    {
        $topLevel = trim($topLevel);
        $name = trim($name);
        if ($topLevel === '' || $name === '') {
            return;
        }

        // Create the folder
        $folder = new AuditReferenceCategory();
        $folder->top_level = $topLevel;
        $folder->name = $name;
        $folder->is_active = 1;
        $folder->save();

        // Add a placeholder item so the folder is visible immediately
        $placeholder = new AuditReference();
        $placeholder->name = 'New Item';
        $placeholder->folder_id = $folder->id;
        $placeholder->default = 1; // defaults context: show as default by default
        $placeholder->is_active = 1;
        $placeholder->save();

        $this->dispatchBrowserEvent('notify-success', [
            'message' => 'Folder "' . e($name) . '" created under ' . e($topLevel),
        ]);

        $this->emitSelf('refreshComponent');
    }

    public function openRenameCategoryModal(string $topLevel): void
    {
        $this->renameFrom = $topLevel;
        $this->renameTo = $topLevel;
        $this->showRenameCategoryModal = true;
    }

    public function renameTopLevel(): void
    {
        $this->validate([
            'renameFrom' => 'required|string|min:1',
            'renameTo'   => 'required|string|min:2',
        ]);

        if ($this->renameFrom === $this->renameTo) {
            $this->showRenameCategoryModal = false;
            return;
        }

        AuditReferenceCategory::where('top_level', $this->renameFrom)
            ->update(['top_level' => $this->renameTo]);

        $this->dispatchBrowserEvent('notify-success', [
            'message' => 'Category renamed successfully',
        ]);

        $this->showRenameCategoryModal = false;
        $this->emitSelf('refreshComponent');
    }

    /**
     * Quick rename via JS prompt (no modal).
     */
    public function renameTopLevelQuick(string $from, string $to): void
    {
        $from = trim($from);
        $to = trim($to);
        if ($from === '' || $to === '' || $from === $to) {
            return;
        }

        AuditReferenceCategory::where('top_level', $from)
            ->update(['top_level' => $to]);

        $this->dispatchBrowserEvent('notify-success', [
            'message' => 'Category renamed successfully',
        ]);

        $this->emitSelf('refreshComponent');
    }

    public function deleteTopLevel(string $topLevel): void
    {
        if ($topLevel === '' || strtolower($topLevel) === 'uncategorized') {
            return; // do not delete the catch-all bucket
        }

        // Get all folder ids under this top-level
        $folders = AuditReferenceCategory::where('top_level', $topLevel)->pluck('id');

        if ($folders->isEmpty()) {
            return;
        }

        // Soft delete folders
        AuditReferenceCategory::whereIn('id', $folders)->update(['is_active' => 0]);
        // Soft delete items under those folders
        AuditReference::whereIn('folder_id', $folders)->update(['is_active' => 0]);

        $this->dispatchBrowserEvent('notify-success', [
            'message' => 'Category deleted. All folders and items under it are now hidden.',
        ]);

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
