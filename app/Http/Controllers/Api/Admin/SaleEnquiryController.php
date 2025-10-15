<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\VehicleEnquiry;
use Illuminate\Support\Facades\Storage;

class SaleEnquiryController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search', '');
        $perPage = $request->get('per_page', 10);

        $enquiries = VehicleEnquiry::query()
            ->where('type', 'sale')
            ->with(['brand:id,name', 'vehicleModel:id,name', 'imageSet'])
            ->when($search, function ($query) use ($search) {
                $query->where('name', 'like', "%{$search}%")
                    ->orWhere('number', 'like', "%{$search}%")
                    ->orWhereHas('brand', function ($q) use ($search) {
                        $q->where('name', 'like', "%{$search}%");
                    })
                    ->orWhereHas('vehicleModel', function ($q) use ($search) {
                        $q->where('name', 'like', "%{$search}%");
                    });
            })
            ->latest()
            ->paginate($perPage);

        return response()->json([
            'status' => 'success',
            'data' => $enquiries,
        ]);
    }


    public function show($id)
    {
        $enquiry = VehicleEnquiry::where('type', 'sale')
            ->with(['brand:id,name', 'vehicleModel:id,name', 'imageSet'])
            ->findOrFail($id);

        return response()->json([
            'status' => 'success',
            'data' => $enquiry,
        ]);
    }

    public function destroy($id)
    {
        $enquiry = VehicleEnquiry::where('type', 'sale')
            ->with('imageSet')
            ->findOrFail($id);

        
        if ($enquiry->imageSet) {
            $imagesToDelete = [];

            foreach (range(1, 6) as $i) {
                $imagePath = $enquiry->imageSet->{'image' . $i};
                if ($imagePath) {
                    $imagesToDelete[] = $imagePath;
                }
            }

            if (!empty($imagesToDelete)) {
                Storage::disk('public')->delete($imagesToDelete);
            }

            $enquiry->imageSet->delete();
        }

        $enquiry->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Sale enquiry deleted successfully.',
        ]);
    }
}
