<?php

namespace App\Http\Livewire\Clients;

use App\Models\Clients;
use App\Models\File;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithFileUploads;

class FilesUpload extends Component
{
    use WithFileUploads;

    public $files = [];
    public $client;
    public $test = 'hello';

    public function test()
    {
        $this->test = 'some words';
        // array_push($this->files, 'some stuff 1');
        // array_push($this->files, 'some stuff 2');
        // array_push($this->files, 'some stuff 3');

        // dd($this->files);
    }

    public function mount($clientId)
    {
        $this->client = Clients::find($clientId);
    }

    public function render()
    {
        return view('livewire.clients.files-upload');
    }

    public function updatedFiles()
    {
        $count = 0;
        // dd($this->files);
        foreach($this->files as $file) {
            $count++;

            $fileDetails = File::make();

            $fileDetails->file_name = $file->getClientOriginalName();
            $fileDetails->file_path = 'uploads/' . preg_replace('/\s+/', '_', $this->client->name);
            $fileDetails->client_id = $this->client->id;
            $fileDetails->user_id = Auth::id();
            $fileDetails->file_size = $file->getSize()/1024;
            $fileDetails->type = $file->getClientOriginalExtension();
            $fileDetails->status = 'Accepted';

            $fileDetails->save();

            $file->storeAs('uploads/' . preg_replace('/\s+/', '_', $this->client->name), $fileDetails->file_name . '.' . $file->getClientOriginalExtension());
            $this->emit('pg:eventRefresh-ClientFilesTable');
        }

        // dd($count);
    }
}
