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
    public $reserve_status;
    public $endingSoon;
    public $auctionStatus = [];
    public $brands = [], $models = [];
    public $section = 'Vehicles';

    protected string $paginationTheme = 'bootstrap';


    protected $queryString = [
        'sortBy'        => ['except' => 'ending_soon'],
        'minPrice'      => ['except' => null],
        'maxPrice'      => ['except' => null],
        'make'          => ['except' => null],
        'model'         => ['except' => null],
        'year'          => ['except' => null],
        'mileage'       => ['except' => null],
        'live_auction'  => ['except' => null],
        'reserve_status' => ['except' => null],
        'endingSoon'    => ['except' => null],
        'auctionStatus' => ['except' => []],
    ];


    public function updating($property, $value)
    {
        $this->resetPage();
    }

    public function mount($section)
    {
        $this->brands = Brand::orderBy('name')->get();
        $this->section = $section;
    }

    public function updatedMake($value)
    {
        $this->models = $value
            ? VehicleModel::where('brand_id', $value)->get()
            : [];
    }

    public function resetAll()
    {
        $this->minPrice = null;
        $this->maxPrice = null;
        $this->make = null;
        $this->model = null;
        $this->mileage = null;
        $this->auctionStatus = [];
        $this->year = null;
        $this->live_auction = null;
        $this->reserve_status = null;
        $this->endingSoon = null;
        $this->sortBy = 'ending_soon';
    }

    public function render()
    {
        $vehiclesQuery = Vehicle::query();
        $vehiclesQuery->orderBy('created_at', 'desc');

        // Section filter
        if ($this->section === 'Auctions') {
            $vehiclesQuery->where('is_auction', 1)->where('status', '!=', 'sold');
        } else {
            $vehiclesQuery->where(function ($q) {
                $q->where('is_auction', 0)->where('status', '!=', 'sold')
                    ->orWhereNull('is_auction');
            });
        }

        // Sorting
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

        // Price filter
        if ($this->minPrice) {
            $vehiclesQuery->where('price', '>=', $this->minPrice);
        }
        if ($this->maxPrice) {
            $vehiclesQuery->where('price', '<=', $this->maxPrice);
        }

        // Brand / Model
        if ($this->make) {
            $vehiclesQuery->where('brand_id', $this->make);
        }
        if ($this->model) {
            $vehiclesQuery->where('vehicle_model_id', $this->model);
        }

        // Year
        if ($this->year) {
            $vehiclesQuery->where('year', $this->year);
        }

        // Live auction
        if ($this->live_auction) {
            $vehiclesQuery->where('live_auction', $this->live_auction);
        }

        // Reserve met
        if ($this->reserve_status) {
            $vehiclesQuery->where('reserve_status', 'met');
        }

        // Ending soon
        if ($this->endingSoon) {
            $vehiclesQuery->where('auction_end_date', '<', now()->addDay());
        }

        // Mileage
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

        $vehicles = $vehiclesQuery->paginate(2)->withQueryString();

        return view('livewire.vehicle-and-auction-component', [
            'vehicles' => $vehicles,
        ]);
    }
}
