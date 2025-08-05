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
    protected function rules()
    {
        return [

            'current_bid' => 'required',

            'max_bid' => 'required',
        ];
    }
    public function mount($selected_vehicle)
    {
        $this->selected_vehicle = $selected_vehicle;
        $this->tags = $this->selected_vehicle->features->where('type', 'tag');
        $this->totalBids = VehicleBid::where('vehicle_id', $this->selected_vehicle->id)->count();
        $this->highestBid = VehicleBid::where('vehicle_id', $this->selected_vehicle->id)->max('bid_amount') ?? 0;
        $this->bids = VehicleBid::orderBy('id', 'desc')->where('vehicle_id', $this->selected_vehicle->id)->take(3)->get();
    }
    public function saveBid()
    {

        $this->validate();
        try {

            VehicleBid::create([
                'bid_amount'     => $this->current_bid,
                'max_bid'     => $this->max_bid,
                'vehicle_id' => $this->selected_vehicle->id,
                'user_id'    => auth()->id(),
            ]);


            session()->flash('message', 'Your bid has been placed successfully!');


            $this->reset(['current_bid', 'max_bid']);

            $this->mount($this->selected_vehicle);
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
