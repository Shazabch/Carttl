<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Vehicle;

class VehicleDetailComponent extends Component
{  
     public $selected_vehicle;
     public function mount($id)
    {   
        $this->selected_vehicle = Vehicle::find($id);
    }
    
    public function render()
    {
        return view('livewire.vehicle-detail-component');
    }
}
