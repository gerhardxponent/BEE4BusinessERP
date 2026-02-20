<?php

namespace App\Http\Livewire\AuditManagement\Components;

use App\Exports\AuditExport;
use App\Models\Activity;
use App\Models\Audit;
use App\Models\AuditFile;
use App\Models\AuditReference;
use App\Models\AuditReferenceCategory;
use App\Models\File;
use App\Models\User;
use App\Models\Clients;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Mail;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Mail\AuditSummaryReport;
use App\Mail\AuditFinalThankYouMail;
use Illuminate\Support\Facades\DB;
use App\Mail\AuditUploadReminder;
use Illuminate\Support\Str;


class AuditSection extends Component
{
    use WithFileUploads;

    public $audit;
    public $auditReferences;
    public $auditFolders;
    public $file;
    public $replacingFile;
    public $newFile; //for replacement
    public $activeItem;
    public $showFileUploadModal = false;
    public $showReplaceFileUploadModal = false;
    public $showNewRefItemModal = false;
    public $showNewCategoryModal = false;
    public $showConfirmDeleteFileModal = false;
    public $showCommentsModal = false;
    public $showConfirmRemoveRefModal = false;
    public $showFileReplaceError = false;
    public $currentReferenceID;
    public $auditID;
    public $newRefItem;
    public $newCategory;
    public $searchString = '';
    public $exclude = [];
    public $deletingFileID;
    public $isReplacingFile = false;
    public $user;
    public $tabs = ['new item', 'existing item'];
    public $currentTab = 'new item';
    public $addingItems = [];
    public $filterUser = '';
    public $filterStatus = '';
    public $filterDate = '';

    public $folderID;

    public $activeFile;

    public $deletingRef;
    public $existing;

    public $uploadingItemId = null; // Stores the item ID being uploaded
    public $uploadFile = null; // Stores the uploaded file
    public $uploadFiles = [];
    public $pendingBulkDueDate;
    public $pendingBulkDateRequested;
    public $pendingFolderId;
    public $pendingRefIds = [];
    public $fileID; // Add this at the top

    // Modal: view files for a reference item
    public $showFilesModal = false;
    public $modalFiles = [];
    public $modalRefTitle = '';
    public $modalRefId = null;

    protected function matchesStatusFilter($ref): bool
    {
        $file = $ref->files->first();
        $fs = $this->filterStatus;

        if ($fs === '' || $fs === null)
            return true;

        // waiting: no file yet (or placeholder file row)
        if ($fs === '0:waiting') {
            return !$file || $file->file_id === null;
        }

        // pending: there is a file with status 0
        if ($fs === '0:pending') {
            return $file && (int) $file->status === 0;
        }

        // normal codes
        if (in_array($fs, ['1', '2'], true)) {
            return $file && (int) $file->status === (int) $fs;
        }

        // fallback: treat bare "0" as pending-with-file
        if ($fs === '0') {
            return $file && (int) $file->status === 0;
        }

        return true;
    }

    protected $rules = [
        'newRefItem.name' => 'required',
        'newRefItem.default' => 'required',
        'newCategory.top_level' => 'required|string|min:2',
        'newCategory.name' => 'required',
        'uploadFiles.*' => 'file|max:15240', // max 15MB per file
    ];

    protected function getListeners()
    {
        $nameChange = '\\App\\Models\\Audit-' . $this->audit->id . '-name';

        return [
            'refreshComponent' => '$refresh',
            'newCategory',
            $nameChange => 'nameChange'
        ];
    }

    public function nameChange($newName)
    {
        $this->newActivity(
            'has renamed this audit to <span class="font-bold">' . $newName . '</span>',
            '',
            'update'
        );
    }

    public function newCategory()
    {
        $this->showNewCategoryModal = true;
    }

    public function openNewFolderModalTop(string $topLevel = ''): void
    {
        $this->newCategory = AuditReferenceCategory::make();
        $this->newCategory->top_level = $topLevel;
        $this->showNewCategoryModal = true;
    }

    /**
     * Ultra-reliable path: create a folder immediately without showing a modal.
     * Called from JS with raw strings to avoid directive parsing issues.
     */
    public function quickCreateFolder(string $topLevel, string $name): void
    {
        $topLevel = trim($topLevel);
        $name = trim($name);
        if ($topLevel === '' || $name === '') {
            return;
        }

        // Create folder
        $folder = new AuditReferenceCategory();
        $folder->top_level = $topLevel;
        $folder->name = $name;
        $folder->is_active = 1;
        $folder->save();

        // Add placeholder item so it renders immediately
        $placeholder = new AuditReference();
        $placeholder->name = 'New Item';
        $placeholder->folder_id = $folder->id;
        $placeholder->default = 0;
        $placeholder->is_active = 1;
        $placeholder->save();

        // Attach to this audit so it appears under details right away
        if ($this->audit && $this->audit->exists) {
            $this->audit->audit_references()->attach($placeholder->id);

            $af = new AuditFile();
            $af->audit_reference_id = $placeholder->id;
            $af->audit_id = $this->audit->id;
            $af->status = 0;
            $af->save();
        }

        $this->dispatchBrowserEvent('notify-success', [
            'message' => 'Folder "' . e($name) . '" created in ' . e($topLevel),
        ]);

        $this->emitSelf('refreshComponent');
    }

    public function openFile()
    {
        // dd('hello');
        // return response()->file(storage_path('app/uploads/Amazon/Certificate.txt'));
    }

    public $contactEmails;

    public function mount($id)
    {
        $this->auditID = $id;
        $this->audit = Audit::find($id);
        $this->user = User::find(Auth::id());
        $this->currentReferenceID = -10;
        $this->newRefItem = AuditReference::make();
        $this->newCategory = AuditReferenceCategory::make();
        $this->activeFile = AuditFile::make();
        $this->deletingRef = AuditReference::make();
        $this->existing = $this->audit->audit_references->pluck('id'); // Get all reference items fot current audit.

        $this->contactEmails = $this->audit->client()->withTrashed()->first()->contactsMorph->pluck('email');
    }

    /**
     * Get all reference items in a given category
     * not already in the current audit.
     * 
     * @return \Illuminate\Support\Collection
     */
    public function getSpecificItemsProperty()
    {
        // Get all reference items not already added to current audit
        return AuditReference::query()
            ->whereNotIn('id', $this->existing)
            ->where('folder_id', $this->folderID)
            ->where('default', 1)
            ->get();
    }

