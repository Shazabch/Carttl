<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\VehicleController;
use App\Models\Vehicle;

// Vehicle Routes
Route::controller(VehicleController::class)->group(function () {
    Route::get('all-makes', 'getAllMakes')->name('all.makes');
    Route::get('all-vehicles', 'getAllVehicles')->name('all.vehicles');
    Route::get('auction-vehicles', 'getAuctionVehicles')->name('auction.vehicles');
    Route::get('buy-vehicles', 'getBuyVehicles')->name('buy.vehicles');
    Route::get('/models/{makeId}','getModelsByMake')->name('models');
});
