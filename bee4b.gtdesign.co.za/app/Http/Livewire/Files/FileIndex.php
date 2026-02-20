<?php

namespace App\Http\Livewire\Files;

use App\Models\File;
use App\Models\FileAttributes;
use App\Models\FileCategory;
use Livewire\Component;

class FileIndex extends Component
{
    protected $listeners = [
        'refreshComponent' => '$refresh',
        'fileClicked' => 'selectFile'
    ];

    public $files;
    public $testFile;
    public $attribute;
    public $selectedFile;
    public $fileCategories;
    public $activeCategory;
    public $showFileModal = false;
    public $showAttributeModal = false;
    public $showCategoryModal = false;

    public $editing = false;

    public $attributes;

    public $newAttribute;

    protected $rules = [
        // 'attribute.*.value' => 'required',
        'attributes.*.value' => 'required',
        'selectedFile.file_name' => 'required',
        'selectedFile.type' => 'required',
        'selectedFile.client_comments' => 'required',
        'selectedFile.reviewer_comments' => 'required',
        'selectedFile.status' => 'required',

        'newAttribute.attribute' => 'required',
        'newAttribute.value' => 'required',
        
        'activeCategory' => 'required'
    ];

    public function mount()
    {
        $this->files = File::with('attributes')->get();
        // $this->testFile = File::with('attributes')->find(184);
        // $this->attribute = $this->testFile->attributes;

        $this->selectedFile = File::make();
        $this->newAttribute = FileAttributes::make();

        $this->fileCategories = FileCategory::all();
        // dd($this->testFile);
        // dd($this->files);
    
        // $myFile = File::find(238);
        // dd(explode('/', $myFile->file_path)[array_key_last(explode('/', $myFile->file_path))]);
    }

    public function render()
    {
        return view('livewire.files.file-index');
    }

    public function newAttribute()
    {
        $this->showFileModal = false;
        $this->showAttributeModal = true;
    }

    public function createAttribute()
    {
        $this->newAttribute->file_id = $this->selectedFile->id;
        $this->newAttribute->save();

        // $this->emit('refreshComponent');

        $this->showAttributeModal = false;
        // $this->showFileModal = true;
    }

    public function selectFile($id)
    {
        $this->selectedFile = File::with('attributes')->find($id);
        $this->attributes = $this->selectedFile->attributes;
        $this->showFileModal = true;
    }

    public function test()
    {
        dd($this->attribute);
    }

    public function save()
    {
        // dd($this->attributes[0]);
        $this->selectedFile->save();
        $this->selectedFile->attributes()->saveMany($this->attributes);

        $this->emit('refreshComponent');

        $this->editing = false;
    }

    public function closeAttributeModal()
    {
        $this->showAttributeModal = false;
        $this->showFileModal = true;
    }

    public function settings()
    {
        return redirect()->to('/fileSettings');
    }

    public function toggleChangeCategory()
    {
        $this->showFileModal = false;
        $this->showCategoryModal = true;
    }

    public function changeCategory()
    {
        if($this->selectedFile->category_id != null) {
            FileAttributes::where('file_id', $this->selectedFile->id)->delete();
        }

        $category = FileCategory::find($this->activeCategory);
        $category->files()->save($this->selectedFile);

        foreach($category->attributes as $attr) {
            $fileAttr = FileAttributes::make();
            $fileAttr->file()->associate($this->selectedFile);
            $fileAttr->attribute()->associate($attr);
            $fileAttr->save();
        }

        $this->emit('refreshComponent');

        $this->selectFile($this->selectedFile->id);
        
        $this->showCategoryModal = false;
        $this->showFileDetailsModal = true;
    }

    public function cancelCategory()
    {
        $this->showCategoryModal = false;
        $this->showFileModal = true;
    }
}
