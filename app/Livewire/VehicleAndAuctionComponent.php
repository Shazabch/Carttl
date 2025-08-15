<?php

namespace App\Livewire;

use App\Models\Brand;
use App\Models\Vehicle;
use App\Models\VehicleModel;
use Livewire\Component;
use Livewire\WithPagination;


class VehicleAndAuctionComponent extends Component

{
    use WithPagination;
    public $sortBy = 'ending_soon';
    public $minPrice;
    public $maxPrice;
    public $make;
    public $model;
    public $year;
    public $mileage;
    public $live_auction;
    public $endingSoon;
    public $auctionStatus = [];
    public $brands = [], $models = [];
    public $section = 'Vehicles';
    protected string $paginationTheme = 'bootstrap';

    protected $queryString = [
        'minPrice',
        'maxPrice',
        'make',
        'model',
        'year',
        'mileage',
        'live_auction',
        'endingSoon',
        'auctionStatus'
    ];
    public function updated($property)
    {
        $this->resetPage();
    }

    public function mount($section)
    {
        $this->brands =  Brand::orderBy('name')->get();
        // $this->models =  VehicleModel::orderBy('name')->get();


        $this->section = $section;
    }
    public function updatedMake($value)
    {
        if ($value) {

            $this->models = VehicleModel::where('brand_id', $value)->get();
        } else {
            $this->models = [];
        }
    }
    public function updatedSortBy()
    {
        $this->resetPage();
    }

    public function resetAll()
    {
        $this->minPrice = null;
        $this->maxPrice = null;
        $this->make = null;
        $this->model = null;
        $this->mileage = null;
        $this->auctionStatus = null;
        $this->year = null;
    }

    public function render()
    {
        $vehiclesQuery = Vehicle::query();

        if ($this->section == 'Auctions') {
            $vehiclesQuery->where('is_auction', 1)->where('status','!=', 'sold');
        } else {

            $vehiclesQuery->where(function ($q) {
                $q->where('is_auction', 0)->where('status','!=', 'sold')->orWhereNull('is_auction');
            });
        }
        switch ($this->sortBy) {
            case 'price_low_high':
                $vehiclesQuery->orderBy('price', 'asc');
                break;
            case 'price_high_low':
                $vehiclesQuery->orderBy('price', 'desc');
                break;
            case 'year_newest':
                $vehiclesQuery->orderBy('year', 'desc');
                break;
            case 'mileage_low_high':
                $vehiclesQuery->orderBy('mileage', 'asc');
                break;

            case 'ending_soon':
            default:
                $vehiclesQuery->orderBy('auction_end_date', 'asc');
                break;
        }
        if ($this->minPrice) {
            $vehiclesQuery->where('price', '>=', $this->minPrice);
        }
        if ($this->maxPrice) {
            $vehiclesQuery->where('price', '<=', $this->maxPrice);
        }

        if ($this->make) {
            $vehiclesQuery->where('brand_id', $this->make);
        }


        if ($this->model) {
            $vehiclesQuery->where('vehicle_model_id', $this->model);
        }


        if ($this->year) {
            $vehiclesQuery->where('year', $this->year);
        }
        if ($this->live_auction) {
            $vehiclesQuery->where('live_auction', $this->live_auction);
        }
        if ($this->endingSoon) {
            $vehiclesQuery->where('auction_end_date', '<', now()->addDay());
        }


        if ($this->mileage) {
            if ($this->mileage === 'under10k') {
                $vehiclesQuery->where('mileage', '<', 10000);
            } elseif ($this->mileage === '10k-25k') {
                $vehiclesQuery->whereBetween('mileage', [10000, 25000]);
            } elseif ($this->mileage === '25k-50k') {
                $vehiclesQuery->whereBetween('mileage', [25000, 50000]);
            } elseif ($this->mileage === 'over50k') {
                $vehiclesQuery->where('mileage', '>', 50000);
            }
        }
        if (!empty($this->auctionStatus)) {
            if (in_array('ending-soon', $this->auctionStatus)) {
                $vehiclesQuery->where('auction_end_date', '<', now()->addDay());
            }
        }



        $vehicles = $vehiclesQuery->paginate(10);


        return view('livewire.vehicle-and-auction-component', [
            'vehicles' => $vehicles,
        ]);
    }
}
