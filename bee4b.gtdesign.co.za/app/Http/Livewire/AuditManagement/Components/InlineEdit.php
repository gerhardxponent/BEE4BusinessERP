<?php

// namespace App\Http\Livewire\GlobalComponents;
namespace App\Http\Livewire\AuditManagement\Components;

use App\Models\AuditFile;
use Carbon\Carbon;
use Livewire\Component;
use Illuminate\Support\Facades\DB;

class InlineEdit extends Component
{
    public $field;
    public $fileID; //audit file ID
    public $auditFile;
    public $type;
    public $permission = '';

    protected $rules = [
        'auditFile.date_requested' => 'required',
        'auditFile.due_date' => 'required',
        'auditFile.date_last_checked' => 'required',
        'auditFile.notes' => 'required',
    ];

    // protected $listeners = [
    //     'refreshComponent' => '$refresh',
    //     'refreshEditLine' => '$refresh',
    //     'requestedChanged'
    // ];

    protected function getListeners()
    {
        $res = [
            'refreshComponent' => '$refresh',
        ];

        if($this->field == 'due_date') {
            $new = [
                "requestedChanged:{$this->auditFile->id}" => 'requestedChanged'
            ];
            $res = array_merge($res, $new);
        }

        return $res;
    }

    public function requestedChanged()
    {
        // dd('hello');
        if($this->field === 'due_date') {
            $this->auditFile = AuditFile::find($this->auditFile->id);
        }
    }

    public function mount($field, $fileID, $type, $file)
    {   
        $this->field = $field;
        $this->fileID = $fileID;
        $this->type = $type;

        // $this->auditFile = AuditFile::find($fileID);
        $this->auditFile = $file;
    }

    public function render()
    {
        return view('livewire.audit-management.components.inline-edit');
    }

    public function save()
    {
        // $this->emit('saveFile', $this->fileID);

        $data = $this->auditFile->attributesToArray()[$this->field];

        $this->auditFile = AuditFile::find($this->fileID);

        $this->auditFile->update([
            $this->field => $data
        ]);

        if($this->field === 'date_requested') {
            // dd(Carbon::parse($this->auditFile->date_requested)->addDays(30));

            $this->auditFile->due_date = Carbon::parse($this->auditFile->date_requested)->addDays(30);
            $this->auditFile->save();
            // dd("requestedChanged:{$this->auditFile->id}");
            $this->emit("requestedChanged:{$this->auditFile->id}"); 
        }

        // $this->emit('refreshComponent');
    }

    public function applyDueDatesToOthers($currentFileId, $formData)
    {
        \Log::info('applyDueDatesToOthers triggered for file: ' . $currentFileId);

        $field = '';
        $value = '';

        foreach ($formData as $k => $v) {
            $field = $k;
            $value = $v;
        }

        \Log::info('applyDueDatesToOthers:', [
            'currentFileId' => $currentFileId,
            'formData' => $formData,
        ]);

        if (empty($value)) {
            \Log::warning("applyDueDatesToOthers: Value for $field is empty, aborting.");
            $this->dispatchBrowserEvent('notify', [
                'message' => 'Field cannot be empty. No updates made.'
            ]);
            return;
        }

        // Get audit_id and folder_id for this file
        $file = \App\Models\AuditFile::with('reference')->find($currentFileId);
        if (!$file || !$file->reference) {
            \Log::warning('AuditFile or its reference not found for ID: ' . $currentFileId);
            return;
        }

        $auditId = $file->audit_id;
        $folderId = $file->reference->folder_id;

        // Get matching file IDs
        $fileIds = \DB::table('audit_files')
            ->leftJoin('audit_references', 'audit_files.audit_reference_id', '=', 'audit_references.id')
            ->where('audit_files.audit_id', $auditId)
            //->where('audit_references.default', 1)
            ->where('audit_references.folder_id', $folderId)
            ->pluck('audit_files.id');

        \App\Models\AuditFile::whereIn('id', $fileIds)->update([
            $field => $value,
            'updated_at' => now()
        ]);

        $this->dispatchBrowserEvent('notify', [
            'message' => ucfirst($field) . ' applied to all ' . count($fileIds) . ' matching files.'
        ]);
    }
}
