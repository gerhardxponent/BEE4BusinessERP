<?php

namespace App\Http\Livewire\GlobalComponents;

use Illuminate\Support\Facades\Storage;
use Livewire\Component;

class RestoreOrDeleteModal extends Component
{
    public $model;
    public $entityId;
    public $tableName;
    public $deleteFiles;
    public $filePath;
    public $showModal = false;

    protected $listeners = [
        'toggleRestoreModal'
    ];

    // public function mount($model, $id, $tableName)
    // {
    //     $this->model = $model;
    //     $this->id = $id;
    //     $this->tableName = $tableName;
    // }

    public function render()
    {
        return view('livewire.global-components.restore-or-delete-modal');
    }

    public function toggleRestoreModal($model, $entityId, $tableName)
    {
        $this->model = '\App\Models\\' . $model;
        $this->entityId = $entityId;
        $this->tableName = $tableName;
        $this->showModal = true;
    }

    public function restore()
    {
        $this->model::find($this->entityId)->restore();
        $this->showModal = false;
        $this->emit('pg:eventRefresh-' . $this->tableName);
    }

    public function permanentlyDelete()
    {
        // dd(Storage::exists('uploads/Amazon/audits/Amazon Sept 2022'));
        // if (Storage::exists($this->filePath)) {
        //     Storage::delete($this->filePath);
        // }

        $deletingRecord = $this->model::withTrashed()->find($this->entityId);

        // if ($this->deleteFiles == true && Storage::exists())

        $deletingRecord->forceDelete();
        $this->showModal = false;
        $this->emit('pg:eventRefresh-' . $this->tableName);
    }
}
