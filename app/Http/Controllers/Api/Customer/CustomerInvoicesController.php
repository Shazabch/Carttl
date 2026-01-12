<?php

namespace App\Http\Controllers\Api\Customer;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CustomerInvoicesController extends Controller
{
  public function index(Request $request)
{
    $user = Auth::guard('api')->user();

    if (! $user) {
        return response()->json([
            'status' => false,
            'message' => 'Unauthenticated'
        ], 401);
    }

    $perPage = $request->input('per_page', 25);

    $query = Invoice::where('user_id', $user->id)
        ->with([
            'booking.vehicle',
            'user.package'
        ]);

    // Optional filter: type (booking / package)
    if ($request->filled('type')) {
        $query->where('type', $request->type);
    }

    // Optional search (id, pdf_link, ersch)
    if ($request->filled('search')) {
        $search = $request->search;
        $query->where(function ($q) use ($search) {
            $q->where('id', $search)
                ->orWhere('pdf_link', 'like', "%{$search}%")
                ->orWhere('ersch', 'like', "%{$search}%"); // <-- added ersch
        });
    }

    $invoices = $query->latest()->paginate($perPage);

    return response()->json([
        'status' => true,
        'data'   => $invoices
    ]);
}


    public function show($id)
{
    $user = Auth::guard('api')->user();

    $invoice = Invoice::where('id', $id)
        ->where('user_id', $user->id)
        ->with(['booking.vehicle', 'user.package'])
        ->first();

    if (! $invoice) {
        return response()->json([
            'status' => false,
            'message' => 'Invoice not found'
        ], 404);
    }

    return response()->json([
        'status' => true,
        'data'   => $invoice
    ]);
}


    /**
     * Upload payment slip for a package/booking invoice
     *
     * Expected inputs: invoice_id (int), payment_slip (file)
     */
    public function uploadPayment(Request $request)
    {
       
        $user = Auth::guard('api')->user();

        if (! $user) {
            return response()->json([
                'status' => false,
                'message' => 'Unauthenticated'
            ], 401);
        }

        $request->validate([
            'invoice_id' => 'required|integer|exists:invoices,id',
            'payment_slip' => 'required',
        ]);

        $invoice = Invoice::where('id', $request->invoice_id)
            ->where('user_id', $user->id)
            ->first();

        if (! $invoice) {
            return response()->json([
                'status' => false,
                'message' => 'Invoice not found'
            ], 404);
        }

        $file = $request->file('payment_slip');
        $filename = Str::random(12) . '_' . time() . '.' . $file->getClientOriginalExtension();
    $path = $file->storeAs('public/payments', $filename);

    // create a full URL to the stored file (e.g. https://example.com/storage/payments/xxx)
    $publicPath = Storage::url($path); // usually '/storage/payments/filename'
    $invoice->payment_slip = asset($publicPath);
        $invoice->save();

        return response()->json([
            'status' => true,
            'message' => 'Payment slip uploaded',
            'data' => $invoice
        ]);
    }

}
