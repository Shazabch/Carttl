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
use App\Services\BookingInvoiceService;
use Illuminate\Support\Facades\Storage;
use App\Notifications\BookingStatusChangedNotification;
use App\Services\FCMService;
use Illuminate\Support\Facades\Log;

class BookingController extends Controller
{
    public function pendingPayments(Request $request)
    {
        $perPage = $request->get('per_page', 10);
        $search  = $request->get('search', '');
        $user = auth('api')->user();

        $vehiclesQuery = Vehicle::where('status', 'pending_payment');
        
        // If logged-in user is an agent, filter to show only vehicles with bookings from their customers
        if ($user && $user->hasRole('agent')) {
            $vehiclesQuery->whereHas('bookings', function ($q) use ($user) {
                $q->whereHas('user', function ($inner) use ($user) {
                    $inner->where('agent_id', $user->id);
                });
            });
        }
        
        $vehiclesQuery->when($search, function ($query, $search) {
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

    public function listed(Request $request)
    {
        $perPage = $request->get('per_page', 10);
        $search  = $request->get('search', '');
        $user = auth('api')->user();

        $vehiclesQuery = Vehicle::where('status', 'bid_approved')->where('is_auction', true);
        
        // If logged-in user is an agent, filter to show only vehicles with bookings from their customers
        if ($user && $user->hasRole('agent')) {
            $vehiclesQuery->whereHas('bookings', function ($q) use ($user) {
                $q->whereHas('user', function ($inner) use ($user) {
                    $inner->where('agent_id', $user->id);
                });
            });
        }
        
        $vehiclesQuery->when($search, function ($query, $search) {
            $query->whereHas('brand', function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%");
            })
                ->orWhereHas('vehicleModel', function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%");
                });
        });

        $vehicles = $vehiclesQuery
            ->with([
                'brand:id,name',
                'vehicleModel:id,name'
            ])
            ->paginate($perPage)
            ->through(function ($vehicle) {
                $approvedBid = \App\Models\VehicleBid::where('vehicle_id', $vehicle->id)
                    ->where('status', 'accepted')
                    ->with('user:id,name,email')
                    ->orderBy('bid_amount', 'desc')
                    ->first();

                return [
                    'vehicle' => [
                        'id' => $vehicle->id,
                        'title' => $vehicle->title ?? null,
                        'status' => $vehicle->status,
                    ],
                    'brand' => $vehicle->brand ? [
                        'id' => $vehicle->brand->id,
                        'name' => $vehicle->brand->name,
                    ] : null,
                    'model' => $vehicle->vehicleModel ? [
                        'id' => $vehicle->vehicleModel->id,
                        'name' => $vehicle->vehicleModel->name,
                    ] : null,
                    'approved_bid' => $approvedBid ? [
                        'id' => $approvedBid->id,
                        'bid_amount' => $approvedBid->bid_amount,
                        'user' => $approvedBid->user ? [
                            'id' => $approvedBid->user->id,
                            'name' => $approvedBid->user->name,
                            'email' => $approvedBid->user->email,
                        ] : null,
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
        $user = auth('api')->user();

        $vehiclesQuery = Vehicle::where('status', 'intransfer');
        
        // If logged-in user is an agent, filter to show only vehicles with bookings from their customers
        if ($user && $user->hasRole('agent')) {
            $vehiclesQuery->whereHas('bookings', function ($q) use ($user) {
                $q->whereHas('user', function ($inner) use ($user) {
                    $inner->where('agent_id', $user->id);
                });
            });
        }
        
        $vehiclesQuery->when($search, function ($query, $search) {
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
        $user = auth('api')->user();

        $vehiclesQuery = Vehicle::where('status', 'delivered');
        
        // If logged-in user is an agent, filter to show only vehicles with bookings from their customers
        if ($user && $user->hasRole('agent')) {
            $vehiclesQuery->whereHas('bookings', function ($q) use ($user) {
                $q->whereHas('user', function ($inner) use ($user) {
                    $inner->where('agent_id', $user->id);
                });
            });
        }
        
        $vehiclesQuery->when($search, function ($query, $search) {
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
                    ->where('status', 'delivered') // confirm spelling
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

    public function showBookingByVehicle($vehicleId)
    {
        try {
            $vehicle = Vehicle::with([
                'brand:id,name',
                'vehicleModel:id,name',
                'images:id,vehicle_id,path'
            ])->findOrFail($vehicleId);

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
                    'vehicle' => array_merge(
                        $vehicle->toArray(),
                        [
                            'images' => $vehicle->images->map(function ($image) {
                                return [
                                    'id' => $image->id,
                                    'url' => $image->path,
                                ];
                            }),
                        ]
                    ),
                    'booking' => $booking ? [
                        'id' => $booking->id,
                        'user_id' => $booking->user_id,
                        'receiver_name' => $booking->receiver_name,
                        'receiver_email' => $booking->receiver_email,
                        'delivery_type' => $booking->delivery_type,
                        'status' => $booking->status,
                        'total_amount' => $booking->total_amount,
                        'services'    => $booking->services,
                        'fixed_fees'  => $booking->fixed_fees,
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
            $booking = Booking::with('user')->where('vehicle_id', $vehicle->id)->first();

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

            // Send notification to user
            if ($booking->user) {
                try {
                    // Send email and database notification
                    $booking->user->notify(new BookingStatusChangedNotification($booking, $validated['status']));

                    // Send push notification via Firebase
                    $this->sendPushNotification($booking, $validated['status']);
                } catch (\Exception $notificationError) {
                    Log::error("Failed to send notification for booking {$booking->id}: " . $notificationError->getMessage());
                }
            }

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

    /**
     * Send push notification to user via Firebase Cloud Messaging
     */
    private function sendPushNotification($booking, $newStatus)
    {
        try {
            $user = $booking->user;
            if (!$user) {
                return;
            }

            // Get user's device tokens
            $deviceTokens = DB::table('device_tokens')
                ->where('user_id', $user->id)
                ->pluck('device_token')
                ->toArray();

            if (empty($deviceTokens)) {
                Log::info("No device tokens found for user {$user->id}");
                return;
            }

            $fcmService = new FCMService();
            $vehicle = $booking->vehicle;
            $vehicleTitle = $vehicle ? ($vehicle->title ?? 'Your Vehicle') : 'Your Vehicle';
            $title = "Booking Status Updated";
            $body = "Your booking for {$vehicleTitle} is now " . ucfirst(str_replace('_', ' ', $newStatus));
            $data = [
                'booking_id' => (string) $booking->id,
                'vehicle_id' => (string) $booking->vehicle_id,
                'status' => $newStatus,
                'action' => 'booking_status_changed',
            ];

            // Send to all device tokens
            foreach ($deviceTokens as $token) {
                try {
                    $fcmService->sendNotification($token, $title, $body, $data);
                    Log::info("Push notification sent to user {$user->id} for booking {$booking->id}");
                } catch (\Exception $e) {
                    Log::error("Failed to send push notification to token {$token}: " . $e->getMessage());
                }
            }
        } catch (\Exception $e) {
            Log::error("Error in sendPushNotification: " . $e->getMessage());
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

    public function generateBookingPdf(Request $request)
    {
        $request->validate([
            'booking_id' => 'required|exists:bookings,id',
        ]);

        $booking = Booking::findOrFail($request->booking_id);

        // Generate PDF using service
        $invoiceLink = BookingInvoiceService::generate($booking->id);

        // Optional: save link in bookings table
        $booking->update([
            'invoice_link' => $invoiceLink
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Invoice generated successfully',
            'data' => [
                'booking_id'  => $booking->id,
                'invoice_url' => $invoiceLink
            ]
        ]);
    }
}
