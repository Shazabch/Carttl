<?php

namespace App\Livewire\Admin;

use Livewire\Component;

use App\Models\Vehicle;

class VehicleDetailComponent extends Component
{

    public Vehicle $vehicle;

    public string $activeTab = 'info';

     public function mount($id)
    {
        $this->vehicle = Vehicle::find($id);
    }
    public function setActiveTab(string $tabName)
    {
        $this->activeTab = $tabName;
    }

    public function render()
    {
        return view('livewire.admin.vehicle-detail-component');
    }
}
