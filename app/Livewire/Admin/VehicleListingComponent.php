<?php

namespace App\Livewire\Admin;

use App\Models\BodyType;
use App\Models\Brand;
use App\Models\FuelType;
use App\Models\Transmission;
use App\Models\Vehicle;
use App\Models\VehicleModel;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithPagination;

class VehicleListingComponent extends Component
{
    use WithPagination;

    public $showForm = false;
    public $search = '';
    protected $listeners = ['vehicleSaved' => '$refresh','cancelForm' => 'cancel', 'deleteVehicle' => 'delete'];
    public function mount() {}
    public function addNew()
    {
        $this->showForm = true;
        $this->dispatch('showCreateForm');
    }
    public function cancel()
    {
        $this->showForm = false;
    }
    public function editVehicle($id)
    {
        $this->showForm = true;
        $this->dispatch('showEditForm', $id);
    }

    public function delete($id)
    {
        Vehicle::findOrFail($id)->delete();

          $this->dispatch('success-notification', [
                'message' => 'Vehicle deleted successfully.'
            ]);
    }
    public function render()
    {
        $vehicles = Vehicle::where('title', 'like', '%' . $this->search . '%')
            ->orWhere('vin', 'like', '%' . $this->search . '%')
            ->with('brand', 'vehicleModel')
            ->latest()
            ->paginate(10);

        return view('livewire.admin.vehicle-listing-component', compact('vehicles'));
    }
}
