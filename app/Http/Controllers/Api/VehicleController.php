<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Feature;
use App\Models\User;
use App\Models\Vehicle;
use App\Models\VehicleModel;

class VehicleController extends Controller
{

    //Makes
    public function getAllMakes()
    {
        $makes = Brand::whereHas('vehicleModels')->get();

        return response()->json([
            'status' => 'success',
            'data' => $makes,
        ]);
    }

    public function featuredMakes()
    {
        $featured_makes = Brand::where('is_active', true)->take(12)->get();

        return response()->json([
            'status' => 'success',
            'data' => $featured_makes,
        ]);
    }




    //Models
    public function getModelsByMake($makeId)
    {
        $models = VehicleModel::where('brand_id', $makeId)
            ->select('id', 'name')
            ->get();

        if ($models->isEmpty()) {
            return response()->json([
                'status' => 'error',
                'message' => 'No models found for this make.',
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'data' => $models,
        ]);
    }

    //Years
    public function getYears()
    {
        $years = getYears();

        return response()->json([
            'status' => 'success',
            'data' => $years,
        ]);
    }


    //Vehicles
    public function getAllVehicles()
    {
        $vehicles = Vehicle::with([
            'brand:id,name,image_source',
            'vehicleModel:id,name'
        ])->get();



        return response()->json([
            'status' => 'success',
            'data' => $vehicles,
        ]);
    }
    public function featuredVehicles()
    {
        $featured_vehicles = Vehicle::where('is_auction', 0)->where('status', 'published')->where('is_featured', 1)->with([
            'brand:id,name,image_source',
            'vehicleModel:id,name'
        ])->orderBy('id', 'desc')->take(4)->get();;



        return response()->json([
            'status' => 'success',
            'data' => $featured_vehicles,
        ]);
    }
    public function getSoldVehicles()
    {
        $sold_vehicles = Vehicle::where('status', 'sold')->with([
            'brand:id,name,image_source',
            'vehicleModel:id,name'
        ])->get();



        return response()->json([
            'status' => 'success',
            'data' => $sold_vehicles,
        ]);
    }
    public function getBuyVehicles()
    {
        $buy_vehicles = Vehicle::where('is_auction', 0)->where('status', 'published')->with([
            'brand:id,name,image_source',
            'vehicleModel:id,name'
        ])->get();



        return response()->json([
            'status' => 'success',
            'data' => $buy_vehicles,
        ]);
    }

    public function detail($id)
    {
        $vehicle = Vehicle::with(['features:id,name,type', 'images', 'brand:id,name,image_source', 'vehicleModel:id,name'])
            ->find($id);

        if (!$vehicle) {
            return response()->json([
                'status' => 'error',
                'message' => 'Vehicle not found.',
            ], 404);
        }

        
        $allExterior = Feature::where('type', 'exterior')->get(['id', 'name']);
        $allInterior = Feature::where('type', 'interior')->get(['id', 'name']);

      
        $interiorFeatures = $vehicle->features
            ->where('type', 'interior')
            ->map(fn($f) => ['id' => $f->id, 'name' => $f->name])
            ->values();

        $exteriorFeatures = $vehicle->features
            ->where('type', 'exterior')
            ->map(fn($f) => ['id' => $f->id, 'name' => $f->name])
            ->values();

        $tags = $vehicle->features
            ->where('type', 'tag')
            ->map(fn($f) => ['id' => $f->id, 'name' => $f->name])
            ->values();

       
        $mainImage = optional($vehicle->coverImage)->path ?? null;

        return response()->json([
            'status' => 'success',
            'data' => [
                'vehicle' => $vehicle,
                'main_image' => $mainImage,
                'tags' => $tags,
                'exterior_features' => $exteriorFeatures,
                'interior_features' => $interiorFeatures,
                'all_exterior_features' => $allExterior,
                'all_interior_features' => $allInterior,
            ],
        ]);
    }




    //Auctions
    public function getAuctionVehicles()
    {
        $auction_vehicles = Vehicle::where('is_auction', 1)->where('status', 'published')->with([
            'brand:id,name,image_source',
            'vehicleModel:id,name'
        ])->get();



        return response()->json([
            'status' => 'success',
            'data' => $auction_vehicles,
        ]);
    }
    public function featuredAuctions()
    {
        $featured_auctions = Vehicle::where('is_auction', 1)->where('status', 'published')->where('is_featured', 1)->with([
            'brand:id,name,image_source',
            'vehicleModel:id,name'
        ])->orderBy('id', 'desc')->take(4)->get();;



        return response()->json([
            'status' => 'success',
            'data' => $featured_auctions,
        ]);
    }
}
