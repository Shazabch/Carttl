<?php

namespace App\Livewire;

use App\Models\Vehicle;
use Livewire\Component;
use Livewire\WithPagination;


class VehicleAndAuctionComponent extends Component

{
    use WithPagination;
    public $minPrice;
    public $maxPrice;
    public $make;
    public $model;
    public $year;
    public $mileage;
    public $auctionStatus = [];
    public $section = 'Vehicles';
    protected string $paginationTheme = 'bootstrap';
    protected $queryString = [
        'minPrice',
        'maxPrice',
        'make',
        'model',
        'year',
        'mileage',
        'auctionStatus'
    ];
    public function updated($property)
    {
        $this->resetPage();
    }

    public function mount($section)
    {
        $this->section = $section;
    }

    public function render()
    {
        $vehiclesQuery = Vehicle::query();

        if ($this->section == 'Auctions') {
            $vehiclesQuery->where('is_auction', 1);
        } else {
            // $vehiclesQuery->where('is_auction', 0);
        }
        if ($this->year) {
            $vehiclesQuery->where('year', $this->year);
        }


        $vehicles = $vehiclesQuery->paginate(10);

        return view('livewire.vehicle-and-auction-component', [
            'vehicles' => $vehicles,
        ]);
    }
}
