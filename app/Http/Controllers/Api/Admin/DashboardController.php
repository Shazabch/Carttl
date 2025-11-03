<?php
namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\InspectionEnquiry;
use App\Models\Vehicle;
use App\Models\VehicleEnquiry;
use App\Models\VehicleBid;
use Illuminate\Http\JsonResponse;

class DashboardController extends Controller
{
    public function index(): JsonResponse
    {
        $vehicleCount         = Vehicle::count();
        $inspectionCount      = InspectionEnquiry::count();
        $listingCount         = Vehicle::where('status', 'published')->where('status', '!=', 'sold')->count();
        $verifiedCount        = Vehicle::where('status', 'published')->where('status', '!=', 'sold')->count();
        $pendingCount         = Vehicle::where('status', 'pending')->where('status', '!=', 'sold')->count();
        $rejectedCount        = Vehicle::where('status', 'rejected')->where('status', '!=', 'sold')->count();
        $auctionCount         = Vehicle::where('is_auction', true)->where('status', '!=', 'sold')->count();
        $soldVehicleCount     = Vehicle::where('status', 'sold')->count();
        $purchaseEnquiryCount = VehicleEnquiry::where('type', 'purchase')->count();
        $sellEnquiryCount     = VehicleEnquiry::where('type', 'sale')->count();

         $activeauctionCount = Vehicle::where('is_auction', true)
        ->where('status', '!=', 'sold')
        ->where('auction_start_date', '<=', now())
        ->where('auction_end_date', '>=', now())
        ->count();
        $nextAuction = Vehicle::where('is_auction', true)
        ->where('status', '!=', 'sold')
        ->where('auction_start_date', '>', now())
        ->orderBy('auction_start_date', 'asc')
        ->select('id', 'title', 'auction_start_date', 'auction_end_date')
        ->first();

        $user = auth('api')->user();
        if (!$user) {
            return response()->json([
                'status' => 'error',
                'message' => 'Unauthorized access',
            ], 401);
        }
        $profile = [
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'role' => $user->role ?? 'Admin',
            'created_at' => $user->created_at,
        ];
         $topBids = VehicleBid::with([
            'vehicle' => function ($query) {
                $query->select('id', 'title', 'brand_id', 'vehicle_model_id', 'year', 'status', 'price')
                      ->with([
                          'brand:id,name',
                          'vehicleModel:id,name'
                      ]);
            }
        ])
        ->orderByDesc('bid_amount')
        ->take(3)
        ->get(['id', 'vehicle_id', 'bid_amount', 'created_at']);
         $recentListings = Vehicle::with([
            'brand:id,name',
            'vehicleModel:id,name'
        ])
        ->where('status', 'published')
        ->where('is_auction', false)
        ->orderByDesc('created_at')
        ->take(3)
        ->get(['id', 'title', 'brand_id', 'vehicle_model_id', 'year', 'price', 'status', 'created_at']);

        return response()->json([
            'status'  => 'success',
            'message' => 'Dashboard statistics fetched successfully.',
            'data'    => [
                'total_vehicles'     => $vehicleCount,
                'vehicles'           => $listingCount,
                'sold_vehicles'      => $soldVehicleCount,
                'verified_listings'  => $verifiedCount,
                'pending_listings'   => $pendingCount,
                'rejected_listings'  => $rejectedCount,
                'auctions'           => $auctionCount,
                'active_auctions'    => $activeauctionCount,
                'next_auction'       => $nextAuction,
                'inspections_enquiries'   => $inspectionCount,
                'purchase_enquiries' => $purchaseEnquiryCount,
                'sell_enquiries'     => $sellEnquiryCount,
                'profile'     => $profile,
                'top_bids'     => $topBids,
                 'recent_listings'       => $recentListings,
            ],
        ]);
    }
}
