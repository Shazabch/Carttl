<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\PackageInvoiceService;

class InvoiceController extends Controller
{
    public function generatePackageInvoiceByUser(Request $request)
    {
       $userId = auth()->id();
       $request->merge(['user_id' => $userId]);
        try {
            $pdfUrl = PackageInvoiceService::generate($request->user_id);

            return response()->json([
                'status'  => 'success',
                'message' => 'Package Invoice PDF generated successfully.',
                'data'    => [
                    'pdf_url' => $pdfUrl,
                ],
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'status'  => 'error',
                'message' => $e->getMessage(),
            ], 500);
        }
    }
}
