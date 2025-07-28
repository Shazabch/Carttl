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

class VehicleFormComponent extends Component
{
    use WithPagination;

    // --- Component State ---
    public $showForm = false;
    public $isEditing = false;
    public $currentStep = 1;
    public $search = '';
    public $vehicle_id = null;

    // --- Form Data Holder ---
    public array $vehicleData = [];

    // --- Data for Dropdowns & Selections ---
    public $brands = [], $models = [], $bodyTypes = [], $fuelTypes = [], $transmissions = [];

    protected $listeners = ['showCreateForm', 'showEditForm','addNewSelectOption' => 'handleAddNewSelectOption'];


    // All rules point to the keys in the vehicleData array.
    protected function rules()
    {
        return [
            'vehicleData.title' => 'required|string|max:255',
            'vehicleData.brand_id' => 'required|exists:brands,id',
            'vehicleData.vehicle_model_id' => 'required',
            'vehicleData.year' => 'required|integer|digits:4|min:1900|max:' . (date('Y') + 1),
            'vehicleData.price' => 'required|numeric|min:0',
            'vehicleData.mileage' => 'required|integer|min:0',
            'vehicleData.transmission_id' => 'required|exists:transmissions,id',
            'vehicleData.fuel_type_id' => 'required|exists:fuel_types,id',
            'vehicleData.body_type_id' => 'required|exists:body_types,id',
            'vehicleData.condition' => 'required|in:new,used,certified',
            'vehicleData.status' => 'required|in:draft,published,sold,pending',
            'vehicleData.description' => 'nullable|string|max:5000',
            'vehicleData.variant' => 'nullable|string|max:255',
            'vehicleData.engine_cc' => 'nullable|integer',
            'vehicleData.horsepower' => 'nullable|integer',
            'vehicleData.torque' => 'nullable|string|max:255',
            'vehicleData.seats' => 'nullable|integer',
            'vehicleData.doors' => 'nullable|integer',
            'vehicleData.color' => 'nullable|string|max:255',
            'vehicleData.interior_color' => 'nullable|string|max:255',
            'vehicleData.drive_type' => 'nullable|string|in:FWD,RWD,AWD,4WD',
            'vehicleData.vin' => 'nullable|string|max:255',
            'vehicleData.registration_no' => 'nullable|string|max:255',
            'vehicleData.negotiable' => 'boolean',
            'vehicleData.is_featured' => 'boolean',
        ];
    }

    // This method runs once, when the component is first mounted.
    public function mount()
    {
        // Initialize the form array with default values from a blank model instance
        $this->vehicleData = (new Vehicle())->getAttributes();
        $this->vehicleData['negotiable'] = false;
        $this->vehicleData['is_featured'] = false;
        $this->vehicleData['condition'] = 'used';
        $this->vehicleData['status'] = 'draft';

        // Pre-load data for dropdowns and selections

        $this->brands =  Brand::orderBy('name')->get();
        $this->brands = $this->brands->map(function ($brand) {
            return [
                'id' => $brand->id,
                'text' => $brand->name,
            ];
        })->toArray();
        $this->bodyTypes = BodyType::all();
        $this->fuelTypes = FuelType::all();
        $this->transmissions = Transmission::all();
    }

    // The hook now works reliably with the array.
    public function updatedVehicleDataBrandId($value)
    {
        if ($value) {
            $this->models = VehicleModel::where('brand_id', $value)->get();

            $this->models = $this->models->map(function ($model) {
                return [
                    'id' => $model->id,
                    'text' => $model->name,
                ];
            })->toArray();
        } else {
            $this->models = [];
        }
        $this->vehicleData['vehicle_model_id'] = null; // Reset vehicle_model_id in our data array
    }

    // --- WIZARD CONTROLS ---
    public function nextStep()
    {
        $this->validateStep($this->currentStep);
        if ($this->currentStep < 3) {
            $this->currentStep++;
        } elseif ($this->currentStep == 3) {
            $this->saveVehicle();
        }
    }

    public function prevStep()
    {
        if ($this->currentStep > 1) $this->currentStep--;
    }

