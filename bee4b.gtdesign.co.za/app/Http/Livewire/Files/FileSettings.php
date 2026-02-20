<?php

namespace App\Http\Livewire\Files;

use App\Models\Attribute;
use App\Models\File;
use App\Models\FileAttributes;
use App\Models\FileCategory;

use Livewire\Component;

class FileSettings extends Component
{
    protected $listeners = ['refreshComponent' => '$refresh'];

    public $fileCategories;
    public $activeCategory;
    public $newAttribute;
    public $showCategoryDetailsModal = false;
    public $showCreateAttributeModal = false;
    public $showFileDetailsModal = false;
    public $showCategoryModal = false;
    public $files;
    public $activeFile;
    public $attributes;
    public $editing = true;

    protected $rules = [
        'newAttribute.name' => 'required',
        'attributes.*.value' => 'required'
    ];

    public function mount()
    {
        $this->files = File::all();
        $this->activeFile = File::make();
        $this->fileCategories = FileCategory::all();
        $this->newAttribute = Attribute::make();
        $this->activeCategory = FileCategory::make();
    }

    public function render()
    {
        return view('livewire.files.file-settings');
    }

    public function setActiveCategory($id)
    {
        $this->activeCategory = FileCategory::find($id);
        // dd($this->activeCategory->attributes[0]->name);

        $this->showCategoryDetailsModal = true;
    }

    public function createAttribute()
    {
        $this->activeCategory->attributes()->save($this->newAttribute);

        $attributeFiles = $this->activeCategory->files;

        foreach($attributeFiles as $file) {
            $fileAttr = FileAttributes::make();
            $fileAttr->file()->associate($file);
            $fileAttr->attribute()->associate($this->newAttribute);
            $fileAttr->save();
        }

        $this->showCreateAttributeModal = false;
        $this->newAttribute = Attribute::make();
    }

    public function setActiveFile($id)
    {
        $this->activeFile = File::find($id);
        $this->attributes = $this->activeFile->attributes;
        $this->showFileDetailsModal = true;
    }

    public function save()
    {
        $this->activeFile->attributes()->saveMany($this->attributes);

        $this->emit('refreshComponent');
    }

    public function toggleChangeCategoryModal()
    {
        $this->showFileDetailsModal = false;
        $this->showCategoryModal = true;
    }

    public function changeCategory()
    {
        if($this->activeFile->category_id != null) {
            FileAttributes::where('file_id', $this->activeFile->id)->delete();
        }

        $category = FileCategory::find($this->activeCategory);
        $category->files()->save($this->activeFile);

        foreach($category->attributes as $attr) {
            $fileAttr = FileAttributes::make();
            $fileAttr->file()->associate($this->activeFile);
            $fileAttr->attribute()->associate($attr);
            $fileAttr->save();
        }

        $this->emit('refreshComponent');

        $this->setActiveFile($this->activeFile->id);
        
        $this->showCategoryModal = false;
        $this->showFileDetailsModal = true;
    }

    public function toggleCreateAttribute()
    {
        $this->showCategoryDetailsModal = false;
        $this->showCreateAttributeModal = true;
    }
}