    /**
     * Get all audit categories as well as audit files associated 
     * with it and current audit.
     * 
     * @return \Illuminate\Support\Collection
     */
    public function getDataProperty()
    {
        $user = auth()->user(); // Get the logged-in user

        return AuditReferenceCategory::query()
            ->with([
                'referenceItems' => function ($query) use ($user) {
                    $query
                        // Only get reference items associated with the current audit
                        ->whereHas('audits', function ($query) {
                            $query->where('audit_has_audit_refs.audit_id', $this->audit->id);
                        })
                        // For reference items unique to this audit
                        ->where(function ($query) {
                            $query->where('audit_references.audit_id', $this->auditID)
                                ->orWhere('audit_references.audit_id', null);
                        })
                        // Apply additional filter if the user is a Client Sub User
                        ->when(
                            $user->hasRole('Client Sub User'),
                            function ($query) use ($user) {
                                $query->whereHas('files', function ($query) use ($user) {
                                    $query->where('responsible_person_id', $user->id);
                                });
                            }
                        );
                },
                // Get only files associated with this audit
                'referenceItems.files' => fn($query) => $query
                    ->where('audit_files.audit_id', $this->auditID)
                    ->withCount('comments'),
                'referenceItems.files.checkedByUser',
                'referenceItems.files.fileDetails.user'
            ])
            // Filter out categories that have no reference items
            ->when(
                $user->hasRole('Client Sub User'),
                function ($query) use ($user) {
                    $query->whereHas('referenceItems', function ($query) use ($user) {
                        $query->whereHas('files', function ($query) use ($user) {
                            $query->where('audit_files.audit_id', $this->audit->id)
                                ->where('responsible_person_id', $user->id);
                        });
                    });
                }
            )
            ->orderBy('position')
            ->get();
    }

    public function toggleFileUploadModal($refID)
    {
        $this->uploadingItemId = ($this->uploadingItemId === $refID) ? null : $refID;
    }

    public function render()
    {
        return view('livewire.audit-management.components.audit-section');
    }

    public function openFilesModal($refId)
    {
        $this->modalRefId = $refId;

        $ref = AuditReference::find($refId);
        if (!$ref) {
            $this->modalFiles = [];
            $this->modalRefTitle = '';
            $this->showFilesModal = true;
            return;
        }

        $this->modalRefTitle = $ref->name;

        // Collect valid files (with physical file attached) for this audit and reference
        $files = $ref->files()
            ->where('audit_files.audit_id', $this->audit->id)
            ->withCount('comments')
            ->with(['fileDetails.user', 'checkedByUser'])
            ->get()
            ->filter(function ($f) {
                return $f->file_id !== null && $f->fileDetails !== null;
            })
            ->values();

        $this->modalFiles = $files->toArray();
        $this->showFilesModal = true;
    }

    public function closeFilesModal()
    {
        $this->showFilesModal = false;
        $this->modalFiles = [];
        $this->modalRefTitle = '';
        $this->modalRefId = null;
    }

    public function upload()
    {
        if ($this->file == null)
            return;

        if ($this->isReplacingFile) {
            $this->removeFile();
        }

        $auditRef = AuditReference::find($this->currentReferenceID);

        $fileDetails = File::make();
        $fileDetails->client_id = $this->audit->client_id;
        $fileDetails->user_id = Auth::id();
        $fileDetails->file_name = $auditRef->name;
        $fileDetails->type = $this->file->getClientOriginalExtension();
        if (
            File::where('file_name', '=', $fileDetails->file_name)
                ->where('client_id', $this->audit->client_id)
                ->exists()
        ) {
            $fileDetails->file_name = 'copy_' . $fileDetails->file_name . '_' . date('d-m-y_h-i');
        }
        $fileDetails->file_path =
            'uploads/' .
            preg_replace('/\s+/', '_', $this->audit->client->name) .
            '/audits/' .
            $this->audit->name .
            '/' .
            $auditRef->folder->name;

        $this->audit->files()->save($fileDetails);

        $auditFile = AuditFile::firstOrNew(
            ['audit_reference_id' => $this->currentReferenceID],
            ['audit_id' => $this->audit->id]
        );
        $auditFile->file_id = $fileDetails->id;
        $auditFile->audit_reference_id = $this->currentReferenceID;
        $auditFile->audit_id = $this->audit->id;
        $auditFile->date_uploaded = Carbon::now();

        $auditFile->save();

        $this->file->storeAs(
            'uploads/' .
            preg_replace('/\s+/', '_', $this->audit->client->name) .
            '/audits/' .
            $this->audit->name .
            '/' .
            $auditRef->folder->name,
            $fileDetails->file_name . '.' . $this->file->getClientOriginalExtension()
        );

        $this->showFileUploadModal = false;

        $this->newActivity(
            'has uploaded a file',
            "File uploaded to {$auditRef->folder->name} / {$auditRef->name}",
            'file upload'
        );

        $this->file = null;
        $this->emit('all_files_uploaded');
        session()->flash('message', 'File uploaded successful');
    }

    /**
     * Download file and set checked date
     * 
     * @return void
     */
    public function download($auditFileID)
    {
        //Find file to be updated
        $file = AuditFile::find($auditFileID)->fileDetails;

        //Update date last cheked and by who
        $this->setCheckedDate($auditFileID);

        // Construct the original file path
        $originalPath = $file->file_path . '/' . $file->file_name . '.' . $file->type;

        // Extract "Aeroklas_Duys" from file_path, assuming it always is the second segment
        $pathParts = explode('/', $file->file_path);
        $prefix = isset($pathParts[1]) ? $pathParts[1] : 'default';
        $fold = isset($pathParts[4]) ? $pathParts[4] : 'default';

        // Build the custom file name as "Aeroklas_Duys_Audit_<original_file_name>.<file_type>"
        $customFileName = $prefix . '_Audit_' . $fold . '_' . $file->file_name . '.' . $file->type;

        // Download the file from storage with a custom file name
        return Storage::download($originalPath, $customFileName);
    }

    public function showDetails($refID)
    {
        $this->activeItem = AuditReference::find($refID);
        $this->showDetailsModal = true;
    }

    // public function saveFile($id)
    // {
    //     AuditFile::find($id)->save();
    // }

    public function setNewRefItem($categoryID)
    {
        $this->folderID = $categoryID;
        // dd($this->newRefItem);
        $this->showNewRefItemModal = true;
    }

    /**
     * Create a new reference item and 
     * attach it to this audit only
     * 
     * @return void
     */
    public function createRefItem()
    {
        // Ensure a valid folder ID
        if (!$this->folderID) {
            session()->flash('message', 'Error: Folder ID is missing.');
            return;
        }

        // Validate inputs before saving
        $this->validate([
            'newRefItem.name' => 'required|string',
            'newRefItem.default' => 'nullable|boolean',
        ]);

        // Create a new AuditReference instance manually to ensure all fields are set
        $newRefItem = new AuditReference();
        $newRefItem->folder_id = $this->folderID;
        $newRefItem->audit_id = $this->audit->id;
        $newRefItem->name = $this->newRefItem['name']; // Explicitly set name
        $newRefItem->default = $this->newRefItem['default'] ?? 0;

        // Save the new reference item
        $newRefItem->save();

        // Attach the reference item to the audit
        $this->audit->audit_references()->attach($newRefItem);

        // Set the requested date to today's date
        $this->setDate([
            'date_requested' => Carbon::now()->format('Y-m-d')
        ], $newRefItem->id);

        // Reset the form
        $this->newRefItem = AuditReference::make();

        // Close the modal
        $this->showNewRefItemModal = false;

        // Show success message
        session()->flash('message', 'New reference item created successfully.');
    }


