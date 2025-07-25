<?php

namespace App\Livewire\Admin\Sell;
use App\Models\SaleEnquiry;
use App\Models\SaleEnquiryImage;
use Livewire\WithFileUploads;
use Livewire\Component;
use App\Models\Brand;
use App\Models\VehicleModel;

class SellManagementComponent extends Component
{
    use WithFileUploads;
    public $name, $number, $brand_id, $make_id, $mileage, $specification, $faq, $notes;
    public $images = [];
    public $brands = [], $models = [];

    public bool $formSubmitted = false;

    public function mount(){
      $this->brands = Brand::all();
      $this->models = VehicleModel::all();
    }

    public function save()
    {
        $validated = $this->validate([
            'name'          => 'required|string',
            'number'        => 'required|numeric', // Ensures it's a number
            'brand_id'      => 'required|string',
            'make_id'       => 'required|string',
            'mileage'       => 'required|numeric', // Ensures it's a number
            'specification' => 'required|string',
            'faq'           => 'required|string',
            'notes' => 'required|string|min:10',
            'images.*'      => 'required|image|max:2048',
        ]);
        $sale = SaleEnquiry::create([
            'name' => $this->name,
            'number' => $this->number,
            'brand_id' => $this->brand_id,
            'make_id' => $this->make_id,
            'mileage' => $this->mileage,
            'specification' => $this->specification,
            'faq' => $this->faq,
            'notes' => $this->notes,
        ]);

        // Upload images and save
        $imagePaths = [];
        foreach (range(0, 5) as $i) {
            if (isset($this->images[$i])) {
                $imagePaths["image" . ($i + 1)] = $this->images[$i]->store('sale-enquiries', 'public');
            } else {
                $imagePaths["image" . ($i + 1)] = null;
            }
        }

        SaleEnquiryImage::create(array_merge([
            'sale_enquiry_id' => $sale->id,
        ], $imagePaths));
        $this->reset('name', 'number', 'brand_id', 'make_id', 'mileage', 'specification', 'faq', 'notes', 'images');
        $this->formSubmitted = true;
        $this->dispatch('reset-filepond');



    }
    }

