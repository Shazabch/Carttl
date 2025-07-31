<?php

namespace App\Livewire;

use App\Models\Vehicle;
use Livewire\Component;

class VehicleListingComponent extends Component
{

    public $vehicles = [];
    public $section ='Vehicles';

    public function mount($section)
    {
        $this->section=$section;
        if($section=='Auctions'){
             $this->vehicles = Vehicle::all();
        }else{
             $this->vehicles = Vehicle::all();
        }
       
    }

    public function render()
    {

        return view('livewire.vehicle-listing-component');
    }
}
