<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Invoice;
use App\Models\Package;
use App\Models\User;
use App\Services\BookingInvoiceService;
use App\Services\PackageInvoiceService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class InvoicesController extends Controller
{
    // -----------------------------
    // Booking Invoices List
    // -----------------------------
    public function bookingIndex(Request $request)
    {
        $user = auth('api')->user();
        $perPage = $request->input('per_page', 25);
        $query = Invoice::where('type', 'booking');

        // Agent role restriction - show invoices from their assigned customers
        if ($user && $user->hasRole('agent')) {
            $query->whereHas('user', fn($q) =>
                $q->where('agent_id', $user->id)
            );
        }

        // Filter by booking_id
        if ($request->filled('booking_id')) {
            $query->where('booking_id', $request->booking_id);
        }

        // Simple search by invoice id, pdf_link, or vehicle name
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('id', $search)
                    ->orWhere('pdf_link', 'like', "%{$search}%")
                    ->orWhereHas('booking.vehicle', function ($q2) use ($search) {
                        $q2->where('name', 'like', "%{$search}%");
                    });
            });
        }

        $invoices = $query->latest()->paginate($perPage);

        // Add related booking info
        $invoices->getCollection()->transform(function ($invoice) {
            if ($invoice->booking_id) {
                $invoice->booking = Booking::with('vehicle')->find($invoice->booking_id);
            }
            return $invoice;
        });

        return response()->json([
            'status' => true,
            'data'   => $invoices,
        ]);
    }

    // -----------------------------
    // Package Invoices List
    // -----------------------------
    public function packageIndex(Request $request)
    {
        $user = auth('api')->user();
        $perPage = $request->input('per_page', 25);
        $query = Invoice::where('type', 'package');

        // Agent role restriction - show invoices from their assigned customers
        if ($user && $user->hasRole('agent')) {
            $query->whereHas('user', fn($q) =>
                $q->where('agent_id', $user->id)
            );
        }

        // Filter by user_id
        if ($request->filled('user_id')) {
            $query->where('user_id', $request->user_id);
        }

        // Simple search by invoice id, pdf_link, user name, or package name
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('id', $search)
                    ->orWhere('pdf_link', 'like', "%{$search}%")
                    ->orWhereHas('user', function ($q2) use ($search) {
                        $q2->where('name', 'like', "%{$search}%")
                            ->orWhereHas('package', function ($q3) use ($search) {
                                $q3->where('name', 'like', "%{$search}%");
                            });
                    });
            });
        }

        $invoices = $query->latest()->paginate($perPage);

        // Add related user & package info
        $invoices->getCollection()->transform(function ($invoice) {
            if ($invoice->user_id) {
                $user = User::with('package')->find($invoice->user_id);
                $invoice->user = $user;
            }
            return $invoice;
        });

        return response()->json([
            'status' => true,
            'data'   => $invoices,
        ]);
    }


    public function allCustomers(Request $request)
    {
        $query = User::where('role', 'customer');

        // Simple search (name, email)
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $customers = $query->latest()->get();

        return response()->json([
            'status' => true,
            'data'   => $customers,
        ]);
    }


    public function allBookings(Request $request)
    {
        $query = Booking::query();

        // Simple search (only booking table columns)
        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('id', $search)
                    ->orWhere('booking_no', 'like', "%{$search}%")
                    ->orWhere('status', 'like', "%{$search}%");
            });
        }

        $bookings = $query->latest()->get();

        return response()->json([
            'status' => true,
            'data'   => $bookings,
        ]);
    }
    // Show single invoice (same as before)
    public function show($id)
    {
        $invoice = Invoice::find($id);

        if (! $invoice) {
            return response()->json([
                'status'  => false,
                'message' => 'Invoice not found',
            ], 404);
        }

        $data = [
            'id'         => $invoice->id,
            'type'       => $invoice->type,
            'pdf_link'   => $invoice->pdf_link,
            'created_at' => $invoice->created_at,
            'updated_at' => $invoice->updated_at,
        ];

        if ($invoice->type === 'booking' && $invoice->booking_id) {
            $data['booking'] = Booking::with('vehicle')->find($invoice->booking_id);
        } elseif ($invoice->type === 'package' && $invoice->user_id) {
            $user = User::with('package')->find($invoice->user_id);
            $data['user'] = $user;
        }

        return response()->json([
            'status' => true,
            'data'   => $data,
        ]);
    }

    // Delete an invoice
    public function destroy($id)
    {
        $invoice = Invoice::find($id);

        if (! $invoice) {
            return response()->json([
                'status'  => false,
                'message' => 'Invoice not found',
            ], 404);
        }

        if ($invoice->pdf_link) {
            $filePath = str_replace(asset('storage/'), '', $invoice->pdf_link);
            Storage::disk('public')->delete($filePath);
        }

        $invoice->delete();

        return response()->json([
            'status'  => true,
            'message' => 'Invoice deleted successfully',
        ]);
    }

    // Generate invoice (same as before)
    public function generate(Request $request)
    {
        $request->validate([
            'type'       => 'required|in:booking,package',
            'booking_id' => 'required_if:type,booking|exists:bookings,id',
            'user_id'    => 'required_if:type,package|exists:users,id',
        ]);

        if ($request->type === 'booking') {
            $booking = Booking::findOrFail($request->booking_id);
            $pdfLink = BookingInvoiceService::generate($booking->id);

            $invoice = Invoice::create([
                'type'       => 'booking',
                'booking_id' => $booking->id,
                'user_id'    => $booking->user_id,
                'pdf_link'   => $pdfLink,
            ]);
        } else {
            $user = User::findOrFail($request->user_id);

            // Check if user has a package
            if (! $user->package_id) {
                return response()->json([
                    'status'  => false,
                    'message' => 'User does not have any package',
                ], 422);
            }

            // Check if package exists
            $packageExists = Package::where('id', $user->package_id)->exists();

            if (! $packageExists) {
                return response()->json([
                    'status'  => false,
                    'message' => 'Package not found',
                ], 404);
            }

            // Generate package invoice
            $pdfLink = PackageInvoiceService::generate($user->id);

            // Save invoice
            $invoice = Invoice::create([
                'type'     => 'package',
                'user_id'  => $user->id,
                'pdf_link' => $pdfLink,
            ]);
        }


        return response()->json([
            'status'  => true,
            'message' => 'Invoice generated successfully',
            'data'    => $invoice,
            'pdf_url' => $pdfLink,
        ]);
    }


    /**
     * Mark an invoice as paid (admin)
     *
     * Request: invoice_id (int)
     */
    public function markAsPaid(Request $request)
    {
        $request->validate([
            'invoice_id' => 'required|integer|exists:invoices,id',
        ]);

        $invoice = Invoice::find($request->invoice_id);

        if (! $invoice) {
            return response()->json([
                'status'  => false,
                'message' => 'Invoice not found',
            ], 404);
        }

        $invoice->status = 'paid';
        $invoice->save();

        // If this is a package invoice, approve the user associated with it
        if ($invoice->type === 'package' && $invoice->user_id) {
            $user = User::find($invoice->user_id);
            if ($user) {
                $user->status = 'approved';
                $user->save();
            }
        }

        return response()->json([
            'status'  => true,
            'message' => 'Invoice marked as paid',
            'data'    => $invoice,
        ]);
    }
}
