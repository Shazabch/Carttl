<?php

namespace App\Livewire\Admin\Sell;
use App\Models\SaleEnquiry;
use App\Models\SaleEnquiryImage;
use Livewire\WithFileUploads;
use Livewire\Component;

class SellManagementComponent extends Component
{
    use WithFileUploads;
    public $name, $number, $brand_id, $make_id, $mileage, $specification, $faq, $notes;
    public $images = [];



    public function save()
    {
        $validated = $this->validate([
            'name' => 'nullable|string',
            'number' => 'nullable|string',
            'brand_id' => 'nullable|string',
            'make_id' => 'nullable|string',
            'mileage' => 'nullable|string',
            'specification' => 'nullable|string',
            'faq' => 'nullable|string',
            'notes' => 'nullable|string',
            'images.*' => 'nullable|image|max:2048',
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

        $this->dispatch('reset-filepond');

        return redirect()->route('admin.sell.index');
    }
    }

