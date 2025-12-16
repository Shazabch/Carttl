<?php

namespace App\Http\Controllers\Api\Customer;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;
use App\Models\VehicleBid;
use Illuminate\Support\Facades\Storage;

class BookNowController extends Controller
{


    public function index(Request $request)
    {
        $user = Auth::user();

        // Filters
        $status = $request->get('status'); // e.g., pending_payment, completed, cancelled
        $vehicleId = $request->get('vehicle_id');
        $dateFrom = $request->get('date_from'); // e.g., 2025-12-01
        $dateTo = $request->get('date_to');     // e.g., 2025-12-15

        // Sorting
        $sortBy = $request->get('sort_by', 'created_at'); // default sort
        $sortDir = $request->get('sort_dir', 'desc');     // default direction

        $query = Booking::where('user_id', $user->id);

        // Apply filters
        if ($status) {
            $query->where('status', $status);
        }

        if ($vehicleId) {
            $query->where('vehicle_id', $vehicleId);
        }

        if ($dateFrom) {
            $query->whereDate('created_at', '>=', $dateFrom);
        }

        if ($dateTo) {
            $query->whereDate('created_at', '<=', $dateTo);
        }

        // Include vehicle info
       $query->with(['vehicle', 'vehicle.images']);


        // Apply sorting
        $query->orderBy($sortBy, $sortDir);

        // Pagination (optional)
        $perPage = $request->get('per_page', 10);
        $bookings = $query->paginate($perPage);

        return response()->json([
            'success' => true,
            'data' => $bookings,
        ]);
    }


 public function store(Request $request)
{
    $validated = $request->validate([
        'vehicle_id'         => 'required|exists:vehicles,id',
        'delivery_type'      => 'required|in:self_pickup,door_delivery',
        'delivery_charges'   => 'nullable|numeric|min:0',
        'address'            => 'nullable|string|max:255',
        'receiver_name'      => 'required|string|max:255',
        'receiver_email'     => 'required|email',
        'services'           => 'nullable|array',
        'services.*.name'    => 'required|string',
        'services.*.price'   => 'required|numeric|min:0',
        'fixed_fees'         => 'nullable|array',
        'fixed_fees.*.name'  => 'required|string',
        'fixed_fees.*.price' => 'required|numeric|min:0',
        'payment_screenshot' => 'nullable|file|image|max:5120',
        'emirate_id_front'   => 'nullable|file|image|max:5120',
        'emirate_id_back'    => 'nullable|file|image|max:5120',
        'current_location'   => 'nullable|string|max:255',
        'delivery_location'  => 'nullable|string|max:255',
        'location'           => 'nullable|string|max:255',
    ]);

    DB::beginTransaction();

    try {
        $vehicle = Vehicle::findOrFail($validated['vehicle_id']);

        $approvedBid = VehicleBid::where('vehicle_id', $vehicle->id)
            ->where('status', 'accepted')
            ->orderBy('bid_amount', 'desc')
            ->first();

        if (!$approvedBid) {
            return response()->json([
                'success' => false,
                'message' => 'No approved bid found for this vehicle.',
            ], 400);
        }

        $vehiclePrice = $approvedBid->bid_amount;

        $services  = $validated['services'] ?? [];
        $fixedFees = $validated['fixed_fees'] ?? [];

        $total = $vehiclePrice
            + collect($fixedFees)->sum('price')
            + collect($services)->sum('price')
            + ($validated['delivery_charges'] ?? 0);

        // Reusable file upload function with folder creation
        $uploadFile = function ($file, $folder) {
            if (!$file) return null;

            // Ensure folder exists
            if (!Storage::disk('public')->exists($folder)) {
                Storage::disk('public')->makeDirectory($folder);
            }

            $storedPath = $file->store($folder, 'public');
            return asset('storage/' . $storedPath);
        };

        $paymentScreenshot = $uploadFile($request->file('payment_screenshot'), 'payment_screenshots');
        $emirateFront      = $uploadFile($request->file('emirate_id_front'), 'emirate_ids');
        $emirateBack       = $uploadFile($request->file('emirate_id_back'), 'emirate_ids');

        // Create booking
        $booking = Booking::create([
            'vehicle_id'         => $vehicle->id,
            'user_id'            => Auth::id(),
            'delivery_type'      => $validated['delivery_type'],
            'delivery_charges'   => $validated['delivery_charges'] ?? null,
            'address'            => $validated['address'] ?? null,
            'receiver_name'      => $validated['receiver_name'],
            'receiver_email'     => $validated['receiver_email'],
            'total_amount'       => $total,
            'status'             => 'pending_payment',
            'services'           => !empty($services) ? json_encode($services) : null,
            'fixed_fees'         => !empty($fixedFees) ? json_encode($fixedFees) : null,
            'payment_screenshot' => $paymentScreenshot,
            'emirate_id_front'   => $emirateFront,
            'emirate_id_back'    => $emirateBack,
            'current_location'   => $validated['current_location'] ?? null,
            'delivery_location'  => $validated['delivery_location'] ?? null,
            'location'           => $validated['location'] ?? null,
        ]);

        // Update vehicle status
        $vehicle->status = 'pending_payment';
        $vehicle->save();

        DB::commit();

        return response()->json([
            'success' => true,
            'message' => 'Booking created successfully',
            'data'    => [
                'booking' => $booking,
                'total'   => $total,
            ],
        ]);
    } catch (\Exception $e) {
        DB::rollBack();
        return response()->json([
            'success' => false,
            'message' => 'Something went wrong',
            'error'   => $e->getMessage(),
        ], 500);
    }
}



