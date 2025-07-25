<?php

namespace App\Livewire\Admin\Vehicle;

use App\Models\Vehicle;
use Livewire\Component;

class VehicleDetailComponent extends Component
{
    public Vehicle $vehicle;

    public $showForm = false;

    protected $listeners = ['vehicleSaved' => '$refresh', 'cancelForm' => 'cancel'];

    public function cancel()
    {
        $this->showForm = false;
    }
    public function editVehicle($id)
    {
        $this->showForm = true;
        $this->dispatch('showEditForm', $id);
    }
    public function mount($vehicleId)
    {
        // Eager load all relationships for performance
        $this->vehicle = Vehicle::find($vehicleId)->load([
            'brand',
            'vehicleModel',
            'bodyType',
            'fuelType',
            'transmission'
        ]);
    }

    public function render()
    {
        // This makes it a "Full Page" component, rendering within your main layout.
        return view('livewire.admin.vehicle.vehicle-detail-component');
    }
}
