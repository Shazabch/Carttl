<?php

namespace App\Http\Controllers\Api\Customer;

use App\Http\Controllers\Controller;
use App\Models\ServiceLocation;
use Illuminate\Http\Request;

class ServicesLocationController extends Controller
{
   public function index(Request $request)
{
    $query = ServiceLocation::query();

    // Optional type filter: service or location
    if ($request->filled('type') && in_array($request->type, ['service', 'location'])) {
        $query->where('type', $request->type);
    }

    // Optional search filter
    if ($request->filled('search')) {
        if ($request->type === 'service') {
            $query->where('service_name', 'like', '%'.$request->search.'%');
        } elseif ($request->type === 'location') {
            $query->where('location', 'like', '%'.$request->search.'%');
        } else {
            // If type not specified, search both fields
            $query->where(function($q) use ($request) {
                $q->where('service_name', 'like', '%'.$request->search.'%')
                  ->orWhere('location', 'like', '%'.$request->search.'%');
            });
        }
    }

    $data = $query->get();

    return response()->json([
        'status' => 'success',
        'data' => $data
    ]);
}

}
