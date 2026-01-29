<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Vehicle;
use App\Models\VehicleBid;
use App\Notifications\BidConfirmation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;

class BidManagementController extends Controller
{

    public function index(Request $request)
    {
        $user = auth('api')->user();
        $search = $request->get('search', '');
        $filterStatus = $request->get('status', 'all');
        $vehicleId = $request->get('vehicle_id', null);
        $perPage = $request->get('per_page', 10);

        $query = VehicleBid::with(['user:id,name,email', 'vehicle:id,title,is_auction'])
            ->orderBy('created_at', 'desc');

        // Agent role restriction - show bids from their assigned customers
        if ($user && $user->hasRole('agent')) {
            $query->whereHas('user', fn($q) =>
                $q->where('agent_id', $user->id)
            );
        }

        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('bid_amount', 'like', "%{$search}%")
                    ->orWhereHas('user', function ($sub) use ($search) {
                        $sub->where('name', 'like', "%{$search}%")
                            ->orWhere('email', 'like', "%{$search}%");
                    })
                    ->orWhereHas('vehicle', function ($sub) use ($search) {
                        $sub->where('title', 'like', "%{$search}%");
                    });
            });
        }


        if ($filterStatus !== 'all') {
            $query->where('status', $filterStatus);
        }


        if (!empty($vehicleId)) {
            $query->where('vehicle_id', $vehicleId);
        }

        $bids = $query->paginate($perPage);

        return response()->json([
            'status' => 'success',
            'data' => $bids,
        ]);
    }

    public function auctionVehiclesForFilter()
    {
        $vehicles = Vehicle::where('is_auction', 1)
            ->with([
                'brand:id,name',
                'vehicleModel:id,name'
            ])
            ->select('id', 'title', 'brand_id', 'vehicle_model_id')
            ->orderBy('title')
            ->get()
            ->map(function ($vehicle) {
                return [
                    'id' => $vehicle->id,
                    'title' => $vehicle->title,
                    'brand_name' => $vehicle->brand->name ?? null,
                    'model_name' => $vehicle->vehicleModel->name ?? null,
                ];
            });

        return response()->json([
            'status' => 'success',
            'data' => $vehicles,
        ]);
    }
    public function show($id)
    {
        $bid = VehicleBid::with(['user:id,name,email', 'vehicle:id,title'])
            ->findOrFail($id);

        return response()->json([
            'status' => 'success',
            'data' => $bid,
        ]);
    }



    public function approveBid($id)
    {
        $bid = VehicleBid::findOrFail($id);

        // Only approve if not already accepted
        if ($bid->status !== 'accepted') {
            $bid->status = 'accepted';
            $bid->save();

            // Find vehicle using vehicle_id from bid
            $vehicle = Vehicle::find($bid->vehicle_id);
            if ($vehicle) {
                $vehicle->status = 'bid_approved';
                $vehicle->save();
            }

            // Send notification to the user
            if ($bid->user) {
                Notification::send($bid->user, new BidConfirmation($bid));
            }

            return response()->json([
                'status' => 'success',
                'message' => 'Bid approved successfully.',
                'data' => $bid,
            ]);
        }

        return response()->json([
            'status' => 'info',
            'message' => 'Bid is already approved.',
            'data' => $bid,
        ]);
    }

    public function reject($id)
    {
        $bid = VehicleBid::findOrFail($id);
        $bid->status = 'rejected';
        $bid->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Bid rejected successfully.',
            'data' => $bid,
        ]);
    }


    public function destroy($id)
    {
        $bid = VehicleBid::findOrFail($id);
        $bid->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Bid deleted successfully.',
        ]);
    }

    public function bulkDelete(Request $request)
    {
        $ids = $request->get('ids', []);

        if (empty($ids)) {
            return response()->json([
                'status' => 'error',
                'message' => 'No bids selected.',
            ], 400);
        }

        VehicleBid::whereIn('id', $ids)->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Selected bids deleted successfully.',
        ]);
    }
}
