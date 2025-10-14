<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\User;
use App\Models\Vehicle;
use App\Models\VehicleModel;

class VehicleController extends Controller
{
    public function getAllMakes()
    {
        $makes = Brand::whereHas('vehicleModels')->get();

        return response()->json([
            'status' => 'success',
            'data' => $makes,
        ]);
    }
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
}
