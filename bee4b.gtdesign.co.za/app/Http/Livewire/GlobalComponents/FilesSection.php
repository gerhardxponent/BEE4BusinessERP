<?php

namespace App\Http\Livewire\GlobalComponents;

use App\Models\Activity;
use App\Models\File;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;

class FilesSection extends Component
{
    use WithFileUploads;

    public $entity;
    public $model;
    public $filePath;
    public $files = [];
    public $selectedFile;
    public $selectedFileOriginalName = '';
    public $editFile = false;
    public $enableUpload = false;

    public $showFileDetailsModal = false;
    public $showConfirmDeleteFileModal = false;

    protected $listeners = [
        'filesProcessed',
        'fileSelected',
        'refreshFilesSection' => '$refresh'
    ];

    protected $rules = [
        'selectedFile.file_name' => 'required',
        'selectedFile.client_comments' => 'required',
        'selectedFile.reviewer_comments' => 'required',
        'selectedFile.status' => 'required',
    ];

    public function mount($entity, $model, $filePath)
    {
        $this->entity = $entity;
        $this->model = $model;
        $this->filePath = $filePath;

        // dd($this->filePath);

        $this->selectedFile = File::make();
    }

    public function render()
    {
        return view('livewire.global-components.files-section');
    }

    public function newActivity($title, $body, $type)
    {
        $activity = Activity::make();

        $activity->user_id = Auth::id();
        $activity->title = ' ' . $title;
        $activity->body = $body;
        $activity->activity_type = $type;
        $activity->path = $this->filePath;
        $this->entity->activities()->save($activity);
    }

    public function fileSelected($id)
    {
        $this->selectedFile = File::find($id);
        $this->selectedFileOriginalName = $this->selectedFile->file_name;
        $this->showFileDetailsModal = true;
    }

    public function upload()
    {
        if(count($this->files) == 0) return;

        $fileList = '';
        $fileLinks = '';

        foreach($this->files as $index => $file) {
            $fileDetails = File::make();

            $fileDetails->file_name = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
            
            if(File::where('file_name', $fileDetails->file_name)
                     ->where('fileable_id', $this->entity->id)
                     ->where('fileable_type', $this->model)
                     ->exists()) {
                $fileDetails->file_name = 'copy_' . $fileDetails->file_name . '_' . date('d-m-y_h-i');
            }

            // $fileDetails->file_path = 'uploads/' . preg_replace('/\s+/', '_', $this->client->name);
            $fileDetails->file_path = 'uploads/' . $this->filePath;
            $fileDetails->client_id = null;
            $fileDetails->user_id = Auth::id();
            $fileDetails->file_size = $file->getSize()/1024;
            $fileDetails->type = $file->getClientOriginalExtension();
            $fileDetails->status = 'Accepted';

            $this->entity->files()->save($fileDetails);

            $file->storeAs('uploads/' . $this->filePath, $fileDetails->file_name . '.' . $file->getClientOriginalExtension());

            $fileList .= '<div class="text-blue-600 hover:underline cursor-pointer" wire:click="$emit(\'fileSelected\', \''.$fileDetails->id.'\')">'.$fileDetails->file_name.'</div>';

            // $fileLinks .= '<a href="./file-viewer/'.$fileDetails->id.'">'.$fileDetails->file_name.'</a>, ';
        }

        $this->newActivity(
            'has uploaded ' . count($this->files) . ' files',
            $fileList,
            'file upload'
        );

        $this->emit('all_files_uploaded');
        $this->emit('pg:eventRefresh-GlobalFilesTable');
        $this->enableUpload = false;
        $this->files = [];
        session()->flash('message', 'Files uploaded successfully');
    }

    public function filesProcessed() 
    {
        $this->enableUpload = true;
    }

    public function toggleFileEdit()
    {
        if($this->editFile) {
            $this->selectedFile = File::find($this->selectedFile->id);
        }
        $this->editFile = !$this->editFile;
    }

    public function updateFile()
    {
        if($this->selectedFile->file_name == '') $this->selectedFile->file_name = File::find($this->selectedFile->id)->file_name;
        // $this->validate();

        if($this->selectedFileOriginalName != $this->selectedFile->file_name) {
            Storage::move(
                $this->selectedFile->file_path . '/' . $this->selectedFileOriginalName . '.' . $this->selectedFile->type,
                $this->selectedFile->file_path . '/' . $this->selectedFile->file_name . '.' . $this->selectedFile->type
            );
        }

        $this->selectedFile->save();
        
        $this->editFile = false;
        $this->showFileDetailsModal = false;
    }

    public function downloadSelected() 
    { 
        return Storage::download($this->selectedFile->file_path . '/' . $this->selectedFile->file_name . '.' . $this->selectedFile->type); 
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
}
