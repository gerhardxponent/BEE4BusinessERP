<?php

namespace App\Http\Livewire\GlobalComponents;

use App\Models\File;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Throwable;

class FileDetailsModal extends Component
{
    public $selectedFile;
    public $selectedFileOriginalName = '';
    public $editFile = false;
    
    public $showFileDetailsModal = false;
    public $showConfirmDeleteFileModal = false;
    public $showFileNotFoundModal = false;

    protected $listeners = [
        'showFileModal',
        'fileSelected' => 'showFileModal'
    ];

    protected $rules = [
        'selectedFile.file_name' => 'required',
        'selectedFile.client_comments' => 'required',
        'selectedFile.reviewer_comments' => 'required',
        'selectedFile.status' => 'required',
    ];

    public function showFileModal($id)
    {
        try {
            $this->selectedFile = File::findOrFail($id);
            $this->selectedFileOriginalName = $this->selectedFile->file_name;
            $this->showFileDetailsModal = true;
        } catch (Throwable $e) {
            $this->showFileNotFoundModal = true;
        }

        // $this->selectedFile = File::find($id);
    }

    // public function fileSelected($id)
    // {
    //     $this->showFileDetailsModal = true;
    //     $this->selectedFile = File::find($id);
    // }

    public function mount()
    {
        $this->selectedFile = File::make();
    }

    public function render()
    {
        return view('livewire.global-components.file-details-modal');
    }

    public function toggleFileEdit()
    {
        if($this->editFile) {
            $this->selectedFile = File::find($this->selectedFile->id);
        }
        $this->editFile = !$this->editFile;
    }

    public function confirmDeleteFile()
    {
        $this->showFileDetailsModal = false;
        $this->showConfirmDeleteFileModal = true;
    }

    public function deleteFile()
    {
        $file = $this->selectedFile->file_path . '/' . $this->selectedFile->file_name . '.' . $this->selectedFile->type;

        if (Storage::exists($file)) {
            Storage::delete($file);
        }

        $this->selectedFile->delete();
        $this->emit('pg:eventRefresh-GlobalFilesTable');
        $this->selectedFile = File::make();
        $this->showConfirmDeleteFileModal = false;
    }

    public function updateFile()
    {
        $this->validate([
            'selectedFile.file_name' => 'required'
        ], [
            'selectedFile.file_name.required' => 'Please enter a name for this file'
        ]);

        if($this->selectedFile->file_name === '') $this->selectedFile->file_name = File::find($this->selectedFile->id)->file_name;

        if($this->selectedFileOriginalName !== $this->selectedFile->file_name) {
            Storage::move(
                $this->selectedFile->file_path . '/' . $this->selectedFileOriginalName . '.' . $this->selectedFile->type,
                $this->selectedFile->file_path . '/' . $this->selectedFile->file_name . '.' . $this->selectedFile->type
            );
        }

        $this->selectedFile->save();
        $this->editFile = false;
    }

    public function downloadSelected() 
    { 
        return Storage::download($this->selectedFile->file_path . '/' . $this->selectedFile->file_name . '.' . $this->selectedFile->type); 
    }
}