    public function showCreateForm()
    {
        $this->isEditing = false;
        $this->reset();
        $this->mount();
        $this->currentStep = 1;
        $this->showForm = true;
    }

    public function showEditForm($vehicleId)
    {

        $this->isEditing = true;
        $vehicle = Vehicle::findOrFail($vehicleId);
        $this->vehicle_id = $vehicleId;
        $this->vehicleData = $vehicle->toArray();

        if ($this->vehicleData['brand_id']) {
            $this->models = VehicleModel::where('brand_id', $this->vehicleData['brand_id'])->get();
        }
        $this->currentStep = 1;
        $this->showForm = true;
    }


    public function saveVehicle()
    {
        // Run the full validation as a final check before saving
        $this->validate();

        // Add the slug if we are creating a new vehicle
        if (!$this->isEditing) {
            $this->vehicleData['slug'] = Str::slug($this->vehicleData['title']);
        }

        // Use updateOrCreate with the data array. This is clean and efficient.
        Vehicle::updateOrCreate(['id' => $this->vehicle_id], $this->vehicleData);
        $this->dispatch('success-notification', [
            'message' => $this->isEditing ? 'Vehicle updated successfully.' : 'Vehicle created successfully.'
        ]);
        $this->dispatch('vehicleSaved');

        $this->cancel();
    }

    public function cancel()
    {

        $this->dispatch('cancelForm');
        $this->showForm = false;
        $this->reset();
        $this->mount();
    }

    public function delete($id)
    {
        Vehicle::findOrFail($id)->delete();
        session()->flash('success', 'Vehicle deleted successfully.');
    }

    public function setSingleSelection(string $property, $value)
    {
        $currentValue = $this->vehicleData[$property] ?? null;
        $this->vehicleData[$property] = ($currentValue == $value) ? null : $value;
    }

    // Helper method to validate rules for a specific step.
    private function validateStep(int $step)
    {
        $rulesForStep = [];
        if ($step === 1) {
            $rulesForStep = [
                'vehicleData.title' => 'required|string|max:255',
                'vehicleData.brand_id' => 'required|exists:brands,id',
                'vehicleData.vehicle_model_id' => 'required',
                'vehicleData.year' => 'required|integer|digits:4',
                'vehicleData.price' => 'required|numeric|min:0',
            ];
        } elseif ($step === 2) {
            $rulesForStep = [
                'vehicleData.mileage' => 'required|integer|min:0',
                'vehicleData.transmission_id' => 'required|exists:transmissions,id',
                'vehicleData.fuel_type_id' => 'required|exists:fuel_types,id',
                'vehicleData.body_type_id' => 'required|exists:body_types,id',
            ];
        } elseif ($step === 3) {
            $rulesForStep = [
                'vehicleData.condition' => 'nullable',
                'vehicleData.status' => 'nullable',
            ];
        }

        $this->validate($rulesForStep);
    }
    public function handleAddNewSelectOption($text, $model, $list)
    {

        $newItemText = trim($text);
        if ($list === 'brands' && !empty($newItemText)) {
            $newItem = Brand::create([
                'name' => $newItemText,
            ]);
        } else if($list === 'models' && !empty($newItemText)) {
            $brandId = data_get($this, 'vehicleData.brand_id');
            if (!$brandId) {
                session()->flash('error', 'Please select a brand first.');
                return;
            }
            $newItem = VehicleModel::create([
                'name' => $newItemText,
                'brand_id' => $brandId,
            ]);
        } else {
            $newItem = collect();
        }
        if ($newItem !== null && $newItem->id) {
            data_set($this, $model, $newItem->id);
            $array = data_get($this, $list, []);
            $array[] = ['id' => $newItem->id, 'text' => $newItem->name];
            data_set($this, $list, $array);
        }
        $this->dispatch('re-init-select-2-component');
    }


    public function render()
    {
        $vehicles = Vehicle::where('title', 'like', '%' . $this->search . '%')
            ->orWhere('vin', 'like', '%' . $this->search . '%')
            ->with('brand', 'vehicleModel')
            ->latest()
            ->paginate(10);
        $this->dispatch('re-init-select-2-component');
        return view('livewire.admin.vehicle-form-component', compact('vehicles'));
    }
}
