<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\InspectionEnquiry;
use App\Models\User;
use App\Models\Vehicle;
use App\Models\VehicleEnquiry;
use App\Models\VehicleBid;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;

class DashboardController extends Controller
{
    public function index(): JsonResponse
    {
        $user = auth('api')->user();
        if (!$user) {
            return response()->json([
                'status' => 'error',
                'message' => 'Unauthorized access',
            ], 401);
        }

        // Check if user is an agent
        $isAgent = $user->hasRole('agent');

        // Appointment count - filter by agent's customers
        $appointmentCount = InspectionEnquiry::query()
            ->when($isAgent, fn($q) => 
                $q->whereHas('user', fn($inner) => 
                    $inner->where('agent_id', $user->id)
                )
            )
            ->count();

        // Auction count - filter by vehicles with bids from agent's customers
        $auctionCount = Vehicle::where('is_auction', true)
            ->where('status', 'published')
            ->when($isAgent, fn($q) => 
                $q->whereHas('bids', fn($b) => 
                    $b->whereHas('user', fn($u) => 
                        $u->where('agent_id', $user->id)
                    )
                )
            )
            ->count();

        // Purchase enquiry count - filter by agent's customers
        $purchaseEnquiryCount = VehicleEnquiry::where('type', 'purchase')
            ->when($isAgent, fn($q) => 
                $q->whereHas('user', fn($inner) => 
                    $inner->where('agent_id', $user->id)
                )
            )
            ->count();

        // Sell enquiry count - filter by agent's customers
        $sellEnquiryCount = VehicleEnquiry::where('type', 'sale')
            ->when($isAgent, fn($q) => 
                $q->whereHas('user', fn($inner) => 
                    $inner->where('agent_id', $user->id)
                )
            )
            ->count();

        $now = now();

        // Upcoming auctions - filter by vehicles with bids from agent's customers
        $upcomingCount = Vehicle::where('status', 'published')
            ->where('is_auction', true)
            ->where('auction_start_date', '>', $now)
            ->when($isAgent, fn($q) => 
                $q->whereHas('bids', fn($b) => 
                    $b->whereHas('user', fn($u) => 
                        $u->where('agent_id', $user->id)
                    )
                )
            )
            ->count();

        // Live auctions - filter by vehicles with bids from agent's customers
        $liveCount = Vehicle::where('status', 'published')
            ->where('is_auction', true)
            ->where('auction_start_date', '<=', $now)
            ->where('auction_end_date', '>=', $now)
            ->when($isAgent, fn($q) => 
                $q->whereHas('bids', fn($b) => 
                    $b->whereHas('user', fn($u) => 
                        $u->where('agent_id', $user->id)
                    )
                )
            )
            ->count();

        // Expired auctions - filter by vehicles with bids from agent's customers
        $expiredCount = Vehicle::where('status', 'published')
            ->where('is_auction', true)
            ->where('auction_end_date', '<', $now)
            ->when($isAgent, fn($q) => 
                $q->whereHas('bids', fn($b) => 
                    $b->whereHas('user', fn($u) => 
                        $u->where('agent_id', $user->id)
                    )
                )
            )
            ->count();

        // Listed this month - filter by vehicles with bids from agent's customers
        $listedThisMonthCount = Vehicle::where('status', 'published')
            ->where('is_auction', true)
            ->whereMonth('auction_end_date', $now->month)
            ->whereYear('auction_end_date', $now->year)
            ->where('auction_end_date', '<', $now)
            ->when($isAgent, fn($q) => 
                $q->whereHas('bids', fn($b) => 
                    $b->whereHas('user', fn($u) => 
                        $u->where('agent_id', $user->id)
                    )
                )
            )
            ->count();

        // Payment processing - filter by vehicles with bids from agent's customers
        $paymentProcessing = Vehicle::where('status', 'pending_payment')
            ->where('is_auction', true)
            ->when($isAgent, fn($q) => 
                $q->whereHas('bids', fn($b) => 
                    $b->whereHas('user', fn($u) => 
                        $u->where('agent_id', $user->id)
                    )
                )
            )
            ->with(['brand:id,name', 'vehicleModel:id,name'])
            ->latest()
            ->take(3)
            ->get();

        // In transfer - filter by vehicles with bids from agent's customers
        $intransfer = Vehicle::where('status', 'intransfer')
            ->where('is_auction', true)
            ->when($isAgent, fn($q) => 
                $q->whereHas('bids', fn($b) => 
                    $b->whereHas('user', fn($u) => 
                        $u->where('agent_id', $user->id)
                    )
                )
            )
            ->with(['brand:id,name', 'vehicleModel:id,name'])
            ->latest()
            ->take(3)
            ->get();

        // Delivered this week - filter by vehicles with bids from agent's customers
        $deliveredCount = Vehicle::where('status', 'delivered')
            ->where('is_auction', true)
            ->whereBetween('updated_at', [now()->startOfWeek(Carbon::SUNDAY), now()])
            ->when($isAgent, fn($q) => 
                $q->whereHas('bids', fn($b) => 
                    $b->whereHas('user', fn($u) => 
                        $u->where('agent_id', $user->id)
                    )
                )
            )
            ->count();

        $latestDelivered = Vehicle::where('status', 'delivered')
            ->where('is_auction', true)
            ->whereBetween('updated_at', [now()->startOfWeek(Carbon::SUNDAY), now()])
            ->when($isAgent, fn($q) => 
                $q->whereHas('bids', fn($b) => 
                    $b->whereHas('user', fn($u) => 
                        $u->where('agent_id', $user->id)
                    )
                )
            )
            ->with(['brand:id,name', 'vehicleModel:id,name'])
            ->orderBy('updated_at', 'desc')
            ->take(3)
            ->get();

        // Next auction - filter by vehicles with bids from agent's customers
        $nextAuction = Vehicle::where('is_auction', true)
            ->where('status', 'published')
            ->where('auction_start_date', '>', now())
            ->when($isAgent, fn($q) => 
                $q->whereHas('bids', fn($b) => 
                    $b->whereHas('user', fn($u) => 
                        $u->where('agent_id', $user->id)
                    )
                )
            )
            ->orderBy('auction_start_date', 'asc')
            ->select('id', 'title', 'auction_start_date', 'auction_end_date')
            ->first();
        $profile = [
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'role' => $user->role ?? 'Admin',
            'created_at' => $user->created_at,
        ];

        // Top bids - filter by bids from agent's customers
        $topBids = VehicleBid::with([
            'vehicle' => function ($query) {
                $query->select('id', 'title', 'brand_id', 'vehicle_model_id', 'year', 'status', 'price')
                    ->with([
                        'brand:id,name',
                        'vehicleModel:id,name'
                    ]);
            }
        ])
            ->when($isAgent, fn($q) => 
                $q->whereHas('user', fn($inner) => 
                    $inner->where('agent_id', $user->id)
                )
            )
            ->orderByDesc('bid_amount')
            ->take(3)
            ->get(['id', 'vehicle_id', 'bid_amount', 'created_at']);

        // Live bids - filter by bids from agent's customers
        $liveBids = VehicleBid::with([
            'vehicle' => function ($query) {
                $query->select('id', 'title', 'brand_id', 'vehicle_model_id', 'year', 'status', 'price')
                    ->with([
                        'brand:id,name',
                        'vehicleModel:id,name'
                    ]);
            }
        ])
            ->when($isAgent, fn($q) => 
                $q->whereHas('user', fn($inner) => 
                    $inner->where('agent_id', $user->id)
                )
            )
            ->orderByDesc('bid_amount')
            ->take(3)
            ->get(['id', 'vehicle_id', 'bid_amount','status', 'created_at']);

        // Recent listings - filter by vehicles with bids from agent's customers
        $recentListings = Vehicle::with([
            'brand:id,name',
            'vehicleModel:id,name'
        ])
            ->where('status', 'published')
            ->where('is_auction', true)
            ->when($isAgent, fn($q) => 
                $q->whereHas('bids', fn($b) => 
                    $b->whereHas('user', fn($u) => 
                        $u->where('agent_id', $user->id)
                    )
                )
            )
            ->orderByDesc('created_at')
            ->take(3)
            ->get(['id', 'title', 'brand_id', 'vehicle_model_id', 'year', 'price', 'status', 'created_at']);

        // Latest agents - only show for non-agents
        $latestAgents = User::where('role', 'agent')
            ->when($isAgent, fn($q) => $q->where('id', $user->id))
            ->orderByDesc('created_at')
            ->take(5)
            ->get();
        return response()->json([
            'status'  => 'success',
            'message' => 'Dashboard statistics fetched successfully.',
            'data'    => [

                'upcoming_count'  => $upcomingCount,
                'listed_count'   => $expiredCount,
                'live_count'  => $liveCount,

                'auction_count'           => $auctionCount,
                'delivered_this_week_count'           => $deliveredCount,
                'delivered_this_week'           => $latestDelivered,
                'listed_this_month'   => $listedThisMonthCount,
                'next_auction'       => $nextAuction,
                'profile'     => $profile,

                'recent_listings'       => $recentListings,
                'top_bids'     => $topBids,
                'live_bids'     => $liveBids,
                'payment_processing'           => $paymentProcessing,
                'intransfer'           => $intransfer,

                'appointment_count'   => $appointmentCount,
                'purchase_enquiries' => $purchaseEnquiryCount,
                'sell_enquiries'     => $sellEnquiryCount,
                'latest_drees' => $latestAgents,



            ],
        ]);
    }
}
