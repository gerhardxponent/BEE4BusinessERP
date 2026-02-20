<?php

namespace App\Http\Livewire\GlobalComponents;

use Livewire\Component;
use Illuminate\Support\Str;

class InlineEdit extends Component
{
    public $origName;
    public $selectOrigName = '';
    public $entityId;
    public $shortId;
    public $newName; // dirty operation name state
    // public $isName; // determines whether to display it in bold text
    public string $field; // this is can be column. It comes from the blade-view foreach($fields as $field)
    public string $model; // Eloquent model with full name-space
    public $lineID;
    public $type = 'line'; // 'line' or 'textarea'
    public $permission = '';
    public $regex = '';
    public $optionsClass;
    public $options;
    public $dateFormat = 'Y-m-d';
    public $alignCenter = false;

    public function mount($model, $entity)
    {
        $this->entityId = $entity->id;
        $this->shortId = $entity->short_id;
        $this->origName = $entity->{$this->field};
        $this->options = $this->type === 'select2' ? $this->optionsClass::all() : '';
        $this->init($this->model, $entity); // initialize the component state
        // $this->type = 'line';
        // if(isset($entity->responsible_person)) {
        //     $this->origName = $entity->responsible_person->name;
        // }

    }

    public function save()
    {   
        if ($this->type === 'line') {
            $this->validate([
                'newName' => 'required|regex:/'.$this->regex.'/',
            ]);
        }
        
        $entity = $this->model::findOrFail($this->entityId);
        $newName = (string)Str::of($this->newName)->trim()->substr(0, 255); // trim whitespace & more than 255 characters
        $newName = $newName === $this->shortId ? null : $newName; // don't save it as operation name it if it's identical to the short_id

        $entity->{$this->field} = $newName ?? null;
        $entity->save();
        $this->init($this->model, $entity); // re-initialize the component state with fresh data after saving
        $this->dispatchBrowserEvent('notify', Str::studly($this->field).' successfully updated!');
        $this->emit($this->model . '-' . $this->entityId . '-' . $this->field, $this->newName);
    }

    private function init($model, $entity)
    {
        $this->origName = $entity->{$this->field} ?: $this->shortId;
        // if(isset($entity->responsible_person)) {
        //     $this->origName = $entity->responsible_person->name;
        // }
        $this->newName = $this->origName;
        // $this->isName = $entity->{$this->field} ?? false;
    }

    public function render()
    {
        return view('livewire.global-components.inline-edit');
    }
}