    // Creates new folder
    public function createNewCategory()
    {
        $this->newCategory->save();
        // Ensure the newly created folder is visible by adding a placeholder item
        try {
            $placeholder = new AuditReference();
            $placeholder->name = 'New Item';
            $placeholder->folder_id = $this->newCategory->id;
            $placeholder->default = 0;
            $placeholder->is_active = 1;
            $placeholder->save();

            // Attach the new item to this audit so it appears immediately
            if ($this->audit && $this->audit->exists) {
                $this->audit->audit_references()->attach($placeholder->id);

                // Create a placeholder audit_files row for summary counts (file_id null => empty)
                $af = new AuditFile();
                $af->audit_reference_id = $placeholder->id;
                $af->audit_id = $this->audit->id;
                $af->status = 0; // pending/empty
                $af->save();
            }
        } catch (\Throwable $e) {
            // ignore
        }
        $this->showNewCategoryModal = false;
        session()->flash('message', 'New folder created');
    }

    public function setRemoveFile($fileID)
    {
        if ($this->userCannotDelete()) {
            $this->dispatchBrowserEvent('notify-error', ['message' => 'You do not have permission to delete documents.']);
            return;
        }
        $this->deletingFileID = $fileID;
        $this->showConfirmDeleteFileModal = $fileID;
    }

    public function removeFile()
    {
        if ($this->userCannotDelete()) {
            $this->dispatchBrowserEvent('notify-error', ['message' => 'You do not have permission to delete documents.']);
            return;
        }

        $file = File::find($this->deletingFileID);
        if (!$file) {
            $this->dispatchBrowserEvent('notify-error', ['message' => 'File not found.']);
            return;
        }

        $name = $file->file_name;
        $path = rtrim($file->file_path, '/') . '/' . $file->file_name . '.' . $file->type;

        \DB::transaction(function () use ($file, $path) {

            // 1) Unlink the file from any audit_files rows FIRST to avoid FK cascade deletes
            //    We also reset status to 3 = "not yet uploaded / empty" (your app uses 0=pending,1=accepted,2=rejected,3=empty)
            \App\Models\AuditFile::where('file_id', $file->id)
                ->update([
                    'file_id' => null,     // break the FK link
                    'status' => 3,        // back to "not yet uploaded"
                    'date_uploaded' => null,
                    'checked_by' => null,
                    'updated_at' => now(),
                ]);

            // 2) Delete the physical file (if present)
            if (\Storage::exists($path)) {
                \Storage::delete($path);
            }

            // 3) Delete the files row itself
            $file->delete();
        });

        $this->showConfirmDeleteFileModal = false;

        $this->newActivity(
            'has deleted a file',
            '<span class="font-bold">' . e($name) . '</span> has been deleted',
            'delete'
        );

        // If you need UI to refresh:
        // $this->emitSelf('$refresh');
        // $this->dispatchBrowserEvent('hard-refresh-to', [...]);
    }


    /**
     * Set the date the file was last checked, and by who
     * 
     * @return void
     */
    public function setCheckedDate($auditFileID)
    {
        //Find file to be updated
        $auditFile = AuditFile::find($auditFileID);

        //Update date
        $auditFile->date_last_checked = Carbon::now();

        //Update user
        $auditFile->checked_by = Auth::id();

        //Save to database
        $auditFile->save();
    }

    /**
     * Change the status of an audit file.
     *
     * @return void
     */
    public function setStatus($auditFileID)
    {
        //Meanings of possible audit file statuses
        // 0 = pending, 1 = accepted, 2 = rejected

        //Get audit file from database
        $auditFile = AuditFile::find($auditFileID);

        //Set appropriate status based on current status
        switch ($auditFile->status) {
            case 0:
                $auditFile->status = 1;
                break;
            case 1:
                $auditFile->status = 2;
                break;
            case 2:
                $auditFile->status = 0;
                break;
            default:
                $auditFile->status = 0;
        }

        //Save status
        $auditFile->save();
    }

    public function newActivity($title, $body, $type)
    {
        $activity = Activity::make();

        $activity->user_id = Auth::id();
        $activity->title = ' ' . $title;
        $activity->body = $body;
        $activity->activity_type = $type;
        $activity->path = 'Audits / ' . $this->audit->client->name . ' / ' . $this->audit->created_at->format('Y-m-d');
        $this->audit->activities()->save($activity);
    }

    public function cancelAddItems()
    {
        $this->addingItems = [];
        $this->showNewRefItemModal = false;
    }

    /**
     * Add existing line items to audit category
     * 
     * @return void
     */
    public function addExistingItems()
    {
        if ($this->addingItems === [])
            return;

        $this->audit->audit_references()->attach($this->addingItems);

        foreach ($this->addingItems as $item) {
            $this->setDate([
                'date_requested' => Carbon::now()->format('Y-m-d')
            ], $item);
        }

        $this->showNewRefItemModal = false;
        $this->addingItems = [];
    }

    public function showFileComments($auditFileID)
    {
        $this->emit('updateEntity', $auditFileID);

        $this->showCommentsModal = true;
    }

    public function export()
    {
        $auditDetails = [
            'name' => $this->audit->name,
            'client' => $this->audit->client->name
        ];

        return Excel::download(new AuditExport($this->data, $auditDetails), $this->audit->name . '.xlsx');
    }

    public function storeExcel()
    {
        $auditDetails = [
            'name' => $this->audit->name,
            'client' => $this->audit->client->name
        ];

        $fileName = $this->audit->name . '--' . Carbon::now()->format('Y-m-d');

        $filePath = 'uploads/' . $this->audit->client->name . '/audits/' . $this->audit->name . '/Backups/';

        Excel::store(new AuditExport($this->data, $auditDetails), $filePath . $fileName . '.xlsx');

        $fileSize = 0;
        Storage::exists($filePath . $fileName) ?? $fileSize = Storage::size($filePath . $fileName) / 1024;

        $file = new File([
            'user_id' => Auth::id(),
            'file_name' => $fileName,
            'file_path' => $filePath,
            'type' => 'xlsx',
            'file_size' => $fileSize,
            'isBackup' => 1
        ]);

        $this->audit->files()->save($file);

        return $file;
        // $this->emit("showOutlookEmailModal", Array($file));
    }

