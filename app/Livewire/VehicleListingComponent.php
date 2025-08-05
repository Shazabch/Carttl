<?php

namespace App\Livewire;

use App\Models\Vehicle;
use Livewire\Component;

class VehicleListingComponent extends Component
{

    public $vehicles = [];
    public $section = 'Vehicles';

    public function mount($section)
    {
        $this->section = $section;

    }

    public function render()
    {

        $query = Vehicle::where('is_featured', 1);
        if ($this->section == 'Auctions') {
            $query->where('is_auction', 1)
                ->with('latestBid', 'bids'); // Eager load only for auctions
        } else {
            $query->where(function ($q) {
                $q->where('is_auction', 0)
                    ->orWhereNull('is_auction');
            });
        }
        $this->vehicles = $query->get();

        return view('livewire.vehicle-listing-component');
    }
}
