<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;
use App\Models\VehicleBid;
use Illuminate\Support\Facades\Storage;

class BookingController extends Controller
{
    public function pendingPayments(Request $request)
    {
        $perPage = $request->get('per_page', 10);
        $search  = $request->get('search', '');

        $vehiclesQuery = Vehicle::where('status', 'pending_payment')
            ->when($search, function ($query, $search) {
                $query->whereHas('brand', function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%");
                })
                    ->orWhereHas('vehicleModel', function ($q) use ($search) {
                        $q->where('name', 'like', "%{$search}%");
                    });
            });

        $vehicles = $vehiclesQuery->with(['brand:id,name', 'vehicleModel:id,name'])
            ->paginate($perPage)
            ->through(function ($vehicle) {
                $booking = Booking::where('vehicle_id', $vehicle->id)
                    ->where('status', 'pending_payment')
                    ->first();

                return [
                    'vehicle' => $vehicle,
                    'brand' => $vehicle->brand ? [
                        'id' => $vehicle->brand->id,
                        'name' => $vehicle->brand->name
                    ] : null,
                    'model' => $vehicle->vehicleModel ? [
                        'id' => $vehicle->vehicleModel->id,
                        'name' => $vehicle->vehicleModel->name
                    ] : null,
                    'booker' => $booking ? [
                        'id' => $booking->user_id,
                        'name' => $booking->receiver_name,
                        'email' => $booking->receiver_email,
                    ] : null,
                ];
            });

