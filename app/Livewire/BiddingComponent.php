<?php

namespace App\Livewire;

use App\Models\VehicleBid;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class BiddingComponent extends Component
{
    public $selected_vehicle;
    public $tags;
    public $vehicleId;
    public $current_bid;
    public $totalBids;
    public $highestBid;
    public $max_bid;
    public $formSubmitted;
    public $bids = [];

    public function mount($selected_vehicle)
    {
        $this->selected_vehicle = $selected_vehicle;
        $this->tags = $this->selected_vehicle->features->where('type', 'tag');

        $this->totalBids = VehicleBid::where('vehicle_id', $this->selected_vehicle->id)->count();
        $this->highestBid = VehicleBid::where('vehicle_id', $this->selected_vehicle->id)->max('bid_amount') ?? 0;

        $this->bids = VehicleBid::with('user')
            ->where('vehicle_id', $this->selected_vehicle->id)
            ->latest()
            ->take(3)
            ->get();
    }

    public function saveBid()
    {
        $vehicle = $this->selected_vehicle;

       
        $highestBid = VehicleBid::where('vehicle_id', $vehicle->id)->max('bid_amount');
        $minimumBid = $highestBid ? $highestBid + 1 : $vehicle->starting_bid_amount;

       
        $this->validate([
            'current_bid' => "required|numeric|min:$minimumBid",
            'max_bid'     => "nullable|numeric|gte:current_bid",
        ], [
            'current_bid.min' => "Your bid must be greater than $" . number_format($minimumBid),
        ]);

        try {
            VehicleBid::create([
                'bid_amount' => $this->current_bid,
                'max_bid'    => $this->max_bid,
                'vehicle_id' => $vehicle->id,
                'user_id'    => auth()->id(),
            ]);

            

           
            $this->reset(['current_bid', 'max_bid']);
            $this->mount($vehicle); 
        } catch (\Exception $e) {
            Log::error('Bid placement failed: ' . $e->getMessage());
            session()->flash('error', 'An unexpected error occurred. Please try again later.');
        }
    }

    public function render()
    {
        return view('livewire.bidding-component');
    }
}