    public function emailExcel()
    {
        $file = $this->storeExcel();
        $this->emit("showOutlookEmailModal", array($file));
    }

    public function setDate($formData, $refID)
    {
        $auditFile = AuditFile::make();

        $auditFile->file_id = null;
        $auditFile->audit_reference_id = $refID;
        foreach ($formData as $key => $value) {
            if ($value === '')
                return;

            $auditFile->$key = $value;
            if ($key === 'date_requested') {
                $auditFile->due_date = Carbon::parse($value)->addDays(30);
            }
        }

        $auditFile->audit_id = $this->audit->id;
        $auditFile->save();

        // Check if there are other unassigned files in the same section
        $sectionId = AuditReference::find($refID)->folder_id;

        $otherRefs = AuditReference::where('folder_id', $sectionId)
            ->where('id', '!=', $refID)
            ->pluck('id')
            ->toArray();

        $otherUnassigned = AuditFile::whereIn('audit_reference_id', $otherRefs)
            ->whereNull('date_requested')
            ->get();

        if ($otherUnassigned->count()) {
            $this->dispatchBrowserEvent('confirm-apply-dates', [
                'refIDs' => $otherUnassigned->pluck('id')->toArray(),
                'date_requested' => $auditFile->date_requested,
                'due_date' => $auditFile->due_date,
            ]);
        }

        $this->newActivity(
            'has updated a field',
            'Due Date set for ' . AuditReference::find($refID)->name,
            'update'
        );
    }


    public function toggleConfirmRemoveModal($refID)
    {
        if ($this->userCannotDelete()) {
            $this->dispatchBrowserEvent('notify-error', ['message' => 'You do not have permission to remove line items.']);
            return;
        }
        $this->deletingRef = AuditReference::find($refID);
        $this->showConfirmRemoveRefModal = true;
    }

    /**
     * Removes a specific audit reference item from 
     * current audit.
     * 
     * @return void
     */
    public function deleteReference()
    {
        if ($this->userCannotDelete()) {
            $this->dispatchBrowserEvent('notify-error', ['message' => 'You do not have permission to remove line items.']);
            return;
        }

        // Detatch reference item from audit
        $this->audit->audit_references()->detach($this->deletingRef);
        // Find audit file (for when no file is uploaded but date requested or due date is set)
        $deletingFile = $this->audit->auditFiles->where('audit_reference_id', $this->deletingRef->id)->first();
        // If audit file is set, delete it
        if (isset($deletingFile))
            $deletingFile->delete();

        // If removing an existing reference item from audit
        $message = 'Reference item successfully removed';

        // If removing reference item specific to this audit
        if ($this->deletingRef->default === 0) {
            $this->deletingRef->delete();
            $message = 'Reference item successfully deleted';
        }

        // Hide modal
        $this->showConfirmRemoveRefModal = false;

        // Display toast message
        $this->dispatchBrowserEvent('notify-success', ['message' => $message]);
    }

    public function toggleReplaceFileModal($id)
    {
        $this->replacingFile = AuditFile::find($id);
        $this->showReplaceFileUploadModal = true;
    }

    /**
     * Replace an existing file
     * 
     * @return void
     */
    public function replaceFile()
    {
        //Get File model object from audit file 
        $replacingFileDetails = $this->replacingFile->fileDetails;

        //Full storage path of existing file
        $fullPath =
            $replacingFileDetails->file_path .
            '/' .
            $replacingFileDetails->file_name .
            '.' .
            $replacingFileDetails->type;

        //Check if file to be replaced exists in storage
        if (Storage::exists($fullPath)) {
            //delete existing file
            Storage::delete($fullPath);
            //upload replacement file
            $this->newFile->storeAs(
                $replacingFileDetails->file_path . '/',
                $replacingFileDetails->file_name . '.' . $replacingFileDetails->type
            );
        } else {
            //if file not found, show file replace error
            $this->showFileReplaceError = true;
        }

        //hide file replace modal
        $this->showReplaceFileUploadModal = false;

        $this->newFile = null;
        $this->emit('all_files_uploaded');

        $this->dispatchBrowserEvent('notify-success', ['message' => 'File replaced successfully']);
    }