  public function update(Request $request, $id)
{
    $booking = Booking::findOrFail($id);

    $validated = $request->validate([
        'vehicle_id'         => 'nullable|exists:vehicles,id',
        'delivery_type'      => 'nullable|in:self_pickup,door_delivery',
        'delivery_charges'   => 'nullable|numeric|min:0',
        'address'            => 'nullable|string|max:255',
        'receiver_name'      => 'nullable|string|max:255',
        'receiver_email'     => 'nullable|email',
        'services'           => 'nullable|array',
        'services.*.name'    => 'required|string',
        'services.*.price'   => 'required|numeric|min:0',
        'fixed_fees'         => 'nullable|array',
        'fixed_fees.*.name'  => 'required|string',
        'fixed_fees.*.price' => 'required|numeric|min:0',
        'payment_screenshot' => 'nullable|file|image|max:5120',
        'emirate_id_front'   => 'nullable|file|image|max:5120',
        'emirate_id_back'    => 'nullable|file|image|max:5120',
        'current_location'   => 'nullable|string|max:255',
        'delivery_location'  => 'nullable|string|max:255',
        'location'           => 'nullable|string|max:255',
        'status'             => 'nullable|string',
    ]);

    DB::beginTransaction();

    try {
        $vehicle = $booking->vehicle;

        // Update vehicle if vehicle_id is provided
        if (isset($validated['vehicle_id'])) {
            $vehicle = Vehicle::findOrFail($validated['vehicle_id']);
        }

        // Get approved bid
        $approvedBid = VehicleBid::where('vehicle_id', $vehicle->id)
            ->where('status', 'accepted')
            ->orderBy('bid_amount', 'desc')
            ->first();

        if (!$approvedBid) {
            return response()->json([
                'success' => false,
                'message' => 'No approved bid found for this vehicle.',
            ], 400);
        }

        $vehiclePrice = $approvedBid->bid_amount;

        $services  = $validated['services'] ?? json_decode($booking->services, true) ?? [];
        $fixedFees = $validated['fixed_fees'] ?? json_decode($booking->fixed_fees, true) ?? [];

        $total = $vehiclePrice
            + collect($fixedFees)->sum('price')
            + collect($services)->sum('price')
            + ($validated['delivery_charges'] ?? $booking->delivery_charges ?? 0);

        // Reusable function to handle file uploads and old file deletion
        $uploadFile = function ($file, $folder, $oldFile = null) {
            if (!$file) return $oldFile;

            // Ensure folder exists
            if (!Storage::disk('public')->exists($folder)) {
                Storage::disk('public')->makeDirectory($folder);
            }

            // Delete old file if exists
            if ($oldFile) {
                $relativePath = str_replace(asset('storage') . '/', '', $oldFile);
                Storage::disk('public')->delete($relativePath);
            }

            $storedPath = $file->store($folder, 'public');
            return asset('storage/' . $storedPath);
        };

        $paymentScreenshot = $uploadFile($request->file('payment_screenshot'), 'payment_screenshots', $booking->payment_screenshot);
        $emirateFront      = $uploadFile($request->file('emirate_id_front'), 'emirate_ids', $booking->emirate_id_front);
        $emirateBack       = $uploadFile($request->file('emirate_id_back'), 'emirate_ids', $booking->emirate_id_back);

        // Update booking
        $booking->update([
            'vehicle_id'         => $vehicle->id,
            'delivery_type'      => $validated['delivery_type'] ?? $booking->delivery_type,
            'delivery_charges'   => $validated['delivery_charges'] ?? $booking->delivery_charges,
            'address'            => $validated['address'] ?? $booking->address,
            'receiver_name'      => $validated['receiver_name'] ?? $booking->receiver_name,
            'receiver_email'     => $validated['receiver_email'] ?? $booking->receiver_email,
            'total_amount'       => $total,
            'status'             => $validated['status'] ?? $booking->status,
            'services'           => !empty($services) ? json_encode($services) : null,
            'fixed_fees'         => !empty($fixedFees) ? json_encode($fixedFees) : null,
            'payment_screenshot' => $paymentScreenshot,
            'emirate_id_front'   => $emirateFront,
            'emirate_id_back'    => $emirateBack,
            'current_location'   => $validated['current_location'] ?? $booking->current_location,
            'delivery_location'  => $validated['delivery_location'] ?? $booking->delivery_location,
            'location'           => $validated['location'] ?? $booking->location,
        ]);

        // Update vehicle status
        $vehicle->status = 'pending_payment';
        $vehicle->save();

        DB::commit();

        return response()->json([
            'success' => true,
            'message' => 'Booking updated successfully',
            'data' => [
                'booking' => $booking,
                'total'   => $total,
            ],
        ]);
    } catch (\Exception $e) {
        DB::rollBack();
        return response()->json([
            'success' => false,
            'message' => 'Something went wrong',
            'error'   => $e->getMessage(),
        ], 500);
    }
}

}
