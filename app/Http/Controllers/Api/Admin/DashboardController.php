<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\InspectionEnquiry;
use App\Models\Vehicle;
use App\Models\VehicleEnquiry;
use App\Models\VehicleBid;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;

class DashboardController extends Controller
{
    public function index(): JsonResponse
    {
        // Dubai timezone now
        $nowDubai = Carbon::now('Asia/Dubai');
        $startOfWeekDubai = $nowDubai->copy()->startOfWeek(Carbon::SUNDAY);

        // Convert to UTC for DB queries (DB stores timestamps in UTC)
        $nowUTC = $nowDubai->copy()->setTimezone('UTC');
        $startOfWeekUTC = $startOfWeekDubai->copy()->setTimezone('UTC');

        // Counts
        $appointmentCount      = InspectionEnquiry::count();
        $auctionCount          = Vehicle::where('is_auction', true)
                                       ->where('status', 'published')
                                       ->count();
        $purchaseEnquiryCount  = VehicleEnquiry::where('type', 'purchase')->count();
        $sellEnquiryCount      = VehicleEnquiry::where('type', 'sale')->count();

        $upcomingCount = Vehicle::where('status', 'published')
            ->where('is_auction', true)
            ->where('auction_start_date', '>', $nowUTC)
            ->count();

        $liveCount = Vehicle::where('status', 'published')
            ->where('is_auction', true)
            ->where('auction_start_date', '<=', $nowUTC)
            ->where('auction_end_date', '>=', $nowUTC)
            ->count();

        $expiredCount = Vehicle::where('status', 'published')
            ->where('is_auction', true)
            ->where('auction_end_date', '<', $nowUTC)
            ->count();

        $listedThisMonthCount = Vehicle::where('status', 'published')
            ->where('is_auction', true)
            ->whereMonth('auction_end_date', $nowDubai->month)
            ->whereYear('auction_end_date', $nowDubai->year)
            ->where('auction_end_date', '<', $nowUTC)
            ->count();

        // Payment processing vehicles
        $paymentProcessing = Vehicle::where('status', 'pending_payment')
            ->where('is_auction', true)
            ->with(['brand:id,name', 'vehicleModel:id,name'])
            ->latest()
            ->take(3)
            ->get();

        $intransfer = Vehicle::where('status', 'intransfer')
            ->where('is_auction', true)
            ->with(['brand:id,name', 'vehicleModel:id,name'])
            ->latest()
            ->take(3)
            ->get();

        // Delivered this week
        $deliveredCount = Vehicle::where('status', 'delivered')
            ->where('is_auction', true)
            ->whereBetween('updated_at', [$startOfWeekUTC, $nowUTC])
            ->count();

        $latestDelivered = Vehicle::where('status', 'delivered')
            ->where('is_auction', true)
            ->whereBetween('updated_at', [$startOfWeekUTC, $nowUTC])
            ->with(['brand:id,name', 'vehicleModel:id,name'])
            ->orderBy('updated_at', 'desc')
            ->take(3)
            ->get();

        // Next auction
        $nextAuction = Vehicle::where('is_auction', true)
            ->where('status', 'published')
            ->where('auction_start_date', '>', $nowUTC)
            ->orderBy('auction_start_date', 'asc')
            ->select('id', 'title', 'auction_start_date', 'auction_end_date')
            ->first();

        // Authenticated user profile
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

        // Top bids
        $topBids = VehicleBid::with([
            'vehicle' => function ($query) {
                $query->select('id', 'title', 'brand_id', 'vehicle_model_id', 'year', 'status', 'price')
                    ->with(['brand:id,name', 'vehicleModel:id,name']);
            }
        ])
        ->orderByDesc('bid_amount')
        ->take(3)
        ->get(['id', 'vehicle_id', 'bid_amount', 'created_at']);

        // Recent listings
        $recentListings = Vehicle::with(['brand:id,name', 'vehicleModel:id,name'])
            ->where('status', 'published')
            ->where('is_auction', true)
            ->orderByDesc('created_at')
            ->take(3)
            ->get(['id', 'title', 'brand_id', 'vehicle_model_id', 'year', 'price', 'status', 'created_at']);

        return response()->json([
            'status'  => 'success',
            'message' => 'Dashboard statistics fetched successfully.',
            'data'    => [
                'upcoming_count'            => $upcomingCount,
                'listed_count'              => $expiredCount,
                'live_count'                => $liveCount,
                'auction_count'             => $auctionCount,
                'delivered_this_week_count' => $deliveredCount,
                'delivered_this_week'       => $latestDelivered,
                'listed_this_month'         => $listedThisMonthCount,
                'next_auction'              => $nextAuction,
                'profile'                   => $profile,
                'recent_listings'           => $recentListings,
                'top_bids'                  => $topBids,
                'payment_processing'        => $paymentProcessing,
                'intransfer'                => $intransfer,
                'appointment_count'         => $appointmentCount,
                'purchase_enquiries'        => $purchaseEnquiryCount,
                'sell_enquiries'            => $sellEnquiryCount,
            ],
        ]);
    }
}
