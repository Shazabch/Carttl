<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Package;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PackageController extends Controller
{

  public function index(Request $request)
{
    $search = $request->input('search');

    $packages = Package::when($search, function ($query) use ($search) {
            $query->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
        })
        ->latest()
        ->paginate(10);

    return response()->json([
        'status'  => 'success',
        'message' => 'Packages fetched successfully.',
        'data'    => $packages
    ]);
}



    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'          => 'required|string|max:255',
            'description'   => 'nullable|string',
            'price'         => 'required|numeric|min:0',
            'duration_days' => 'required|integer|min:1',
            'features'      => 'nullable|array', 
            'features.*'    => 'string',
        ]);

        $package = Package::create($validated);

        return response()->json([
            'status'  => 'success',
            'message' => 'Package created successfully.',
            'data'    => $package
        ], 201);
    }


    public function show($id)
    {
        $package = Package::find($id);

        if (!$package) {
            return response()->json([
                'status' => 'error',
                'message' => 'Package not found.'
            ], 404);
        }

        return response()->json([
            'status'  => 'success',
            'message' => 'Package details fetched successfully.',
            'data'    => $package
        ]);
    }


    public function update(Request $request, $id)
    {
        $package = Package::find($id);

        if (!$package) {
            return response()->json([
                'status' => 'error',
                'message' => 'Package not found.'
            ], 404);
        }

        $validated = $request->validate([
            'name'          => 'sometimes|required|string|max:255',
            'description'   => 'nullable|string',
            'price'         => 'sometimes|required|numeric|min:0',
            'duration_days' => 'sometimes|required|integer|min:1',
            'features'      => 'nullable|array',
            'features.*'    => 'string',
        ]);

        $package->update($validated);

        return response()->json([
            'status'  => 'success',
            'message' => 'Package updated successfully.',
            'data'    => $package
        ]);
    }


    public function destroy($id)
    {
        $package = Package::find($id);

        if (!$package) {
            return response()->json([
                'status' => 'error',
                'message' => 'Package not found.'
            ], 404);
        }

        $package->delete();

        return response()->json([
            'status'  => 'success',
            'message' => 'Package deleted successfully.'
        ]);
    }
}
