<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\PurchaseEnquiry;
use App\Models\Vehicle;

class BuyCarComponent extends Component
{
    public $selected_vehicle;
    public $vehicleId;
    
    public $name;
    public $phone;
    public $email;
    public $address;

    protected $rules = [
        'name' => 'required',
        'phone' => 'required',
        'email' => 'nullable',
        'address' => 'nullable',
    ];
    public bool $formSubmitted = false;
    public function mount($selected_vehicle){
        $this->selected_vehicle=$selected_vehicle;
    }
    public function saveBuyEnquiry()
    {
        $this->validate();

        PurchaseEnquiry::create([
            'name'       => $this->name,
            'phone'      => $this->phone,
            'email'      => $this->email,
            'address'    => $this->address,
            'vehicle_id' => $this->selected_vehicle->id,
             
        ]);
        $this->formSubmitted = true;
        session()->flash('message', 'Your inquiry has been submitted successfully!');

       
        $this->reset(['name', 'phone', 'email', 'address']);
    }

    public function render()
    {
        return view('livewire.buy-car-component');
    }
}