    /**
     * Get users belonging to the audit's organization.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getUsersForAudit()
    {
        $clientId = (int) $this->audit->client_id;
        $currentUser = auth()->user();

        $q = User::query()->where('enabled', 1);

        // Admin/Analyst: see & assign to ALL users
        if ($currentUser->hasAnyRole(['Administrator', 'Analyst', 'Jnr Analyst'])) {
            return $q->orderBy('name')->get();
        }

        // Client (main): can assign only to themselves OR their sub-users (same client)
        if ($currentUser->hasRole('Client')) {
            return $q->where(function ($w) use ($clientId, $currentUser) {
                // same client
                $w->whereRaw("FIND_IN_SET(?, REPLACE(client_id, ' ', ''))", [$clientId])
                    // and either Client Sub User OR the main Client themselves
                    ->where(function ($r) use ($currentUser) {
                        $r->whereHas('roles', fn($rr) => $rr->where('name', 'Client Sub User'))
                            ->orWhere('id', $currentUser->id);
                    });
            })
                ->orderBy('name')
                ->get();
        }

        // Client Sub User: cannot change assignment (UI will disable); return self only
        if ($currentUser->hasRole('Client Sub User')) {
            return $q->where('id', $currentUser->id)->orderBy('name')->get();
        }

        // Fallback: staff-like behavior
        return $q->orderBy('name')->get();
    }

    public $responsiblePersons = [];

    public function saveResponsiblePersons()
    {
        foreach ($this->responsiblePersons as $referenceId => $userId) {
            $reference = AuditReference::find($referenceId);
            if ($reference) {
                $reference->responsible_person_id = $userId;
                $reference->save();
            }
        }

        $this->dispatchBrowserEvent('notify-success', ['message' => 'Responsible persons updated successfully!']);
    }

    public function updateResponsiblePerson($fileId, $userId)
    {
        $auditFile = AuditFile::find($fileId);
        if (!$auditFile) {
            $this->dispatchBrowserEvent('notify-error', ['message' => 'Failed to update responsible person!']);
            return;
        }

        // Normalize: empty string → null; otherwise cast to int
        $userId = ($userId === '' || $userId === null) ? null : (int) $userId;

        if (!is_null($userId)) {
            // Assign + set dates
            $auditFile->responsible_person_id = $userId;
            $auditFile->date_requested = Carbon::today()->toDateString();
            $auditFile->due_date = Carbon::today()->addMonth()->toDateString();
            // (optional) ensure status is pending after assignment:
            // $auditFile->status = 0;
            $auditFile->save();

            // Notify (your existing code)
            $assignedUser = User::find($userId);
            if ($assignedUser) {
                $clientName = optional($this->audit->client)->name ?? 'Unknown Client';

                $emailData = [
                    'userName' => $assignedUser->name,
                    'auditName' => $this->audit->name,
                    'clientName' => $clientName,
                    'documentName' => $auditFile->reference->name,
                    'auditUrl' => url("/audits/{$this->audit->id}?showEmail=false&tab=details"),
                ];

                // Mail::send('emails.document-assigned', $emailData, function ($message) use ($assignedUser) {
                //     $message->to($assignedUser->email)
                //             ->cc('xiiphoid@gmail.com')
                //             ->subject('Document Assignment Notification');
                // });
            }

            $this->dispatchBrowserEvent('notify-success', [
                'message' => 'Responsible person updated, dates set to today and +1 month.',
            ]);
        } else {
            // Clearing the assignee; leave dates as-is
            $auditFile->responsible_person_id = null;
            $auditFile->save();

            $this->dispatchBrowserEvent('notify-success', [
                'message' => 'Responsible person cleared.',
            ]);
        }

        // mark the page as having unsent assignment changes (for on-leave prompt)
        $this->dispatchBrowserEvent('assignment-changed', [
            'auditId' => $this->audit->id,
            'referenceId' => $auditFile->audit_reference_id,
            'fileId' => $auditFile->id,
        ]);

        $this->dispatchBrowserEvent('hard-refresh-to', [
            'targetId' => 'row-' . $this->audit->id . '-' . $auditFile->audit_reference_id,
        ]);
    }

    public function responsibleUser()
    {
        return $this->belongsTo(User::class, 'responsible_person_id');
    }

    public $searchTerm = '';

    protected $listeners = [
        'refreshComponent' => '$refresh',
        'applyDueDatesToOthers',
        'confirmDueDateAssignment' => 'applyDueDatesToOthers',
        'closeEmailPdfModal' => 'closeEmailPdfModal'
    ];


    public function getFilteredDataProperty()
    {
        $user = auth()->user();
        $needle = Str::lower(trim((string) $this->searchString));
        $hasNeedle = $needle !== '';

        // other filters
        $passesUser = function ($file) use ($user) {
            if ($user->hasRole('Client Sub User')) {
                return $file && (string) $file->responsible_person_id === (string) $user->id;
            }
            if ($this->filterUser !== '' && $this->filterUser !== null) {
                return $file && (string) $file->responsible_person_id === (string) $this->filterUser;
            }
            return true;
        };

        // 🔹 UPDATED: split status 0 into "pending (uploaded)" vs "waiting (no file yet)"
        $passesStatus = function ($file) {
            $fs = (string) ($this->filterStatus ?? '');

            if ($fs === '') {
                return true; // no status filter
            }

            // Waiting: no file row OR placeholder row (file_id null)
            if ($fs === '0:waiting') {
                return (!$file) || is_null($file->file_id);
            }

            // Pending (uploaded): file exists, status=0
            if ($fs === '0:pending') {
                return $file && !is_null($file->file_id) && (string) $file->status === '0';
            }

            // Back-compat: plain "0" behaves like pending-with-file
            if ($fs === '0') {
                return $file && !is_null($file->file_id) && (string) $file->status === '0';
            }

            // Normal codes
            if (in_array($fs, ['1', '2'], true)) {
                return $file && (string) $file->status === $fs;
            }

            return true; // fallback
        };

        $passesDate = function ($file) {
            if (empty($this->filterDate))
                return true;
            return $file && $file->due_date
                && \Carbon\Carbon::parse($file->due_date)->format('Y-m-d') < $this->filterDate;
        };

        return $this->data
            ->groupBy(fn($f) => $f->top_level ?? 'Uncategorized')
            ->map(function ($folders, $topLevel) use ($needle, $hasNeedle, $passesUser, $passesStatus, $passesDate) {

                $topLevelMatches = $hasNeedle && Str::contains(Str::lower($topLevel ?? ''), $needle);

                $filteredFolders = $folders->map(function ($folder) use ($needle, $hasNeedle, $topLevelMatches, $passesUser, $passesStatus, $passesDate) {

                    $folderMatches = $hasNeedle && Str::contains(Str::lower($folder->name ?? ''), $needle);
                    $headingMatched = $topLevelMatches || $folderMatches;

                    // If a heading matched via search, include all items under it (keep your existing behavior)
                    if ($headingMatched) {
                        $items = $folder->referenceItems->values();
                    } else {
                        // Otherwise, apply search + user + status + date filters
                        $items = $folder->referenceItems->filter(function ($item) use ($hasNeedle, $needle, $passesUser, $passesStatus, $passesDate) {
                            $searchOk = !$hasNeedle || Str::contains(Str::lower($item->name ?? ''), $needle);
                            $file = $item->files->first();
                            return $searchOk && $passesUser($file) && $passesStatus($file) && $passesDate($file);
                        })->values();
                    }

                    $clone = clone $folder;
                    $clone->setRelation('referenceItems', $items);
                    $clone->__keep_if_empty = $headingMatched;

                    return $clone;
                })
                    ->filter(fn($folder) => $folder->referenceItems->isNotEmpty() || $folder->__keep_if_empty === true)
                    ->values();

                return [
                    'top_level' => $topLevel,
                    'folders' => $filteredFolders,
                ];
            })
            ->filter(fn($group) => $group['folders']->isNotEmpty())
            ->values();
    }

    public function updatedFilterUser()
    {
        $this->emitSelf('refreshComponent');
    }

    public function updatedFilterStatus()
    {
        $this->emitSelf('refreshComponent');
    }

    public function updatedFilterDate()
    {
        $this->emitSelf('refreshComponent');
    }

    public function getAuditSummaryProperty()
    {
        $auditId = $this->audit->id;

        $sql = <<<SQL
SELECT s.status, COUNT(*) AS count
FROM (
    /* For each reference in this audit, look at its earliest (min id) row:
       - If first.file_id is 0/NULL => empty
       - Else use first.status: 0=pending, 1=accepted, 2=rejected, otherwise empty
    */
    SELECT
        g.audit_reference_id,
        COUNT(g.id) AS actual_count,
        ff.file_id   AS first_file_id,
        ff.status    AS first_status,
        CASE
            WHEN COUNT(g.id) = 0 THEN 'empty'
            WHEN COALESCE(ff.file_id, 0) = 0 THEN 'empty'
            WHEN ff.status = 0 THEN 'pending'
            WHEN ff.status = 1 THEN 'accepted'
            WHEN ff.status = 2 THEN 'rejected'
            ELSE 'empty'
        END AS status
    FROM audit_files AS g
    JOIN (
        SELECT audit_reference_id, MIN(id) AS first_id
        FROM audit_files
        WHERE audit_id = ?
        GROUP BY audit_reference_id
    ) f
      ON f.audit_reference_id = g.audit_reference_id
    JOIN audit_files AS ff
      ON ff.id = f.first_id
    WHERE g.audit_id = ?
    GROUP BY g.audit_reference_id, ff.file_id, ff.status
) AS s
GROUP BY s.status
SQL;

        $rows = DB::select($sql, [$auditId, $auditId]);

        $counts = collect($rows)->mapWithKeys(fn($r) => [$r->status => (int) $r->count]);

        $totalAccepted = $counts['accepted'] ?? 0;
        $totalPending = $counts['pending'] ?? 0;
        $totalRejected = $counts['rejected'] ?? 0;
        $totalEmpty = $counts['empty'] ?? 0;

        // One per reference: uploaded = accepted + pending + rejected
        $totalFiles = $totalAccepted + $totalPending + $totalRejected;

        return compact('totalFiles', 'totalAccepted', 'totalPending', 'totalRejected', 'totalEmpty');
    }


    public function updateFolderResponsibleUser($folderId, $userId)
    {
        // Find all reference items under this folder
        $references = AuditReference::where('folder_id', $folderId)->get();

        $assignedUser = User::find($userId);

        foreach ($references as $reference) {
            $auditFile = AuditFile::where('audit_reference_id', $reference->id)
                ->where('audit_id', $this->audit->id)
                ->first();

            if ($auditFile && $auditFile->responsible_person_id === null) {
                $auditFile->responsible_person_id = $userId;
                // 🔹 NEW: Set date_requested to today and due_date to 1 month from now
                $auditFile->date_requested = Carbon::today()->toDateString();
                $auditFile->due_date = Carbon::today()->addMonth()->toDateString();
                $auditFile->save();
            }
        }

        if ($assignedUser) {
            // Get the folder name
            $folderName = AuditReferenceCategory::find($folderId)->name ?? 'Unknown Folder';

            // Get the client name via audit
            $clientName = optional($this->audit->client)->name ?? 'Unknown Client';

            $emailData = [
                'userName' => $assignedUser->name,
                'auditName' => $this->audit->name,
                'clientName' => $clientName,
                'folderName' => $folderName,
                'auditUrl' => url("/audits/{$this->audit->id}?showEmail=false&tab=details"),
            ];

            //Mail::send('emails.folder-assigned', $emailData, function ($message) use ($assignedUser) {
            //    $message->to($assignedUser->email)
            //        ->cc('xiiphoid@gmail.com')
            //        ->subject('Folder Assignment Notification');
            //});
        }

        session()->flash('success_message', 'Responsible person updated for unassigned items only');

        // 🔹 FIXED: Set both flags to prevent navigation prompt
        $this->dispatchBrowserEvent('assignment-changed', [
            'auditId' => $this->audit->id,
        ]);

        // 🔹 Use hard-refresh-to instead of remember-scroll to bypass the prompt
        $this->dispatchBrowserEvent('hard-refresh-to', [
            'targetId' => "folder-{$folderId}"
        ]);
    }


    public function updatedUploadFile()
    {
        if ($this->uploadingItemId && $this->uploadFile) {
            $this->inlineUpload();
        }
    }

    public function inlineUpload()
    {
        if (!$this->uploadingItemId || empty($this->uploadFiles)) {
            return;
        }

        $auditRef = AuditReference::find($this->uploadingItemId);
        if (!$auditRef)
            return;

        // Prefer the placeholder "original" row (file_id is null); else fall back to oldest row
        $original = AuditFile::where('audit_id', $this->audit->id)
            ->where('audit_reference_id', $this->uploadingItemId)
            ->orderByRaw("CASE WHEN file_id IS NULL THEN 0 ELSE 1 END")
            ->orderBy('id')
            ->first();

        // Convenience copies of fields to inherit for new rows
        $inherit = [
            'responsible_person_id' => optional($original)->responsible_person_id,
            'date_requested' => optional($original)->date_requested,
            'due_date' => optional($original)->due_date,
        ];

        $usedOriginal = false;

        foreach ($this->uploadFiles as $idx => $uploadedFile) {
            // Create File record (physical metadata)
            $fileDetails = File::make();
            $fileDetails->client_id = $this->audit->client_id;
            $fileDetails->user_id = Auth::id();
            $fileDetails->file_name = $uploadedFile->getClientOriginalName();
            $fileDetails->type = $uploadedFile->getClientOriginalExtension();
            $fileDetails->file_path = 'uploads/' . preg_replace('/\s+/', '_', $this->audit->client->name)
                . '/audits/' . $this->audit->name . '/' . $auditRef->folder->name;

            $this->audit->files()->save($fileDetails);

            // Decide whether to UPDATE original row or CREATE a new one
            if ($original && !$usedOriginal && empty($original->file_id)) {
                // Update the original placeholder row with the first file
                $original->file_id = $fileDetails->id;
                $original->status = 0;           // Accepted on upload
                $original->date_uploaded = now();
                $original->save();

                $targetAuditFile = $original;
                $usedOriginal = true; // only the first upload fills the original
            } else {
                // Create a new audit_files row for subsequent files
                $targetAuditFile = new AuditFile();
                $targetAuditFile->audit_id = $this->audit->id;
                $targetAuditFile->audit_reference_id = $this->uploadingItemId;
                $targetAuditFile->file_id = $fileDetails->id;
                $targetAuditFile->status = 1;
                $targetAuditFile->date_uploaded = now();

                // Inherit useful fields from the original (if any)
                if ($inherit['responsible_person_id']) {
                    $targetAuditFile->responsible_person_id = $inherit['responsible_person_id'];
                }
                if ($inherit['date_requested']) {
                    $targetAuditFile->date_requested = $inherit['date_requested'];
                }
                if ($inherit['due_date']) {
                    $targetAuditFile->due_date = $inherit['due_date'];
                }

                $targetAuditFile->save();
            }

            // Store the physical file
            $uploadedFile->storeAs(
                $fileDetails->file_path,
                $fileDetails->file_name . '.' . $fileDetails->type
            );

            // Notify assigned person if needed
            if (!empty($targetAuditFile->responsible_person_id)) {
                $this->checkUserDocsUploaded($targetAuditFile->responsible_person_id);
            }
        }

        // Reset UI state
        $this->uploadingItemId = null;
        $this->uploadFiles = [];

        $this->dispatchBrowserEvent('notify-success', ['message' => 'Files uploaded successfully!']);
    }


    protected function checkUserDocsUploaded(int $userId)
    {
        // Count how many files this user still needs to upload or re-upload
        $pending = \App\Models\AuditFile::query()
            ->where('audit_id', $this->audit->id)
            ->where('responsible_person_id', $userId)
            // status = 3 (not yet uploaded) OR status = 2 (rejected)
            ->whereIn('status', [2, 3])
            ->count();

        // If none left, send the thank-you
        if ($pending === 0) {
            $user = \App\Models\User::find($userId);
            if ($user && $user->email) {
                \Mail::to($user->email)
                    ->send(new \App\Mail\AuditFinalThankYouMail($this->audit, $user));
            }
        }
    }

    public function duplicateAudit()
    {
        $originalAudit = Audit::findOrFail($this->audit->id);

        DB::beginTransaction();

        try {
            // Duplicate audit
            $newAudit = $originalAudit->replicate();
            $newAudit->name = $originalAudit->name . ' (Copy)';
            $newAudit->created_at = now();
            $newAudit->updated_at = now();
            $newAudit->save();

            // Duplicate audit_files only
            $files = DB::table('audit_files')->where('audit_id', $originalAudit->id)->get();

            foreach ($files as $file) {
                $newFile = (array) $file;
                unset($newFile['id']);
                $newFile['audit_id'] = $newAudit->id;
                $newFile['created_at'] = now();
                $newFile['updated_at'] = now();
                $newFile['status'] = 3;
                $newFile['checked_by'] = null;
                $newFile['file_id'] = null;
                $newFile['date_uploaded'] = null;
                DB::table('audit_files')->insert($newFile);
            }

            // Duplicate audit_has_audit_refs entries
            $refLinks = DB::table('audit_has_audit_refs')
                ->where('audit_id', $originalAudit->id)
                ->get();

            foreach ($refLinks as $ref) {
                DB::table('audit_has_audit_refs')->insert([
                    'audit_id' => $newAudit->id,
                    'audit_reference_id' => $ref->audit_reference_id,
                ]);
            }

            DB::commit();

            $this->dispatchBrowserEvent('notify-success', ['message' => 'Audit duplicated successfully.']);
            return redirect()->to('/audits/' . $newAudit->id . '?tab=details');

        } catch (\Exception $e) {
            DB::rollBack();
            $this->dispatchBrowserEvent('notify-error', ['message' => 'Failed to duplicate audit: ' . $e->getMessage()]);
        }
    }

    public function notifyAssignedUsers()
    {
        $auditId = $this->audit->id;

        // Fetch all assigned users for the audit (update this logic based on your structure)
        $assignedUsers = DB::table('audit_files')
            ->join('users', 'audit_files.responsible_person_id', '=', 'users.id')
            ->join('audit_references', 'audit_files.audit_reference_id', '=', 'audit_references.id')
            ->where('audit_files.audit_id', $this->audit->id)
            ->select('users.id', 'users.name', 'users.email', 'audit_references.name as file_name', 'audit_files.responsible_person_id')
            ->get()
            ->groupBy('responsible_person_id');

        if ($assignedUsers->isEmpty()) {
            $this->dispatchBrowserEvent('notify-error', ['message' => 'No users assigned to this audit.']);
            return;
        }

        foreach ($assignedUsers as $userId => $files) {
            $user = $files->first(); // All grouped files belong to this user

            Mail::to($user->email)->send(new AuditUploadReminder(
                $user,
                $this->audit,
                $files
            ));
        }


        $this->dispatchBrowserEvent('notify-success', ['message' => 'Notifications sent to assigned users.']);

        $this->dispatchBrowserEvent('assignment-notified', [
            'auditId' => $this->audit->id,
        ]);
    }

    public function removeReference($referenceId)
    {
        $auditId = $this->audit->id;

        // Delete from audit_has_audit_refs
        DB::table('audit_has_audit_refs')
            ->where('audit_id', $auditId)
            ->where('audit_reference_id', $referenceId)
            ->delete();

        // Delete from audit_files
        DB::table('audit_files')
            ->where('audit_id', $auditId)
            ->where('audit_reference_id', $referenceId)
            ->delete();

        $this->dispatchBrowserEvent('notify-success', ['message' => 'Reference removed from audit.']);
        $this->mount($auditId); // Reload data
    }

    public function getUsersWithAssignedFilesForThisAuditProperty()
    {
        return User::whereIn('id', function ($query) {
            $query->select('responsible_person_id')
                ->from('audit_files')
                ->whereNotNull('responsible_person_id')
                ->where('audit_id', $this->audit->id);
        })
            ->where('enabled', 1) // Optional: only include enabled users
            ->orderBy('name')
            ->get();
    }

    public function applyDueDatesToOthers($currentFileId, $formData)
    {
        logger()->info('applyDueDatesToOthers was triggered', [
            'file_id' => $currentFileId,
            'formData' => $formData
        ]);

        $this->dispatchBrowserEvent('notify', [
            'message' => 'applyDueDatesToOthers was called!'
        ]);

        $field = array_key_first($formData);
        $value = $formData[$field];

        if (!$field || $value === '')
            return;

        // 1. Get audit_id and folder_id of the current file
        $current = DB::table('audit_files')
            ->join('audit_references', 'audit_files.audit_reference_id', '=', 'audit_references.id')
            ->select('audit_files.audit_id', 'audit_references.folder_id')
            ->where('audit_files.id', $currentFileId)
            ->first();

        if (!$current)
            return;

        // 2. Get all audit_file IDs matching the logic
        $fileIds = DB::table('audit_files')
            ->join('audit_references', 'audit_files.audit_reference_id', '=', 'audit_references.id')
            ->where('audit_files.audit_id', $current->audit_id)
            ->where('audit_references.default', 1)
            ->where('audit_references.folder_id', $current->folder_id)
            ->pluck('audit_files.id');

        if ($fileIds->isEmpty())
            return;

        // 3. Update all those files
        DB::table('audit_files')
            ->whereIn('id', $fileIds)
            ->update([$field => $value]);

        $this->dispatchBrowserEvent('notify', [
            'message' => ucfirst($field) . ' updated for ' . $fileIds->count() . ' files in the section.'
        ]);
    }

    protected function userCannotDelete(): bool
    {
        return auth()->user()->hasAnyRole(['Client', 'Client Sub User']);
    }

    // inside class AuditSection extends Component
    public $showChangeClientModal = false;
    public $selectedClientId = null;

    protected function userCanChangeAuditClient(): bool
    {
        return auth()->user()->hasAnyRole(['Administrator', 'Analyst', 'Jnr Analyst']);
    }

    public function openChangeClientModal()
    {
        if (!$this->userCanChangeAuditClient())
            return;

        $this->selectedClientId = $this->audit->client_id;
        $this->showChangeClientModal = true;
    }

    /**
     * Persist the new client_id on audits table.
     * Only audits.client_id changes; other tables untouched.
     */
    public function changeAuditClient()
    {
        if (!$this->userCanChangeAuditClient()) {
            $this->dispatchBrowserEvent('notify-error', ['message' => 'You do not have permission to change the client.']);
            return;
        }

        $this->validate([
            'selectedClientId' => 'required|exists:clients,id',
        ]);

        // Update and refresh local state
        $this->audit->client_id = (int) $this->selectedClientId;
        $this->audit->save();

        // Refresh relations and any dependent props you use
        $this->audit->load('client');
        $this->contactEmails = $this->audit->client()->withTrashed()->first()->contactsMorph->pluck('email');

        $this->showChangeClientModal = false;

        $this->dispatchBrowserEvent('notify-success', ['message' => 'Audit client updated.']);
        $this->emitSelf('$refresh');
    }

    /**
     * Helper to populate the client dropdown.
     * (Adjust filtering to your needs, e.g., only enabled clients)
     */
    public function getAllClientsProperty()
    {
        return Clients::query()
            ->orderBy('name')
            ->get(['id', 'name']);
    }

    public bool $showAddUserModal = false;

    /** @var array{type:?string,id:?int} */
    public array $assignContext = ['type' => null, 'id' => null];

    public array $newUser = [
        'first_name' => '',
        'last_name' => '',
        'email' => '',
        'role' => 'Analyst',
        'phone' => '',
    ];

    protected function addUserRules(): array
    {
        return [
            'newUser.first_name' => ['required', 'string', 'max:100'],
            'newUser.last_name' => ['required', 'string', 'max:100'],
            'newUser.email' => ['required', 'email', 'max:255'],
            'newUser.role' => ['required', 'string', 'in:Analyst,Client,Client Sub User'],
            'newUser.phone' => ['nullable', 'string', 'max:50'],
        ];
    }

    public function openAddUserModal(string $type, int $id): void
    {
        // mirror your Blade gate
        if (auth()->user()->hasRole('Client Sub User')) {
            $this->dispatchBrowserEvent('notify', ['type' => 'error', 'message' => 'You are not allowed to assign users.']);
            return;
        }

        if (!in_array($type, ['folder', 'file'], true)) {
            $this->dispatchBrowserEvent('notify', ['type' => 'error', 'message' => 'Invalid assignment target.']);
            return;
        }

        $this->resetValidation();
        $this->assignContext = ['type' => $type, 'id' => $id];
        $this->showAddUserModal = true;
    }

    protected function resetAddUserForm(): void
    {
        $this->newUser = [
            'first_name' => '',
            'last_name' => '',
            'email' => '',
            'role' => 'Analyst',
            'phone' => '',
        ];
        $this->assignContext = ['type' => null, 'id' => null];
        $this->showAddUserModal = false;
    }

    public function saveNewUserAndAssign(): void
    {
        if (auth()->user()->hasRole('Client Sub User')) {
            $this->dispatchBrowserEvent('notify', ['type' => 'error', 'message' => 'You are not allowed to assign users.']);
            return;
        }

        $this->validate($this->addUserRules());

        $type = $this->assignContext['type'] ?? null;
        $id = $this->assignContext['id'] ?? null;

        if (!$type || !$id) {
            $this->dispatchBrowserEvent('notify', ['type' => 'error', 'message' => 'No assignment target.']);
            return;
        }

        $first = trim($this->newUser['first_name']);
        $last = trim($this->newUser['last_name']);
        $email = strtolower(trim($this->newUser['email']));
        $role = $this->newUser['role'];
        $phone = trim((string) ($this->newUser['phone'] ?? ''));

        /** @var \App\Models\User $User */
        $User = app(\App\Models\User::class);

        $me = auth()->user();
        $clientId = $me->client_id ?? null;

        $currentClientId = auth()->user()->client_id ?? null;

        // Decide what client_id the new user should get
        if (in_array($role, ['Client', 'Client Sub User'], true)) {
            // Use the audit's client_id (so they belong to that client)
            $clientId = $this->audit->client_id ?? $currentClientId;
        }

        $user = $User::where('email', $email)->first();

        if (!$user) {
            $user = $User::create([
                'name' => $first . ' ' . $last,
                'email' => $email,
                'password' => \Illuminate\Support\Facades\Hash::make(\Illuminate\Support\Str::random(24)),
                'phone' => $phone ?: null,
                'client_id' => $clientId,
                'enabled' => 1,
            ]);
        } else {
            if (!is_null($clientId) && $user->client_id !== $clientId) {
                $this->dispatchBrowserEvent('notify', [
                    'type' => 'error',
                    'message' => 'User exists under another company. Contact an admin.',
                ]);
                return;
            }
            $user->forceFill([
                'client_id' => $user->client_id ?? $clientId,
                'enabled' => 1,
            ])->save();
        }

        // Role assignment (Spatie)
        if (method_exists($user, 'assignRole') && !$user->hasRole($role)) {
            $user->assignRole($role);
        }

        // Send reset link (non-fatal if mail fails)
        try {
            \Illuminate\Support\Facades\Password::sendResetLink(['email' => $user->email]);
        } catch (\Throwable $e) {
            \Log::warning('Password reset email failed: ' . $e->getMessage());
        }

        // Assign to the selected target
        if ($type === 'folder') {
            $this->updateFolderResponsibleUser((int) $id, $user->id);
        } elseif ($type === 'file') {
            $this->updateResponsiblePerson((int) $id, $user->id);
        }

        // Refresh UI
        if (method_exists($this, 'refreshData')) {
            $this->refreshData();
        } else {
            $this->emitSelf('$refresh');
        }

        session()->flash('message', 'User created/linked and assigned.');
        $this->resetAddUserForm();
    }

    // Properties
    public $showEmailPdfModal = false;
    public $emailPdf = [
        'to' => '',
        'cc' => '',
    ];

    // Open modal with a sensible default
    public function openEmailPdfModal()
    {
        // Pre-fill TO with the audit owner/client email if you have it; fallback to current user.
        $defaultTo = optional($this->audit->owner ?? null)->email
            ?? optional($this->audit->client()->withTrashed()->first() ?? null)->email
            ?? auth()->user()->email;

        $this->emailPdf['to'] = $defaultTo;
        $this->emailPdf['cc'] = '';
        $this->showEmailPdfModal = true;
    }

    public function closeEmailPdfModal()
    {
        $this->showEmailPdfModal = false;
    }

    /**
     * Get project task breakdown for the audit's linked project
     */
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

        // Sort categories
        usort($project['categories'], function ($a, $b) use ($order) {
            $oa = $order[$a['category']] ?? 99;
            $ob = $order[$b['category']] ?? 99;
            return $oa <=> $ob;
        });

        // Filter to only show the 4 visible buckets
        $project['categories'] = array_values(array_filter(
            $project['categories'],
            fn($c) => in_array($c['category'], ['Planning', 'Implementation', 'Review', 'Verification'], true)
        ));

        return $project;
    }
}
