<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Vehicle;

class VehicleDetailComponent extends Component
{
    public $selected_vehicle;
    public $interiorFeatures;
    public $exteriorFeatures;
    public $tags;

    public function mount($id)
    {
        $this->selected_vehicle = Vehicle::with('features')->findOrFail($id);
        $this->exteriorFeatures = $this->selected_vehicle->features->where('type', 'exterior');
        $this->interiorFeatures = $this->selected_vehicle->features->where('type', 'interior');
        $this->tags = $this->selected_vehicle->features->where('type', 'tag');
    }

    public function render()
    {
        return view('livewire.vehicle-detail-component');
    }
}
