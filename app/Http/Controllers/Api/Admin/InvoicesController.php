<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Invoice;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class InvoicesController extends Controller
{
    // -----------------------------
    // Booking Invoices List
    // -----------------------------
    public function bookingIndex(Request $request)
    {
        $perPage = $request->input('per_page', 25);
        $query = Invoice::where('type', 'booking');

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
        $perPage = $request->input('per_page', 25);
        $query = Invoice::where('type', 'package');

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
            $pdfLink = \App\Services\BookingInvoiceService::generate($booking->id);

            $invoice = Invoice::create([
                'type'       => 'booking',
                'booking_id' => $booking->id,
                'pdf_link'   => $pdfLink,
            ]);
        } else {
            $user = User::findOrFail($request->user_id);
            $pdfLink = \App\Services\PackageInvoiceService::generate($user->id);

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
}