        return response()->json([
            'success' => true,
            'data' => $vehicles,
        ]);
    }

    // In Transfer Vehicles
    public function inTransfers(Request $request)
    {
        $perPage = $request->get('per_page', 10);
        $search  = $request->get('search', '');

        $vehiclesQuery = Vehicle::where('status', 'intransfer')
            ->when($search, function ($query, $search) {
                $query->whereHas('brand', function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%");
                })
                    ->orWhereHas('vehicleModel', function ($q) use ($search) {
                        $q->where('name', 'like', "%{$search}%");
                    });
            });

        $vehicles = $vehiclesQuery->with(['brand:id,name', 'vehicleModel:id,name'])
            ->paginate($perPage)
            ->through(function ($vehicle) {
                $booking = Booking::where('vehicle_id', $vehicle->id)
                    ->where('status', 'intransfer')
                    ->first();

                return [
                    'vehicle' => $vehicle,
                    'brand' => $vehicle->brand ? [
                        'id' => $vehicle->brand->id,
                        'name' => $vehicle->brand->name
                    ] : null,
                    'model' => $vehicle->vehicleModel ? [
                        'id' => $vehicle->vehicleModel->id,
                        'name' => $vehicle->vehicleModel->name
                    ] : null,
                    'booker' => $booking ? [
                        'id' => $booking->user_id,
                        'name' => $booking->receiver_name,
                        'email' => $booking->receiver_email,
                    ] : null,
                ];
            });

        return response()->json([
            'success' => true,
            'data' => $vehicles,
        ]);
    }

    // Delivered Vehicles
    public function delivered(Request $request)
    {
        $perPage = $request->get('per_page', 10);
        $search  = $request->get('search', '');

        $vehiclesQuery = Vehicle::where('status', 'delivered')
            ->when($search, function ($query, $search) {
                $query->whereHas('brand', function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%");
                })
                    ->orWhereHas('vehicleModel', function ($q) use ($search) {
                        $q->where('name', 'like', "%{$search}%");
                    });
            });

        $vehicles = $vehiclesQuery->with(['brand:id,name', 'vehicleModel:id,name'])
            ->paginate($perPage)
            ->through(function ($vehicle) {
                $booking = Booking::where('vehicle_id', $vehicle->id)
                    ->where('status', 'delive') // confirm spelling
                    ->first();

                return [
                    'vehicle' => $vehicle,
                    'brand' => $vehicle->brand ? [
                        'id' => $vehicle->brand->id,
                        'name' => $vehicle->brand->name
                    ] : null,
                    'model' => $vehicle->vehicleModel ? [
                        'id' => $vehicle->vehicleModel->id,
                        'name' => $vehicle->vehicleModel->name
                    ] : null,
                    'booker' => $booking ? [
                        'id' => $booking->user_id,
                        'name' => $booking->receiver_name,
                        'email' => $booking->receiver_email,
                    ] : null,
                ];
            });

        return response()->json([
            'success' => true,
            'data' => $vehicles,
        ]);
    }
    public function showVehicleBooking($vehicleId)
    {

        $vehicle = Vehicle::findOrFail($vehicleId);
        $bookings = Booking::where('vehicle_id', $vehicleId)
            ->where('status', 'pending_payment')
            ->get();
        $bids = VehicleBid::where('vehicle_id', $vehicleId)
            ->orderBy('bid_amount', 'desc')
            ->get();

        return response()->json([
            'success' => true,
            'data' => [
                'vehicle' => $vehicle,
                'bookings' => $bookings,
                'bids' => $bids,
            ],
        ]);
    }

    public function showBookingByVehicle($vehicleId)
    {
        try {
            $vehicle = Vehicle::with(['brand:id,name', 'vehicleModel:id,name'])
                ->findOrFail($vehicleId);
            $booking = Booking::where('vehicle_id', $vehicle->id)->first();

            // Get accepted bid of the user who booked this vehicle
            $userAcceptedBid = null;
            if ($booking) {
                $userAcceptedBid = VehicleBid::where('vehicle_id', $vehicle->id)
                    ->where('user_id', $booking->user_id)
                    ->where('status', 'accepted')
                    ->first();
            }

            return response()->json([
                'success' => true,
                'data' => [
                    'vehicle' => $vehicle,
                    'brand' => $vehicle->brand ? [
                        'id' => $vehicle->brand->id,
                        'name' => $vehicle->brand->name,
                    ] : null,
                    'model' => $vehicle->vehicleModel ? [
                        'id' => $vehicle->vehicleModel->id,
                        'name' => $vehicle->vehicleModel->name,
                    ] : null,
                    'booking' => $booking ? [
                        'id' => $booking->id,
                        'user_id' => $booking->user_id,
                        'receiver_name' => $booking->receiver_name,
                        'receiver_email' => $booking->receiver_email,
                        'delivery_type' => $booking->delivery_type,
                        'status' => $booking->status,
                        'total_amount' => $booking->total_amount,
                        'services' => $booking->services ? json_decode($booking->services) : null,
                        'fixed_fees' => $booking->fixed_fees ? json_decode($booking->fixed_fees) : null,
                        'payment_screenshot' => $booking->payment_screenshot,
                        'emirate_id_front' => $booking->emirate_id_front,
                        'emirate_id_back' => $booking->emirate_id_back,
                        'current_location' => $booking->current_location,
                        'delivery_location' => $booking->delivery_location,
                        'location' => $booking->location,
                    ] : null,
                    'accepted_bid' => $userAcceptedBid ? [
                        'id' => $userAcceptedBid->id,
                        'user_id' => $userAcceptedBid->user_id,
                        'bid_amount' => $userAcceptedBid->bid_amount,
                        'status' => $userAcceptedBid->status,
                    ] : null,
                ],
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Vehicle or booking not found',
                'error' => $e->getMessage(),
            ], 404);
        }
    }


    public function changeStatus(Request $request, $vehicleId)
    {
        $validated = $request->validate([
            'status' => 'required|string',
        ]);

        try {
            $vehicle = Vehicle::findOrFail($vehicleId);
            $booking = Booking::where('vehicle_id', $vehicle->id)->first();

            if (!$booking) {
                return response()->json([
                    'success' => false,
                    'message' => 'No booking found for this vehicle.',
                ], 404);
            }
            $booking->status = $validated['status'];
            $booking->save();
            $vehicle->status = $validated['status'];
            $vehicle->save();

            return response()->json([
                'success' => true,
                'message' => 'Booking and vehicle status updated successfully',
                'data' => [
                    'booking_id' => $booking->id,
                    'vehicle_id' => $vehicle->id,
                    'status' => $validated['status'],
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Something went wrong',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
    public function deleteBooking($id)
{
    try {
        $booking = Booking::findOrFail($id);

        // Delete the booking
        $booking->delete();

        return response()->json([
            'success' => true,
            'message' => 'Booking deleted successfully',
        ]);

    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Something went wrong',
            'error' => $e->getMessage(),
        ], 500);
    }
}
}
