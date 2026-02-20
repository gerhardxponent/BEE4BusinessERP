<?php

namespace App\Http\Livewire\Settings\Components;

use App\Models\Size;
use App\Models\State;
use App\Models\Region;
use App\Models\Sector;
use Livewire\Component;
use App\Models\BeeLevel;
use App\Models\ReportStatus;
use App\Models\RatingAgency;
use App\Models\AuditProgress;
use App\Models\EngagementType;

class Clients extends Component
{
    public $newItem = '';
    public $currentProperty;

    protected $rules = [
        'newItem' => 'required',
    ];

    public $properties = [
        'Size',
        'Sector',
        'Region',
        'State',
        'EngagementType',
        'ReportStatus',
        'RatingAgency',
        'BeeLevel',
        'AuditProgress'
    ];

    protected $listeners = [
        'refreshClientSettings' => '$refresh',
        'update:dropdown-item' => 'update',
    ];

    protected $queryString = [
        'currentProperty' 
    ];

    public function mount()
    {
        if ($this->currentProperty == null) {
            $this->currentProperty = $this->properties[0];
        }
    }

    public function render()
    {
        return view('livewire.settings.components.clients');
    }

    public function changeProperty($property)
    {
        $this->currentProperty = $property;
    }

    public function update($value, $model, $id, $field)
    {
        ('App\Models\\' . $model)::find($id)->update([ $field => $value ]);
    }

    public function createItem($property)
    {
        ('App\Models\\' . $property)::create([ 'name' => $this->newItem ]);

        $this->newItem = null;
    }

    public function delete($property, $id)
    {
        ('App\Models\\' . $property)::find($id)->delete();
    }

    public function getSizesProperty() { return Size::all(); }
    public function getSectorsProperty() { return Sector::all(); }
    public function getRegionsProperty() { return Region::all(); }
    public function getStatesProperty() { return State::all(); }
    public function getEngagementTypesProperty() { return EngagementType::all(); }
    public function getReportStatusesProperty() { return ReportStatus::all(); }
    public function getRatingAgenciesProperty() { return RatingAgency::all(); }
    public function getBeeLevelsProperty() { return BeeLevel::all(); }
    public function getAuditProgressesProperty() { return AuditProgress::all(); }

    public function updateItemOrder($list)
    {
        // dd($list);

        foreach($list as $item) {
            // BoardItem::find($item['value'])->update(['position' => $item['order']]);

            ('App\Models\\' . $this->currentProperty)::find($item['value'])->update(['position' => $item['order']]);
        }
    }
}
