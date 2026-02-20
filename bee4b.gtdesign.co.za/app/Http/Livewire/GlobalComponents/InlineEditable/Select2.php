<?php

namespace App\Http\Livewire\GlobalComponents\InlineEditable;

use Livewire\Component;

class Select2 extends Component
{
    public $model;
    public $optionsClass;
    public $options;
    public $itemId;
    public $valueId;
    public $valueText;
    public $field;
    public $entityId;

    public function mount($model, $valueId, $optionsClass, $entityId)
    {
        $this->model = $model;
        $this->optionsClass = $optionsClass;
        $this->options = $this->optionsClass::all();
        $this->entityId = $entityId;

        if ($valueId != null) {
            $this->valueId = $valueId;
            $this->valueText = $this->options->where('id', $this->valueId)->first()->name;
        }
    }

    public function render()
    {
        return view('livewire.global-components.inline-editable.select2');
    }

    public function save()
    {
        $entity = $this->model::find($this->entityId);
        $entity->{$this->field} = $this->valueId;
        $entity->save();

        $this->valueText = $this->options->where('id', $this->valueId)->first()->name;
    }
}
