<?php

namespace App\Http\Controllers\Api\Customer;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

}
