<?php

namespace App\Livewire;

use App\Models\SaleEnquiry;
use App\Models\SaleEnquiryImage;
use Livewire\WithFileUploads;
use Livewire\Component;
use App\Models\Brand;
use App\Models\VehicleModel;

class SellCarComponent extends Component
{
    use WithFileUploads;

    // Step 1: Car Details
    public $brand_id, $make_id, $year, $mileage, $specification, $faq, $notes;

    // Step 2: Personal Info
    public $name, $number, $email;


    // Step 3: Images
    public $images = [];

    // Helpers
    public $brands = [], $models = [];
    public bool $formSubmitted = false;
    public int $currentStep = 1;

    public function mount()
    {
        $this->brands = Brand::orderBy('name')->get();
        $this->models = collect();
    }

    // This runs when the brand_id is updated
    public function updatedBrandId($brand_id)
    {
        if ($brand_id) {
            $this->models = VehicleModel::where('brand_id', $brand_id)->orderBy('name')->get();
        } else {
            $this->models = collect();
        }

        $this->reset('make_id');
    }

    // Validation rules for each step
    public function getRules()
    {
        if ($this->currentStep === 1) {

            return [
                'brand_id'      => 'required|exists:brands,id',
                'make_id'       => 'required|exists:vehicle_models,id',
                'year'       => 'required',
                'mileage'       => 'required',
                'specification' => 'required',
                'faq'           => 'nullable',
                'notes'         => 'nullable',
            ];
        } elseif ($this->currentStep === 2) {
            return [
                'name'   => 'required',
                'number' => 'required',
                'email' => 'required',
            ];
        }
        return []; // No validation needed for step 3 navigation
    }

    // Go to the next step
    public function nextStep()
    {
        $this->validate($this->getRules());
        $this->currentStep++;
    }

    // Go to the previous step
    public function previousStep()
    {
        $this->currentStep--;
    }

    // Final submission
    public function save()
    {

        $validated = $this->validate([

            'name'          => 'required',
            'number'        => 'required',
            'email'        => 'required',
            'brand_id'      => 'required|exists:brands,id',
            'make_id'       => 'required|exists:vehicle_models,id',
            'year'       => 'required',
            'mileage'       => 'required',
            'specification' => 'required',
            'faq'           => 'nullable',
            'notes'         => 'nullable',
            // 'images'        => 'required|array|min:1|max:6',
            // 'images.*'      => 'image|max:2048',
        ]);

        // Create the main enquiry record
        $sale = SaleEnquiry::create([
            'name'          => $this->name,
            'email'          => $this->email,
            'number'        => $this->number,
            'brand_id'      => $this->brand_id,
            'make_id'       => $this->make_id,
            'year'       => $this->year,
            'mileage'       => $this->mileage,
            'specification' => $this->specification,
            // 'faq'           => $this->faq,
            'notes'         => $this->notes,
        ]);

        // Store images and prepare data for the images table
        $imagePaths = [];
        foreach ($this->images as $index => $image) {
            // The column name will be image1, image2, etc.
            $imageColumn = 'image' . ($index + 1);
            $imagePaths[$imageColumn] = $image->store('sale-enquiries', 'public');
        }

        // Create the associated image record
        SaleEnquiryImage::create(array_merge(
            ['sale_enquiry_id' => $sale->id],
            $imagePaths
        ));

        // Show success message and reset
        $this->formSubmitted = true;
        $this->dispatch('reset-filepond');
    }

    public function render()
    {
        return view('livewire.sell-car-component');
    }
}
