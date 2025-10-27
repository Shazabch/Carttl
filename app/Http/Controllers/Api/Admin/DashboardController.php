<?php
namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\InspectionEnquiry;
use App\Models\Vehicle;
use App\Models\VehicleEnquiry;
use Illuminate\Http\JsonResponse;

class DashboardController extends Controller
{
    public function index(): JsonResponse
    {
        $vehicleCount         = Vehicle::count();
        $inspectionCount      = InspectionEnquiry::count();
        $listingCount         = Vehicle::where('is_auction', false)->where('status', '!=', 'sold')->count();
        $auctionCount         = Vehicle::where('is_auction', true)->where('status', '!=', 'sold')->count();
        $soldVehicleCount     = Vehicle::where('status', 'sold')->count();
        $purchaseEnquiryCount = VehicleEnquiry::where('type', 'purchase')->count();
        $sellEnquiryCount     = VehicleEnquiry::where('type', 'sale')->count();

        return response()->json([
            'status'  => 'success',
            'message' => 'Dashboard statistics fetched successfully.',
            'data'    => [
                'total_vehicles'     => $vehicleCount,
                'inspections'        => $inspectionCount,
                'vehicles'           => $listingCount,
                'auctions'           => $auctionCount,
                'sold_vehicles'      => $soldVehicleCount,
                'purchase_enquiries' => $purchaseEnquiryCount,
                'sell_enquiries'     => $sellEnquiryCount,
            ],
        ]);
    }
}
