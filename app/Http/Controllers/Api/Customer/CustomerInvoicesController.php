<?php

namespace App\Http\Controllers\Api\Customer;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use App\Models\User;
use App\Notifications\PaymentSlipUploadedNotification;
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
                'booking.vehicle.brand',
                'booking.vehicle.vehicleModel',
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

        // Ensure invoices directory exists on the public disk
        if (! Storage::disk('public')->exists('invoices')) {
            Storage::disk('public')->makeDirectory('invoices');
        }

        // Filename like: payment_slip_invoice_123_20260113_123000.jpg
        $fileName = 'payment_slip_invoice_' . $invoice->id . '_' . now()->format('Ymd_His') . '.' . $file->getClientOriginalExtension();

        // Store under public/invoices
        $storedPath = Storage::disk('public')->putFileAs('invoices', $file, $fileName);

        // Build full public URL using the same approach as invoice PDFs
        $invoice->payment_slip = asset('storage/' . $storedPath);
        $invoice->save();

        // Send notifications to admins, super admins, and assigned agent
        $this->sendPaymentSlipNotifications($user, $invoice);

        return response()->json([
            'status' => true,
            'message' => 'Payment slip uploaded',
            'data' => $invoice
        ]);
    }

    /**
     * Send notifications to admins, super admins, and assigned agent
     */
    private function sendPaymentSlipNotifications($user, $invoice)
    {
        $notificationRecipients = [];

        // Get all users with admin or super-admin roles using whereHas
        $admins = User::whereHas('roles', function ($query) {
            $query->whereIn('name', ['admin', 'super-admin']);
        })->get();

        foreach ($admins as $admin) {
            $notificationRecipients[] = $admin;
        }

        // Get assigned agent if user has agent_id
        if ($user->agent_id !== null) {
            $agent = User::find($user->agent_id);
            if ($agent && !in_array($agent->id, collect($notificationRecipients)->pluck('id')->toArray())) {
                $notificationRecipients[] = $agent;
            }
        }

        // Send notification to all recipients
        foreach ($notificationRecipients as $recipient) {
            $recipient->notify(new PaymentSlipUploadedNotification($invoice, $user));
        }
    }
}
